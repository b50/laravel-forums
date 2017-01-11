@extends('kaamaru/laravel-forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic))
@section('title', $topic->title)
@section('content')

    <h1>{{ $topic->title }}</h1>
    {!! Html::flash('topic') !!}
    <div class="box-header-blue">
        <ul>
            <li>
                {{ $topic->tag }}
            </li>
            <li>
				<span class="toolTip" title="{{ _('replies') }}">
					<i class="fa fa-comments"></i> {{ ($topic->posts_count - 1) }}
				</span>
            </li>
            <li>
				<span class="toolTip" title="{{ _('views') }}">
					<i class="fa fa-eye"></i> {{ $topic->views }}
				</span>
            </li>
            <li>
				<span class="toolTip" title="{{ _('followers') }}">
					<i class="fa fa-user"></i> {{ $topic->followers or 0 }}
				</span>
            </li>
            @if ($topic->locked)
                <li>
                    <a class="toolTip" href="#" title="{{ _('locked') }}">
                        <i class="fa fa-lock"></i>
                    </a>
                </li>
            @endif
            @if ($topic->sticky)
                <li>
                    <a class="toolTip" href="#" title="{{ _('sticky') }}">
                        <i class="fa fa-thumb-tack"></i>
                    </a>
                </li>
            @endif
        </ul>
        <ul class="pull-right">
            @if (Auth::check())
                @if ($topic->following)
                    <li>{{ Html::linkRoute('forums.topics.unfollow',_('Unfollow'),
						['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(),]) }}</li>
                @else
                    <li>{{ Html::linkRoute('forums.topics.follow',_('Follow'),
						['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(),]) }}</li>
                @endif
                <li>{{ Html::linkRoute('forums.topics.unread', _('Mark unread'),
					['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => 'forums.show']) }}</li>

                @if ( Bouncer::hasPermission('forums.move'))
                    <li>{{ Html::linkRoute('forums.topics.move', _('Move'),
						 ['id' => $topic->id, 'slug' => $topic->slug]) }}</li>
                @endif
                @if ( Bouncer::hasPermission('forums.lock'))
                    <li>{{ Html::linkRoute('forums.topics.lock', $topic->locked ? _('Unlock') : _('Lock'),
						['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}</li>
                @endif
                @if ( Bouncer::hasPermission('forums.sticky'))
                    <li>{{ Html::linkRoute('forums.topics.sticky', $topic->sticky ? _('Unsticky') : _('Sticky'),
						['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}</li>
                @endif
                @if ( Bouncer::hasPermission('forums.delete') or $topic->user_id == Auth::user()->id)
                    <li>{{ Html::linkRoute('forums.topics.delete', _('Delete'),
						['id' => $topic->id, 'slug' => $topic->slug]) }}</li>
                @endif

                @if ($topic->favorite)
                    <li>
                        {{ Html::uLinkRoute('forums.topics.favorites', '<i class="fa fa-heart"></i> '._('Unfavorite'),
                            ['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()] ) }}
                    </li>
                @else
                    <li>
                        {{ Html::uLinkRoute('forums.topics.unfavorite', '<i class="fa fa-heart-o"></i> '._('Favorite'),
                            ['id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}
                    </li>
                @endif

            @endif
            @if (\Bouncer::hasPermission('forums.response'))
                {{ Html::linkRoute('forums.topics.reply', _('Developer response'),
                    ['id' => $topic->id, 'slug' => $topic->slug, 'devresponse' => true]) }}
            @endif
            {{ Html::uLinkRoute('forums.topics.reply', '<i class="fa fa-plus"></i> '._('Reply'),
                ['id' => $topic->id, 'slug' => $topic->slug]) }}
        </ul>
    </div>

    @if (Auth::check())
        {!! Form::open(['route' => ['forums.topics.reply', 'id' => $topic->id, 'slug' => $topic->slug], 'method' => 'GET']) !!}
    @endif

    <div class="posts">
        @include('kaamaru/laravel-forums/forums._post', ['post' => $topic->first_post])
    </div>

    @if ($topic->developer_response)<br>
        <div class="box-header-blue">{{ _('Developer response') }}</div>
        <div class="posts">
            @include('kaamaru/laravel-forums/forums._post', ['post' => $topic->developer_response])
        </div>
    @endif

    <div id="comments">
        <div class="row">
            <div class="col-md-5">
                {{ $topic->postsByVotes->fragment('comments')->links() }}
            </div>
            <div class="col-md-7">
                <ul class="topic-menu social">
                    @include('kaamaru/laravel-forums/share')
                </ul>
            </div>
        </div>

        <div class="box-header-blue">
            {{ _('Comments') }}

            <ul class="pull-right">
                <li>{{ Html::uLinkRoute('forums.topics.reply', '<i class="fa fa-plus"></i> '._('Reply'),
					['id' => $topic->id, 'slug' => $topic->slug]) }}</li>
            </ul>
        </div>
        @if ($topic->postsByVotes and count($topic->postsByVotes) > 1)
            <div class="posts">
                <?php $i = (Request::get('page') * Config::get('forums\forum.posts_per_page')) + 2 ?>
                @foreach ($topic->postsByVotes as $post)
                    @if ($topic->first_post->id != $post->id)
                        @include('kaamaru/laravel-forums/forums._post', [$post])
                        <?php $i++ ?>
                    @endif
                @endforeach
            </div>
        @else
            <div class="box">
                <div class="box-section">
                    {{ _('No comments yet!') }}
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-5">
                {{ $topic->postsByVotes->fragment('comments')->links() }}
            </div>
            <div class="col-md-7">
                <ul class="topic-menu">
                    <li>{{ Html::uLinkRoute('forums.topics.reply', '<i class="fa fa-plus"></i> '._('Reply'),
						['id' => $topic->id, 'slug' => $topic->slug]) }}</li>
                    @if (Auth::check())
                        <li>{!! Form::submit('Quote selected', ['id' => 'quoteSelected']) !!}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @if (Auth::check())
        {!! Form::close() !!}
    @endif
@stop
