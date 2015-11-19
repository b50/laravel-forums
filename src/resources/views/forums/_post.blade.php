<div class="post" id="post-{{$post->id }}">
    <div class="post-user">
        <h5>
            @if ($post->author->online)
                <i class="fa fa-user online"></i>
            @else
                <i class="fa fa-user"></i>
            @endif
            @foreach ($post->author->groups as $group)
                <span class="label label-{{ strtolower($group->group) }}">{{ $group->group }}</span>
            @endforeach
            @if (isset($preview))
                {{{ $post->author->username }}}
            @else
                {{ HTML::linkRoute('users.show', $post->author->username, $post->author->slug) }}
            @endif
        </h5>

        <div class="user-date">{{ _('Posted')}} {{$post->created_at }}</div>
        <ul class="post-menu">
            {{ HTML::flashInline("post-$post->id") }}
            @if ( ! isset($preview))
                @if (Auth::check())
                    <li>{{ Form::checkbox('quotes[]', $post->id) }}</li>
                    <li>{{ HTML::linkRoute('forums.topics.reply', _('Quote'),
					[\Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug, 'quote' => $post->id]) }}</li>
                @endif

                @if (Auth::user() and (Auth::user()->id == $post->user_id or Bouncer::hasPermission('forums.delete')) and isset($i) and $i > 1)
                    <li>{{ HTML::linkRoute('forums.posts.delete', _('Delete'), [\Route::current()->parameter('topicType'), 'id' => $post->id]) }}</li>
                @endif
                @if (Auth::user() and (Auth::user()->id == $post->user_id or Bouncer::hasPermission('forums.edit')))
                    <li>{{ HTML::linkRoute('forums.posts.edit', _('Edit'), [\Route::current()->parameter('topicType'), 'id' => $post->id]) }}</li>
                @endif

                @if (Auth::check() and Auth::user()->id != $post->user_id)
                    <li>{{ HTML::linkRoute('forums.posts.report', _('Report'), [\Route::current()->parameter('topicType'), 'id' => $post->id]) }}</li>
                    <li>{{ HTML::uLinkRoute('forums.posts.vote', '<i class="fa fa-angle-down"></i>', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $post->id, 'direction' => 'down', '_token' => csrf_token()], ['id' => 'voteDown']) }}</li>
                    <li>{{ HTML::uLinkRoute('forums.posts.vote', '<i class="fa fa-angle-up"></i>', ['topicType' => \Route::current()->parameter('topicType'), 'id' => $post->id, 'direction' => 'up', '_token' => csrf_token()], ['id' => 'voteUp']) }}</li>
                @endif

                @if ($post->votes > 0)
                    <li><span class="label label-success">{{{ $post->votes }}}</span></li>
                @elseif ($post->votes < 0)
                    <li><span class="label label-danger">{{{ $post->votes }}}</span></li>
                @endif
            @endif
        </ul>
    </div>
    <div class="post-container">
        <div class="avatar-background"></div>
        <div class="avatar">
            {{ HTML::imageExists("images/avatars/{$post->author->slug}/{$post->author->slug}.jpg", $post->author->username, ['class' => 'post-user-avatar']) }}
        </div>
        <div class="post-content">
            {{ $post->html }}
        </div>
        @if ($post->author->signature)
            <div class="signature">
                <p>{{{$post->author->signature }}}</p>
            </div>
        @endif
    </div>
</div>
