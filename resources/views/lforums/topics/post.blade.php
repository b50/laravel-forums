<div class="post" id="post-{{$post->id }}">
    <div class="post-user">
        <h5>
            @if ($post->author->online)
                <i class="fa fa-user online"></i>
            @else
                <i class="fa fa-user"></i>
            @endif
            @foreach ($post->author->groups as $group)
                <span class="label label-{{ strtolower($group->group) }}">
                    {{ $group->group }}
                </span>
            @endforeach
            @if ($post->author->user)
                @if (Route::has('users.show') and ! isset($preview))
                    <a href="{{ route('users.show', $post->author->id) }}">
                        {{ $post->author->user->name }}
                    </a>
                @else
                    {{ $post->author->user->name }}
                @endif
            @else
                {{ _('User deleted') }}
            @endif
        </h5>

        <div class="user-date">{{ _('Posted')}} {{ $post->created_at }}</div>
        <ul class="post-menu">
            {!! Session::get('message') !!}
            @if ( ! isset($preview))
                @if (Auth::check())
                    <li>{!! Form::checkbox('quotes[]', $post->id) !!}</li>
                    <li>
                        <a href="{{ route('forums.topics.reply', [
                            Request::get('topicType'),
                            'id' => $topic->id,
                            'slug' => $topic->slug,
                            'quote' => $post->id
                        ]) }}">
                            {{ _('Quote') }}
                        </a>
                    </li>
                @endif

                @if (Auth::user()
                    and (Auth::user()->id == $post->user_id
                    or Bouncer::hasPermission('forums.delete'))
                    and isset($i)
                    and $i > 1
                )
                    <li>
                        <a href="{{ route('forums.posts.delete', [
                           'topicType' => Request::get('topicType'),
                            'id' => $post->id
                        ]) }}">
                            {{ _('Delete') }}
                        </a>
                    </li>
                @endif
                @if (Auth::user()
                    and (Auth::user()->id == $post->user_id
                    or Bouncer::hasPermission('forums.edit'))
                )
                    <li>
                        <a href="{{ route('forums.posts.edit', [
                            'topicType' => Request::get('topicType'),
                            'id' => $post->id
                        ]) }}">
                            {{ _('Edit') }}
                        </a>
                    </li>
                @endif

                @if (Auth::check() and Auth::user()->id != $post->user_id)
                    <li>
                        <a href="{{ route('forums.posts.report', [
                            'topicType' => Request::get('topicType'),
                            'id' => $post->id
                        ]) }}">
                            {{ _('Report') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forums.posts.vote', [
                            'topicType' => Request::get('topicType'),
                            'id' => $post->id,
                            'direction' => 'down',
                            '_token' => csrf_token()
                        ]) }}"
                           id="voteDown">
                            <i class="fa fa-angle-down"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forums.posts.vote', [
                            'topicType' => Request::get('topicType'),
                            'id' => $post->id,
                            'direction' => 'up',
                            '_token' => csrf_token()
                        ]) }}" id="voteUp">
                            <i class="fa fa-angle-up"></i>
                        </a>
                    </li>
                @endif

                @if ($post->votes > 0)
                    <li>
                        <span class="label label-success">
                            {{{ $post->votes }}}
                        </span>
                    </li>
                @elseif ($post->votes < 0)
                    <li>
                        <span class="label label-danger">
                            {{{ $post->votes }}}
                        </span>
                    </li>
                @endif
            @endif
        </ul>
    </div>
    <div class="post-container">
        <div class="avatar-background"></div>
        <div class="avatar">
            @if (file_exists($avatar = $post->author->avatar))
                <div class="avatar">
                    <img src="{{ $avatar }}" alt="" class="forum-avatar">
                </div>
            @else
                <i class="fa fa-user default-avatar" aria-hidden="true"></i>
            @endif
        </div>
        <div class="post-content-container">
            <div class="post-content">
                {{ $post->html }}
            </div>
            @if ($post->author->signature)
                <div class="signature">
                    <p>{{$post->author->signature }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
