<h4>{{ _('Recent topics') }}</h4>
<div class="box-recent">
	@if ($topics->count())
		@foreach ($topics as $topic)
			<div class="recent">
				{{ HTML::imageExists("images/avatars/{$topic->user_slug}/{$topic->user_slug}-small.jpg", '', ['class' => 'forum-avatar']) }}
				<div class="recent-info">
					{{ HTML::linkRoute('forums.topics.show', $topic->title, [$topic->id, $topic->slug]) }}
					<p class="description">
						{{ $topic->created_at }} by
						{{ HTML::linkRoute('users.show', $topic->username, $topic->user_slug) }}
					</p>
				</div>
			</div>
		@endforeach
	@else
		<?= _('No topics found.'); ?>
	@endif
</div>
