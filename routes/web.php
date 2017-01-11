<?php
Route::group(['namespace' => 'B50\Forums\Http\Controllers', 'middleware' => ['web']], function () {
    /*
     * topics
     */
    Route::group(['prefix' => 'forums/', 'namespace' => 'Topics'], function () {
        Route::group(['prefix' => 'topics/{id}-{slug?}'], function () {
            Route::get('', 'TopicsController@getTopic')
                ->name('forums.topics.show');

            Route::group(['before' => 'auth'], function () {
                Route::group(['before' => 'csrf'], function () {
                    Route::get('sticky', 'StickyTopicsController@getSticky')
                        ->name('forums.topics.sticky');
                    Route::post('delete', 'DeleteTopicsController@postDelete');
                    Route::get('follow',
                        'FollowTopicsController@getFollow')
                        ->name('forums.topics.follow');
                    Route::get('unfollow',
                        'FollowTopicsController@getUnfollow')
                        ->name('forums.topics.unfollow');
                    Route::get('unread', 'ReadTopicsController@getUnread')
                        ->name('forums.topics.unread');
                    Route::get('read', 'ReadTopicsController@getRead')
                        ->name('forums.topics.read');
                    Route::get('lock', 'LockTopicsController@getLock')
                        ->name('forums.topics.lock');
                    Route::post('reply', 'ReplyTopicsController@postReply');
                    Route::post('move', 'MoveTopicsController@postMove');
                    Route::get('favorite', 'FavoritesController@getAdd')
                        ->name('forums.topics.favorite');
                    Route::get('unfavorite',
                        'FavoritesController@getRemove')
                        ->name('forums.topics.unfavorite');
                });
                Route::get('delete', 'DeleteTopicsController@getDelete')
                    ->name('forums.topics.delete');
                Route::get('reply', 'ReplyTopicsController@getReply')
                    ->name('forums.topics.reply');
                Route::get('move', 'MoveTopicsController@getMove')
                    ->name('forums.topics.move');
            });
        });
    });

    // Posts
    Route::group(['prefix' => 'posts/{id}', 'namespace' => 'Posts'], function () {
        Route::get('', 'PostsController@getShow')
            ->name('forums.posts.show');

        Route::group(['before' => 'auth'], function () {
            Route::get('edit', 'EditPostsController@getEdit')
                ->name('forums.posts.edit');
            Route::get('report', 'ReportPostsController@getReport')
                ->name('forums.posts.report');
            Route::get('delete', 'DeletePostsController@getDelete')
                ->name('forums.posts.delete');

            Route::group(['before' => 'csrf'], function () {
                Route::post('edit', 'EditPostsController@postEdit');
                Route::post('delete', 'DeletePostsController@postDelete');
                Route::get('vote-{direction}', 'VotePostsController@getVote')
                    ->name('forums.posts.vote');
                Route::post('report', 'ReportPostsController@postReport')
                    ->name('forums.posts.report');
            });
        });
    });

    /*
     * Forums
     */
    Route::group(['prefix' => 'forums', 'namespace' => 'Forums'], function () {
        Route::get('', 'ForumsIndexController@getIndex')
            ->name('forums.index');

        // Favorites
        Route::group(['prefix' => 'favorites', 'before' => 'auth'], function () {
            Route::get('', 'FavoritesController@getIndex')
                ->name('forums.favorites');
        });

        // Topics
        Route::get('topics', 'TopicsController@getIndex')
            ->name('forums.topics.index');

        // Forum
        Route::group(['prefix' => '{id}-{slug?}'], function () {

            Route::get('', 'ForumsController@getForum')
                ->name('forums.show');

            Route::group(['before' => 'auth'], function () {
                Route::get('new-topic', 'NewTopicForumsController@getNewTopic')
                    ->name('forums.topics.new');

                Route::group(['before' => 'csrf'], function () {
                    Route::get('read', 'ReadForumsController@getRead')
                        ->name('forums.read');
                    Route::get('unread', 'ReadForumsController@getUnread')
                        ->name('forums.unread');
                    Route::post('new-topic', 'NewTopicForumsController@postNewTopic');
                });

            });
        });
    });

    Route::get('users')->name('users.show', 'UsersController@getProfile');
});