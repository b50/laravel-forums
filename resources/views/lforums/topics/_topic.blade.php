<h1 id="topic-header">{{ $topic->title }}</h1>
{!! Session::get('message') !!}
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
                <li>
                    <a href="{{ route('forums.topics.unfollow', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}">
                        _('Unfollow')
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('forums.topics.follow', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}">
                        _('Follow')
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('forums.topics.unread', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => 'forums.show']) }}">
                    _('Mark unread')
                </a>
            </li>
            @if (Bouncer::hasPermission('forums.move') and \Route::current()->parameter('topicType') == 'forums')
                <li>
                    <a href="{{ route('forums.topics.move',  ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) }}">
                        _('Move')
                    </a>
                </li>
                @endif
            @if (Bouncer::hasPermission('forums.lock'))
                <li>
                    <a href="{{ route('forums.topics.lock', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}">
                        {{ $topic->locked ? _('Unlock') : _('Lock') }}
                    </a>
                </li>
            @endif
            @if (Bouncer::hasPermission('forums.sticky'))
                <li>
                    <a href="{{ route('forums.topics.sticky', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}">
                        {{ $topic->sticky ? _('Unsticky') : _('Sticky') }}
                    </a>
                </li>
            @endif
            @if (Bouncer::hasPermission('forums.delete') or $topic->user_id == Auth::user()->id)
                <li>
                    <a href="{{ route('forums.topics.delete', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) }}">
                        {{ _('Delete') }}
                    </a>
                </li>
            @endif

            @if ($topic->favorite)
                <li>
                    <a href="{{ route('forums.topics.unfavorite', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}">
                        <i class="fa fa-heart"></i> {{ _('Unfavorite') }}
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('forums.topics.favorite', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token()]) }}">
                        <i class="fa fa-heart"></i> {{ _('Favorite') }}
                    </a>
                </li>
            @endif

        @endif
        <a href="{{ route('forums.topics.reply', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) }}">
            <i class="fa fa-plus"></i> {{ _('Reply') }}
        </a>
    </ul>
</div>

@if (Auth::check())
    {!! Form::open(['route' => ['forums.topics.reply', 'topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug], 'method' => 'GET']) !!}
@endif

<div class="posts">
    <?php $i = (Request::get('page') * Config::get('forums\forum.posts_per_page')) + 1 ?>
    @foreach ($topic->posts as $post)
        @include('lforums._post', [$post])
        <?php $i++ ?>
    @endforeach
</div>

<div class="row">
    <div class="col-md-5">
        {{ $topic->posts->links() }}
    </div>
    <div class="col-md-7">
        <ul class="post-menu">
           <li>
               <a href="{{ route('forums.topics.reply', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug]) }}">
                   <i class="fa fa-plus"></i> {{ _('Reply') }}
               </a>
           </li>
            @if (Auth::check())
                <li>{!! Form::submit('Quote selected', ['id' => 'quoteSelected']) !!}</li>
            @endif
        </ul>
    </div>
</div>

@if (Auth::check())
    {!! Form::close() !!}
@endif
