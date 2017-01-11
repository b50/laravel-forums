@extends('lforums.master')

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
                    <a href="{{ route('forums.show', [$forum->id, $forum->slug]) }}">
                      {{ $forum->name }}
                    </a>
                  </th>
                </tr>
                </thead>
                <tbody>
                @include('lforums._forums', [
                  'forums' => $forums, 'path' => $forum->path, 'index' => true
                ])
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
          <a href="{{ route('forums.topics.index', [$forum->id, $forum->slug]) }}"
             class="list-group-item">
            <i class="fa fa-gavel"></i> {{ _('View All Topics') }}
          </a>
          @if (Auth::check())
            <a href="{{ route('forums.favorites', [$forum->id, $forum->slug]) }}"
               class="list-group-item">
              <i class="fa fa-heart"></i> {{ _('Favorites') }}
            </a>
          @endif
        </div>

        @include('lforums/_recent_posts', ['posts' => $recentPosts])
        @include('lforums/_recent_topics', ['topics' => $recentTopics])
      </div>
    </div>
  </div>
@stop
