<?php namespace Kaamaru\Forums;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Kaamaru\Forums\Core\Auth\EloquentUserProvider;
use Kaamaru\Forums\Core\Html\HtmlBuilder;

class ForumsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Kaamaru\Forums');
        \Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new ValidationRules($translator, $data, $rules, $messages);
        });

        \Auth::extend('eloquent', function ($app) {
            $model = $this->app['config']['auth.model'];
            return new EloquentUserProvider($this->app['hash'], $model);
        });
        require __DIR__ . '/Http/breadcrumbs.php';
    }

    public function register()
    {
        // Load forums routes
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../../routes.php';
        }

        $this->app->bind('counter', 'Kaamaru\Forums\Core\Counters\Redis\RedisCounter');
        $this->app->bind('markdown', 'Kaamaru\Forums\Core\Markdown\Markdown');
        $this->app->bind('flash', 'Kaamaru\Forums\Core\Flash\Flash');
        $this->app->bind('bouncer', 'Kaamaru\Forums\Core\Auth\Bouncer');
        $this->app->bind('finediff', 'cogpowered\FineDiff\Diff');
        $this->app->bind('Kaamaru\Forums\Forums\Forums\ForumRepoInterface',
            'Kaamaru\Forums\Forums\Forums\EloquentForumRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Topics\TopicRepoInterface',
            'Kaamaru\Forums\Forums\Topics\EloquentTopicRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Posts\PostRepoInterface',
            'Kaamaru\Forums\Forums\Posts\EloquentPostRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Topics\Favorite\FavoriteRepoInterface',
            'Kaamaru\Forums\Forums\Topics\Favorite\EloquentFavoriteRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Posts\Vote\PostVoteRepoInterface',
            'Kaamaru\Forums\Forums\Posts\Vote\EloquentPostVoteRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Posts\Report\PostReportRepoInterface',
            'Kaamaru\Forums\Forums\Posts\Report\EloquentPostReportRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Forums\Read\ForumReadRepoInterface',
            'Kaamaru\Forums\Forums\Forums\Read\EloquentForumReadRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Topics\Read\TopicReadRepoInterface',
            'Kaamaru\Forums\Forums\Topics\Read\EloquentTopicReadRepo');
        $this->app->bind('Kaamaru\Forums\Forums\Topics\Follow\FollowRepoInterface',
            'Kaamaru\Forums\Forums\Topics\Follow\EloquentFollowRepo');
        $this->app->bind('Kaamaru\Forums\Users\Group\UserGroupRepoInterface',
            'Kaamaru\Forums\Users\Group\EloquentUserGroupRepo');
        $this->app->view->composer('forums.topics._reply', 'Kaamaru\Forums\Forums\Posts\QuotesComposer');
        $this->app->view->composer('forums.move_post', 'Kaamaru\Forums\Forums\Posts\MovePostComposer');

        // Register aliases
        AliasLoader::getInstance()->alias('Breadcrumbs','DaveJamesMiller\Breadcrumbs\Facade');
        AliasLoader::getInstance()->alias('Form','Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias('Html','Collective\Html\HtmlFacade');
        AliasLoader::getInstance()->alias('Bouncer','Kaamaru\Forums\Core\Facades\Bouncer');

        // Register service providers
        $this->app->register('DaveJamesMiller\Breadcrumbs\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');

        // Override HTML builder to add some useful methods
        $this->app->bindShared('html', function ($app) {
            return new HtmlBuilder($app['url']);
        });
    }
}