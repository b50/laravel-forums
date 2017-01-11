<?php namespace Kaamaru\Forums;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Kaamaru\Forums\Core\Auth\EloquentUserProvider;
use Kaamaru\Forums\Core\Validation\ValidationRules;

class ForumsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'Kaamaru\Forums');
        \Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new ValidationRules($translator, $data, $rules, $messages);
        });

        \Auth::extend('eloquent', function ($app) {
            $model = $this->app['config']['auth.model'];
            return new EloquentUserProvider($this->app['hash'], $model);
        });

        // Save config
        $this->publishes([
            __DIR__.'/../config/forums.php' => config_path('forums.php'),
        ]);

        require __DIR__ . '/../breadcrumbs.php';
    }

    public function register()
    {
        // Load forums routes
        if ( ! $this->app->routesAreCached()) {
            require __DIR__ . '/../routes/web.php';
        }

        // Load config
        $this->mergeConfigFrom(
            __DIR__.'/../config/forums.php', 'forums'
        );

        // Add views
        $this->app->view->addLocation(__DIR__ . '/../resources/views');

        // Bind classes
        $this->app->bind(
            'counter',
            'Kaamaru\Forums\Core\Counters\Redis\RedisCounter'
        );
        $this->app->bind(
            'markdown',
            'Kaamaru\Forums\Core\Markdown\Markdown'
        );
        $this->app->bind(
            'flash',
            'Kaamaru\Forums\Core\Flash\Flash'
        );
        $this->app->bind(
            'bouncer',
            'Kaamaru\Forums\Core\Auth\Bouncer'
        );
        $this->app->bind(
            'finediff',
            'cogpowered\FineDiff\Diff'
        );
        $this->app->bind(
            'Kaamaru\Forums\Forums\ForumRepoInterface',
            'Kaamaru\Forums\Forums\EloquentForumRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Topics\TopicRepoInterface',
            'Kaamaru\Forums\Topics\EloquentTopicRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Posts\PostRepoInterface',
            'Kaamaru\Forums\Posts\EloquentPostRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Topics\Favorite\FavoriteRepoInterface',
            'Kaamaru\Forums\Topics\Favorite\EloquentFavoriteRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Posts\Vote\PostVoteRepoInterface',
            'Kaamaru\Forums\Posts\Vote\EloquentPostVoteRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Posts\Report\PostReportRepoInterface',
            'Kaamaru\Forums\Posts\Report\EloquentPostReportRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Read\ForumReadRepoInterface',
            'Kaamaru\Forums\Read\EloquentForumReadRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Topics\Read\TopicReadRepoInterface',
            'Kaamaru\Forums\Topics\Read\EloquentTopicReadRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Topics\Follow\FollowRepoInterface',
            'Kaamaru\Forums\Topics\Follow\EloquentFollowRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Users\Group\UserGroupRepoInterface',
            'Kaamaru\Forums\Users\Group\EloquentUserGroupRepo'
        );
        $this->app->bind(
            'Kaamaru\Forums\Users\UserRepoInterface',
            'Kaamaru\Forums\Users\EloquentUserRepo'
        );
        $this->app->view->composer(
            'forums.topics._reply',
            'Kaamaru\Forums\Posts\QuotesComposer'
        );
        $this->app->view->composer(
            'forums.move_post',
            'Kaamaru\Forums\Posts\MovePostComposer'
        );
        // Register aliases
        AliasLoader::getInstance()->alias(
            'Breadcrumbs',
            'DaveJamesMiller\Breadcrumbs\Facade'
        );
        AliasLoader::getInstance()->alias(
            'Bouncer',
            'Kaamaru\Forums\Core\Facades\Bouncer'
        );

        // Register service providers
        $this->app->register('DaveJamesMiller\Breadcrumbs\ServiceProvider');
    }
}