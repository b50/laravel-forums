@foreach ($forums as $forum)

    @if (preg_match("~$path/.$~", $forum->path))
        <tr>
            <td class="forum-folder">
                @if (Auth::check() and $forum->read)
                    {{ Html::uLinkRoute('forums.unread', '<i class="fa fa-folder-o"></i>',
                        ['id' => $forum->id, 'slug' => $forum->slug, '_token' => csrf_token(), 'index' => $index]) }}
                @elseif (Auth::check())
                    {{ Html::uLinkRoute('forums.read', '<i class="fa fa-folder"></i>',
                        ['id' => $forum->id, 'slug' => $forum->slug, '_token' => csrf_token(), 'index' => $index]) }}
                @else
                    <i class="fa fa-folder"></i>
                @endif
            </td>
            <td class="board">
                {!! Html::linkRoute('forums.show', $forum->name, ['id' => $forum->id, 'slug' => $forum->slug]) !!}<br>

                <div class="subforums">
                    <?php $i = 0 ?>
                    @foreach ($forums as $subforum)
                        @if (preg_match("~$forum->path.~", $subforum->path))

                            @if ($i == 0)
                                <i class="fa fa-long-arrow-right"></i>
                            @endif

                            <?php $i++ ?>
                            {{ Html::linkRoute('forums.show', $subforum->name,
                                ['id' => $subforum->id, 'slug' => $subforum->slug]) }}
                        @endif
                    @endforeach
                </div>

                <span class="description">{{{ $forum->description }}}</span>
            </td>
            <td class="stats">
                <div class="stat">{{ $forum->topics_count }}</div>
                <div class="name">{{ _('Topics') }}</div>
            </td>
            <td class="stats">
                <div class="stat">{{ $forum->posts }}</div>
                <div class="name">{{ _('Posts') }}</div>
            </td>
            <td class="last-forum">
                @if (isset($forum->last_user_username))
                    {{ Html::imageExists("images/avatars/{$forum->last_user_slug}/{$forum->last_user_slug}-small.jpg",
                        $forum->last_user_username, [
                            'class' => 'forum-avatar'
                        ])
                    }}
                    <div class="last-info">
                        {!! Html::linkRoute('forums.posts.show', $forum->last_topic_title, ['topicType' => 'forums', 'id' => $forum->last_post]) !!}
                        <br>
                        <span class="description">{{ $forum->last_topic_updated_at }} by </span>
                        {!! Html::linkRoute('users.show', $forum->last_user_username, ['slug' => $forum->last_user_slug]) !!}
                        <br>
                        {!! Html::uLinkRoute('forums.posts.show', '<i class="icon-chevron-sign-right" style="display: none"></i>', ['topicType' => 'forums', 'id' => $forum->last_post]) !!}
                    </div>
                @endif
            </td>
        </tr>
    @endif
@endforeach
