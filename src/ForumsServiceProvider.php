<?php namespace LaravelForums;

use Illuminate\Support\ServiceProvider;
use LaravelForums\Core\Auth\EloquentUserProvider;
use LaravelForums\Core\Html\HtmlBuilder;

class ForumsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'LaravelForums');
        \Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new ValidationRules($translator, $data, $rules, $messages);
        });

        \Auth::extend('eloquent', function($app)
        {
            $model = $this->app['config']['auth.model'];

            return new EloquentUserProvider($this->app['hash'], $model);
        });
        require __DIR__.'/Http/breadcrumbs.php';
    }

    public function register()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
        $this->app->bindShared('html', function($app)
        {
            return new HtmlBuilder($app['url']);
        });
        $this->app->bind('counter', 'LaravelForums\Core\Counters\Redis\RedisCounter');
        $this->app->bind('markdown', 'LaravelForums\Core\Markdown\Markdown');
        $this->app->bind('flash', 'LaravelForums\Core\Flash\Flash');
        $this->app->bind('bouncer', 'LaravelForums\Core\Auth\Bouncer');
        $this->app->bind('finediff', 'cogpowered\FineDiff\Diff');
        $this->app->bind('LaravelForums\Forums\Forums\ForumRepoInterface',
            'LaravelForums\Forums\Forums\EloquentForumRepo');
        $this->app->bind('LaravelForums\Forums\Topics\TopicRepoInterface',
            'LaravelForums\Forums\Topics\EloquentTopicRepo');
        $this->app->bind('LaravelForums\Forums\Posts\PostRepoInterface',
            'LaravelForums\Forums\Posts\EloquentPostRepo');
        $this->app->bind('LaravelForums\Forums\Topics\Favorite\FavoriteRepoInterface',
            'LaravelForums\Forums\Topics\Favorite\EloquentFavoriteRepo');
        $this->app->bind('LaravelForums\Forums\Posts\Vote\PostVoteRepoInterface',
            'LaravelForums\Forums\Posts\Vote\EloquentPostVoteRepo');
        $this->app->bind('LaravelForums\Forums\Posts\Report\PostReportRepoInterface',
            'LaravelForums\Forums\Posts\Report\EloquentPostReportRepo');
        $this->app->bind('LaravelForums\Forums\Forums\Read\ForumReadRepoInterface',
            'LaravelForums\Forums\Forums\Read\EloquentForumReadRepo');
        $this->app->bind('LaravelForums\Forums\Topics\Read\TopicReadRepoInterface',
            'LaravelForums\Forums\Topics\Read\EloquentTopicReadRepo');
        $this->app->bind('LaravelForums\Forums\Topics\Follow\FollowRepoInterface',
            'LaravelForums\Forums\Topics\Follow\EloquentFollowRepo');
        $this->app->view->composer('forums.topics._reply', 'LaravelForums\Forums\Posts\QuotesComposer');
        $this->app->view->composer('forums.move_post', 'LaravelForums\Forums\Posts\MovePostComposer');
    }

}