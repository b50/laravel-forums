@extends('kaamaru/laravel-forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.index'))
@section('title', _('Forums'))

@section('content')
    <h1 class="h1">{{ _('Forums') }}</h1>
    <div class="box" id="forums-container">
        <div class="row">
            <div class="col-md-9" id="forums">
                @if ($forums->count())
                    @foreach ($forums as $forum)
                        @if (is_numeric($forum->path))
                            <table class="table table-default">
                                <thead>
                                <tr>
                                    <th colspan="5">
                                        {!! Html::linkRoute('forums.show', $forum->name, [$forum->id, $forum->slug]) !!}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @include('kaamaru/laravel-forums/forums._forums', ['forums' => $forums, 'path' => $forum->path, 'index' => true])
                                </tbody>
                            </table>
                        @endif
                    @endforeach
                @else
                    <div class="box">
                        <div class="box-section">
                            {{ _('No forums found :O') }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-3" id="forums-sidebar">
                <div class="list-group">
                    {{-- Html::uLinkRoute('forums.rules', '<i class="fa fa-gavel"></i> '. _('Forum Rules'), [], ['class' => 'list-group-item']) --}}
                    {!! Html::uLinkRoute('forums.topics.index', '<i class="fa fa-list-ul"></i> '. _('View All Topics'), [], ['class' => 'list-group-item']) !!}
                    @if (Auth::check())
                        {!! Html::uLinkRoute('forums.favorites', '<i class="fa fa-heart"></i> '. _('Favorites'), [], ['class' => 'list-group-item']) !!}
                    @endif
                </div>

                @include('kaamaru/laravel-forums/forums._recent_posts', ['posts' => $recentPosts])
                @include('kaamaru/laravel-forums/forums._recent_topics', ['topics' => $recentTopics])
            </div>
        </div>
    </div>
@stop
