<h4>{{ _('Recent posts') }}</h4>
<div class="box-recent">
  @if ($posts->count())
    @foreach ($posts as $post)
      <div class="recent">
        @if (file_exists($post->author->avatar))
          <img src="{{ $post->author->avatar }}" alt="" class="forum-avatar">
        @endif

        <div class="recent-info">
          <a href="{{ url('forums.posts.show', [
            'post' => 'forums', 'id' => $post->id]) }}">
            {{  $post->topic->title }}
          </a>
          <p class="description">
            {{ $post->created_at->diffForHumans() }} by
            <a href="{{ url('users.show', ['slug' => $post->author->slug]) }}">
              {{   $post->author->username }}
            </a>
          </p>
        </div>
      </div>
    @endforeach
  @else
    {{ _('No posts found.') }}
  @endif
</div>
