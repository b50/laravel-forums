<?php

/*
 * Forums
 */
Breadcrumbs::register('forums.index', function ($breadcrumbs, $action = '') {
    $breadcrumbs->push('Forums', route('forums.index'));
});

Breadcrumbs::register('forums.all', function ($breadcrumbs, $action = '') {
    $breadcrumbs->parent('forums.index');
    $breadcrumbs->push(_('All'));
});
Breadcrumbs::register('forums.favorites',
    function ($breadcrumbs, $action = '') {
        $breadcrumbs->parent('forums.index');
        $breadcrumbs->push(_('Favorites'));
    }
);
Breadcrumbs::register('forums.show',
    function ($breadcrumbs, $parents, $action = '') {
        $breadcrumbs->parent('forums.index');

        foreach ($parents as $forum) {
            $breadcrumbs->push($forum->name, route(
                'forums.show',
                [$forum->id, $forum->slug]
            ));
        }

        !$action ?: $breadcrumbs->push($action);
    }
);

Breadcrumbs::register('forums.topics.show',
    function ($breadcrumbs, $topic, $action = '') {
        // The topic parents
        $breadcrumbs->parent('forums.show', $topic->parents);

        // The topic
        $breadcrumbs->push($topic->title, route(
                'forums.topics.show',
                ['topic' => $topic->id, 'slug' => $topic->slug])
        );

        // A topic action
        !$action ?: $breadcrumbs->push($action);
    }
);

/*
 * Users
 */

Breadcrumbs::register('users.show',
    function ($breadcrumbs, $user, $action = '') {
        $breadcrumbs->push('Users', route('users.index'));
        $breadcrumbs->push(
            $user->user->name,
            route('forums.show', [$user->id])
        );
    }
);