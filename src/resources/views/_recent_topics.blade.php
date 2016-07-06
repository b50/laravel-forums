<h4>{{ _('Recent topics') }}</h4>
<div class="box-recent">
    @if ($topics->count())
        @foreach ($topics as $topic)
            <div class="recent">
                {!! Html::imageExists("images/avatars/{$topic->user_slug}/{$topic->user_slug}-small.jpg", '', ['class' => 'forum-avatar']) !!}
                <div class="recent-info">
                    {!! Html::linkRoute('forums.topics.show', $topic->title, [$topic->id, $topic->slug]) !!}
                    <p class="description">
                        {{ $topic->created_at->diffForHumans() }} by
                        {!! Html::linkRoute('users.show', $topic->username, $topic->user_slug) !!}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <?= _('No topics found.'); ?>
    @endif
</div>
