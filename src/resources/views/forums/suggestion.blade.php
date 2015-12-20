@extends('kaamaru/laravel-forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.show', $forum->parents))
@section('title', $forum->name)

@section('content')
    <h1 class="h1-top">{{{ $forum->name }}}</h1>
    <p class="description">{{{ $forum->description }}}</p>
    <div class="row">
        <div class="col-md-12">
            <div id="forums" class="box">
                @if (count($subforums))
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="5">
                                {{ _('Subforums') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @include('kaamaru/laravel-forums/forums._forums', ['forums' => $subforums, 'path' => $forum->path, 'index' => false])
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <ul class="nav nav-pills navbar-right">
        @if (Auth::check())
            <li>{{ Html::linkRoute('forums.unread', _('Mark unread'),
			['id' => $forum->id, 'slug' => $forum->slug, '_token' => csrf_token()]) }}</li>
        @endif
        @if ( ! isset($forum->locked) and ! \Bouncer::inGroup('admin'))
            <li>{!! Html::linkRoute('forums.topics.new', _('New topic'), [$forum->id, $forum->slug]) !!}</li>
        @endif
    </ul>

    @include('kaamaru/laravel-forums/forums._suggestions', ['topics' => $topics, 'route' => 'forums.show', 'routeParams' => [
        'id' => $forum->id, 'slug' => $forum->slug]])

    <ul class="nav nav-pills navbar-right">
        @if (Auth::check())
            <li>{{ Html::linkRoute('forums.unread', _('Mark unread'),
			['id' => $forum->id, 'slug' => $forum->slug, '_token' => csrf_token()]) }}</li>
        @endif
        @if ( ! isset($forum->locked))
            <li>{!! Html::linkRoute('forums.topics.new', _('New topic')) !!}</li>
        @endif
    </ul>
@stop
