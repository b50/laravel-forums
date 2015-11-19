<?php namespace Kaamaru\Forums;

use Illuminate\Support\ServiceProvider;
use Kaamaru\Forums\Core\Auth\EloquentUserProvider;
use Kaamaru\Forums\Core\Html\HtmlBuilder;

class ForumsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Kaamaru\Forums');
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
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
        $this->app->bindShared('html', function ($app) {
            return new HtmlBuilder($app['url']);
        });
        $this->app->alias('html', 'Kaamaru\Forums\Core\Html\HtmlBuilder');
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
        $this->app->view->composer('forums.topics._reply', 'Kaamaru\Forums\Forums\Posts\QuotesComposer');
        $this->app->view->composer('forums.move_post', 'Kaamaru\Forums\Forums\Posts\MovePostComposer');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['html', 'form', 'Kaamaru\Forums\Core\Html\HtmlBuilder', 'Collective\Html\FormBuilder'];
    }
}