<?php namespace B50\Forums;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use B50\Forums\Core\Auth\EloquentUserProvider;
use B50\Forums\Core\Validation\ValidationRules;

class ForumsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'B50\Forums');
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
            'B50\Forums\Core\Counters\Redis\RedisCounter'
        );
        $this->app->bind(
            'markdown',
            'B50\Forums\Core\Markdown\Markdown'
        );
        $this->app->bind(
            'flash',
            'B50\Forums\Core\Flash\Flash'
        );
        $this->app->bind(
            'bouncer',
            'B50\Forums\Core\Auth\Bouncer'
        );
        $this->app->bind(
            'finediff',
            'cogpowered\FineDiff\Diff'
        );
        $this->app->bind(
            'B50\Forums\Forums\ForumRepoInterface',
            'B50\Forums\Forums\EloquentForumRepo'
        );
        $this->app->bind(
            'B50\Forums\Topics\TopicRepoInterface',
            'B50\Forums\Topics\EloquentTopicRepo'
        );
        $this->app->bind(
            'B50\Forums\Posts\PostRepoInterface',
            'B50\Forums\Posts\EloquentPostRepo'
        );
        $this->app->bind(
            'B50\Forums\Topics\Favorite\FavoriteRepoInterface',
            'B50\Forums\Topics\Favorite\EloquentFavoriteRepo'
        );
        $this->app->bind(
            'B50\Forums\Posts\Vote\PostVoteRepoInterface',
            'B50\Forums\Posts\Vote\EloquentPostVoteRepo'
        );
        $this->app->bind(
            'B50\Forums\Posts\Report\PostReportRepoInterface',
            'B50\Forums\Posts\Report\EloquentPostReportRepo'
        );
        $this->app->bind(
            'B50\Forums\Read\ForumReadRepoInterface',
            'B50\Forums\Read\EloquentForumReadRepo'
        );
        $this->app->bind(
            'B50\Forums\Topics\Read\TopicReadRepoInterface',
            'B50\Forums\Topics\Read\EloquentTopicReadRepo'
        );
        $this->app->bind(
            'B50\Forums\Topics\Follow\FollowRepoInterface',
            'B50\Forums\Topics\Follow\EloquentFollowRepo'
        );
        $this->app->bind(
            'B50\Forums\Users\Group\UserGroupRepoInterface',
            'B50\Forums\Users\Group\EloquentUserGroupRepo'
        );
        $this->app->bind(
            'B50\Forums\Users\UserRepoInterface',
            'B50\Forums\Users\EloquentUserRepo'
        );
        $this->app->view->composer(
            'forums.topics._reply',
            'B50\Forums\Posts\QuotesComposer'
        );
        $this->app->view->composer(
            'forums.move_post',
            'B50\Forums\Posts\MovePostComposer'
        );
        // Register aliases
        AliasLoader::getInstance()->alias(
            'Breadcrumbs',
            'DaveJamesMiller\Breadcrumbs\Facade'
        );
        AliasLoader::getInstance()->alias(
            'Bouncer',
            'B50\Forums\Core\Facades\Bouncer'
        );

        // Register service providers
        $this->app->register('DaveJamesMiller\Breadcrumbs\ServiceProvider');
    }
}