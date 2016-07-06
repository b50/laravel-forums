<h1 id="topic-header">{{ $topic->title }}}</h1>
{!! Html::flash('topic') !!}
<div class="row">
    <div class="col-md-5">
        {{ $topic->posts->links() }}
    </div>
    <div class="col-md-7">
        <ul class="social topic-menu">
            @include('lforums/...share')
        </ul>
    </div>
</div>
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
    <ul style="text-align:right">
        @if (Auth::check())
            @if ($topic->following)
                <li>{!! Html::linkRoute('forums.topics.unfollow',_('Unfollow'),
					['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(),]) !!}</li>
            @else
                <li>{!! Html::linkRoute('forums.topics.follow',_('Follow'),
					['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(),]) !!}</li>
            @endif
            <li>{!! Html::linkRoute('forums.topics.unread', _('Mark unread'),
				['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => 'forums.show']) !!}</li>

            @if (Bouncer::hasPermission('forums.move') and \Route::current()->parameter('topicType') == 'forums')
                <li>{!! Html::linkRoute('forums.topics.move', _('Move'),
					 ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) !!}</li>
            @endif
            @if ( Bouncer::hasPermission('forums.lock'))
                <li>{!! Html::linkRoute('forums.topics.lock', $topic->locked ? _('Unlock') : _('Lock'),
					['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) !!}</li>
            @endif
            @if ( Bouncer::hasPermission('forums.sticky'))
                <li>{!! Html::linkRoute('forums.topics.sticky', $topic->sticky ? _('Unsticky') : _('Sticky'),
					['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) !!}</li>
            @endif
            @if ( Bouncer::hasPermission('forums.delete') or $topic->user_id == Auth::user()->id)
                <li>{!! Html::linkRoute('forums.topics.delete', _('Delete'),
					['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) !!}</li>
            @endif

            @if ($topic->favorite)
                <li>
                    {!! Html::uLinkRoute('forums.topics.unfavorite', '<i class="fa fa-heart"></i> '._('Unfavorite'),
                        ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()] ) !!}
                </li>
            @else
                <li>
                    {{ Html::uLinkRoute('forums.topics.favorite', '<i class="fa fa-heart-o"></i> '._('Favorite'),
                        ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}
                </li>
            @endif

        @endif
        {!! Html::uLinkRoute('forums.topics.reply', '<i class="fa fa-plus"></i> '._('Reply'),
            ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) !!}
    </ul>
</div>

@if (Auth::check())
    {!! Form::open(['route' => ['forums.topics.reply', 'topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug], 'method' => 'GET']) !!}
@endif

<div class="posts">
    <?php $i = (Request::get('page') * Config::get('forums\forum.posts_per_page')) + 1 ?>
    @foreach ($topic->posts as $post)
        @include('kaamaru/laravel-forums/...forums._post', [$post])
        <?php $i++ ?>
    @endforeach
</div>

<div class="row">
    <div class="col-md-5">
        {{ $topic->posts->links() }}
    </div>
    <div class="col-md-7">
        <ul class="post-menu">
            <li>{!! Html::uLinkRoute('forums.topics.reply', '<i class="fa fa-plus"></i> '._('Reply'),
            	['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) !!}</li>
            @if (Auth::check())
                <li>{!! Form::submit('Quote selected', ['id' => 'quoteSelected']) !!}</li>
            @endif
        </ul>
    </div>
</div>

@if (Auth::check())
    {!! Form::close() !!}
@endif
