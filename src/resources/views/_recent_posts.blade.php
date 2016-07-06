<h4>{{ _('Recent posts') }}</h4>
<div class="box-recent">
  @if ($posts->count())
    @foreach ($posts as $post)
      <div class="recent">
        @if (file_exists($post->author->avatar))
          <img src="{{ $post->author->avatar }}" alt="" class="forum-avatar">
        @endif

        <div class="recent-info">
          {!! link_to_route('forums.posts.show', $post->topic->title, ['post' => 'forums', 'id' => $post->id]) !!}
          <p class="description">
            {{ $post->created_at->diffForHumans() }} by
            {!! link_to_route('users.show', $post->author->username, ['slug' => $post->author->slug]) !!}
          </p>
        </div>
      </div>
    @endforeach
  @else
    {{ _('No posts found.') }}
  @endif
</div>
