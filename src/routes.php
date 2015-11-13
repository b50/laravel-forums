<?php
Route::group(['namespace' => 'LaravelForums\Http\Controllers'], function() {
    /*
     * topics
     */
    Route::group(['prefix' => '{topicType}/'], function () {
        Route::group(['prefix' => 'topics/{id}-{slug?}'], function () {
            Route::get('', ['uses' => 'TopicsController@getTopic', 'as' => 'forums.topics.show']);

            Route::group(['before' => 'auth'], function () {
                Route::group(['before' => 'csrf'], function () {
                    Route::get('sticky',
                        ['uses' => 'StickyTopicsController@getSticky', 'as' => 'forums.topics.sticky']);
                    Route::post('delete', ['uses' => 'DeleteTopicsController@postDelete']);
                    Route::get('follow',
                        ['uses' => 'FollowTopicsController@getFollow', 'as' => 'forums.topics.follow']);
                    Route::get('unfollow',
                        ['uses' => 'FollowTopicsController@getUnfollow', 'as' => 'forums.topics.unfollow']);
                    Route::get('unread', ['uses' => 'ReadTopicsController@getUnread', 'as' => 'forums.topics.unread']);
                    Route::get('read', ['uses' => 'ReadTopicsController@getRead', 'as' => 'forums.topics.read']);
                    Route::get('lock', ['uses' => 'LockTopicsController@getLock', 'as' => 'forums.topics.lock']);
                    Route::post('reply', ['uses' => 'ReplyTopicsController@postReply']);
                    Route::post('move', ['uses' => 'MoveTopicsController@postMove']);
                    Route::get('favorite', ['uses' => 'FavoritesController@getAdd', 'as' => 'forums.topics.favorite']);
                    Route::get('unfavorite',
                        ['uses' => 'FavoritesController@getRemove', 'as' => 'forums.topics.unfavorite']);
                });
                Route::get('delete', ['uses' => 'DeleteTopicsController@getDelete', 'as' => 'forums.topics.delete']);
                Route::get('reply', ['uses' => 'ReplyTopicsController@getReply', 'as' => 'forums.topics.reply']);
                Route::get('move', ['uses' => 'MoveTopicsController@getMove', 'as' => 'forums.topics.move']);
            });
        });

        // Posts
        Route::group(['prefix' => 'posts/{id}'], function () {
            Route::get('', ['uses' => 'PostsController@getShow', 'as' => 'forums.posts.show']);

            Route::group(['before' => 'auth'], function () {
                Route::get('edit', ['uses' => 'EditPostsController@getEdit', 'as' => 'forums.posts.edit']);
                Route::get('report', ['uses' => 'ReportPostsController@getReport', 'as' => 'forums.posts.report']);
                Route::get('delete', ['uses' => 'DeletePostsController@getDelete', 'as' => 'forums.posts.delete']);

                Route::group(['before' => 'csrf'], function () {
                    Route::post('edit', ['uses' => 'EditPostsController@postEdit']);
                    Route::post('delete', ['uses' => 'DeletePostsController@postDelete']);
                    Route::get('vote-{direction}',
                        ['uses' => 'VotePostsController@getVote', 'as' => 'forums.posts.vote']);
                    Route::post('report',
                        ['uses' => 'ReportPostsController@postReport', 'as' => 'forums.posts.report']);
                });
            });
        });
    });
    /*
     * Forums
     */

    Route::group(['prefix' => 'forums', 'namespace' => 'Forums'], function () {
        Route::get('', ['uses' => 'ForumsIndexController@getIndex', 'as' => 'forums.index']);

        // Favorites
        Route::group(['prefix' => 'favorites', 'before' => 'auth'], function () {
            Route::get('', ['uses' => 'FavoritesController@getIndex', 'as' => 'forums.favorites']);
        });

        // Topics
        Route::get('topics', ['uses' => 'TopicsController@getIndex', 'as' => 'forums.topics.index']);

        // Forum
        Route::group(['prefix' => '{id}-{slug?}'], function () {
            Route::get('', ['uses' => 'ForumsController@getForum', 'as' => 'forums.show']);

            Route::group(['before' => 'auth'], function () {
                Route::get('new-topic',
                    ['uses' => 'NewTopicForumsController@getNewTopic', 'as' => 'forums.topics.new']);

                Route::group(['before' => 'csrf'], function () {
                    Route::get('read', ['uses' => 'ReadForumsController@getRead', 'as' => 'forums.read']);
                    Route::get('unread', ['uses' => 'ReadForumsController@getUnread', 'as' => 'forums.unread']);
                    Route::post('new-topic', ['uses' => 'NewTopicForumsController@postNewTopic']);
                });

            });
        });
    });
});