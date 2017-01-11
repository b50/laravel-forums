<h4>{{ _('Recent topics') }}</h4>
<div class="box-recent">
  @if ($topics->count())
    @foreach ($topics as $topic)
      <div class="recent">
        @if (file_exists($topic->author->avatar))
          <img src="{{ $topic->author->avatar }}" alt="" class="forum-avatar">
        @endif

        <div class="recent-info">
          <a href="{{ route('forums.posts.show', [
                'post' => 'forums', 'id' => $topic->id]) }}">
            {{  $topic->title }}
          </a>
          <p class="description">
            {{ $topic->created_at->diffForHumans() }} by
              @if ($topic->author->user)
                  <a href="{{ route('users.show', ['id' => $topic->author->id]) }}">
                      {{ $topic->author->user->name }}
                  </a>
              @else
                  {{ _('user deleted') }}
              @endif
          </p>
        </div>
      </div>
    @endforeach
  @else
    <?= _('No topics found.'); ?>
  @endif
</div>
