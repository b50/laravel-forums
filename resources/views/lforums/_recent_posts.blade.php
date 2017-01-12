<h4>{{ _('Recent posts') }}</h4>
<div class="box-recent">
    @if ($posts->count())
        @foreach ($posts as $post)
            <div class="recent">
                @if (file_exists($post->author->avatar))
                    <img src="{{ $post->author->avatar }}" alt=""
                         class="forum-avatar">
                @endif

                <div class="recent-info">
                    <a href="{{ route('forums.posts.show', [
            'id' => $post->id]) }}">
                        {{  $post->topic->title }}
                    </a>
                    <p class="description">
                        {{ $post->created_at->diffForHumans() }} by
                        @if ($post->author->user)
                            @if(Route::has('users.show'))
                                <a href="{{ route('users.show',
                                ['id' => $post->author->id]) }}">
                                    {{ $post->author->user->name }}
                                </a>
                            @else
                                {{ $post->author->user->name }}
                            @endif
                        @else
                            {{ _('user deleted') }}
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    @else
        {{ _('No posts found.') }}
    @endif
</div>