<h4>{{ _('Recent topics') }}</h4>
<div class="box-recent">
  @if ($topics->count())
    @foreach ($topics as $topic)
      <div class="recent">
        @if (file_exists($topic->author->avatar))
          <img src="{{ $topic->author->avatar }}" alt="" class="forum-avatar">
        @endif

        <div class="recent-info">
          <a href="{{ url('forums.posts.show', [
                'post' => 'forums', 'id' => $topic->id]) }}">
            {{  $topic->title }}
          </a>
          <p class="description">
            {{ $topic->created_at->diffForHumans() }} by
            <a href="{{ url('users.show', ['slug' => $topic->author->slug]) }}">
              {{   $topic->author->username }}
            </a>
          </p>
        </div>
      </div>
    @endforeach
  @else
    <?= _('No topics found.'); ?>
  @endif
</div>
