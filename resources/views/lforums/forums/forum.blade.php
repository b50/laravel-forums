@extends('lforums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.show', $forum->parents))
@section('title', $forum->name)

@section('content')
    <h1 class="h1-top">{{{ $forum->name }}}</h1>
    <p class="description">{{{ $forum->description }}}</p>
    <div class="row">
        <div class="col-md-12">
            <div id="forums" class="box margin">
                @if ($subforums->count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="5">{{ _('Subforums') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @include('lforums._forums', [
                            'forums' => $subforums,
                            'path' => $forum->path,
                            'index' => false
                        ])
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <ul class="nav nav-pills navbar-right">
        @if (Auth::check())
            <li>
                <a href="{{ route('forums.unread', [
                    'id' => $forum->id,
                    'slug' => $forum->slug,
                    '_token' => csrf_token()
                ]) }}">
                    {{ _('Mark unread') }}
                </a>
            </li>
        @endif
        @if ( ! isset($forum->locked) and ! \Bouncer::inGroup('admin'))
            <li>
                <a href="{{ route('forums.topics.new', [
                    $forum->id,
                    $forum->slug
                ]) }}">
                    {{ _('New topic') }}
                </a>
            </li>
        @endif
    </ul>

    @include('lforums.forums.topics', [
        'type' => 'forums',
        'topics' => $topics,
        'route' => 'forums.show',
        'routeParams' => [
                'id' => $forum->id,
                'slug' => $forum->slug
        ]
    ])

    <ul class="nav nav-pills navbar-right">
        @if (Auth::check())
            <li>
                <a href="{{ route('forums.unread', [
                    'id' => $forum->id,
                    'slug' => $forum->slug,
                    '_token' => csrf_token()
                ]) }}">
                    {{ _('Mark unread') }}
                </a>
            </li>
        @endif
        @if ( ! isset($forum->locked))
            <li>
                <a href="{{ route('forums.topics.new', [
                    $forum->id,
                    $forum->slug
                ]) }}">
                    {{ _('New topic') }}
                </a>
            </li>
        @endif
    </ul>
@stop
