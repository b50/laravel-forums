<h4>{{ _('Recent posts') }}</h4>
<div class="box-recent">
    @if ($posts->count())
        @foreach ($posts as $post)
            <div class="recent">
                {!! Html::imageExists("images/avatars/{$post->user_slug}/{$post->user_slug}-small.jpg", '', ['class' => 'forum-avatar']) !!}
                <div class="recent-info">
                    {!! Html::linkRoute('forums.posts.show', $post->title, ['post' => 'forums', 'id' => $post->id]) !!}
                    <p class="description">
                        {{ $post->created_at }} by
                        {!! Html::linkRoute('users.show', $post->username, ['slug' => $post->user_slug]) !!}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        {{ _('No posts found.') }}
    @endif
</div>
