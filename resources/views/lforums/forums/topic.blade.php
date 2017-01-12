<td class="topic-folder">
    @if (Auth::check() and $topic->read)
        <a href="{{ route('forums.topics.unread', [
            'type' => 'forums',
            'id' => $topic->id,
            'slug' => $topic->slug,
            '_token' => csrf_token(),
            'route' => \Route::currentRouteName()
        ]) }}">
            <li class="fa fa-circle-o"></li>
        </a>
    @elseif (Auth::check())
        <a href="{{ route('forums.topics.read', [
            'type' => 'forums',
            'id' => $topic->id,
            'slug' => $topic->slug,
            '_token' => csrf_token(),
            'route' => \Route::currentRouteName()
        ]) }}">
            <li class="fa fa-circle"></li>
        </a>
    @else
        <li class="fa fa-circle"></li>
    @endif
</td>
<td class="topic">
    @if ($topic->locked)
        <i class="fa fa-lock"></i>
    @endif
    @if ($topic->sticky)
        <i class="fa fa-thumb-tack"></i>
    @endif
    <span class="title @if ($topic->sticky) sticky @endif">
         <a href="{{ route('forums.topics.show', [
             'id' => $topic->id,
             'slug' => $topic->slug
         ]) }}">
            {{ $topic->title }}
        </a>
        <br>
    </span>
    <span class="description">
        {{ _('Started by') }}
        @if ($topic->lastUser)
            @if(Route::has('users.show'))
                <a href="{{ route('users.show', [
                    'id' => $topic->last_user->id
                ]) }}">
                    {{ $topic->last_user->user->name }}
                </a>
            @else
                {{ $topic->last_user->user->name }}
            @endif
        @else
            {{ _('User deleted') }}
        @endif
        <span class="date">{{ $topic->created_at->diffForHumans() }}</span>
    </span>
</td>
<td class="stats">
    {{ $topic->posts_count - 1 }} {{ _('replies') }}
    <br>
    {{ $topic->views or 0 }} {{ _('views') }}
</td>
<td class="last-post">
    @if(File::exists($topic->last_user->avatar))
        <img src="{{ $topic->last_user->avatar }}"
             class="forum-avatar"
             alt="{{ $topic->last_user->user->name }}-avatar">
    @endif

    <div class="last-info">
        @if ($topic->lastUser)
            @if(Route::has('users.show'))
                <a href="{{ route('users.show', [
                    'id' => $topic->last_user->id
                ]) }}">
                    {{ $topic->last_user->user->name }}
                </a>
            @else
                {{ $topic->last_user->user->name }}
            @endif
        @else
            {{ _('User deleted') }}
        @endif
        <br>
        @if (isset($topic->updated_at))
            <a href="{{ route('forums.posts.show', [
                'type' => 'forums',
                'id' => $topic->last_post
            ]) }}">
                {{ $topic->updated_at }}
            </a>
            <br>
        @endif
    </div>
    <a href="{{ route('forums.posts.show', [
        'id' => $topic->id,
        'slug' => $topic->slug
    ], ['page' => $topic->pages.'#last']) }}">
        <i class="icon-chevron-sign-right" style="display: none"></i>
    </a>
</td>