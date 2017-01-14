@foreach ($forums as $forum)
    @if (ends_with($forum->path, $parentId))
        <tr>
            <td class="forum-folder">
                <?php $readParameters = [
                    'id' => $forum->id,
                    'slug' => $forum->slug,
                    '_token' => csrf_token(),
                    'index' => $index
                ]; ?>
                @if (Auth::check() and $forum->read)
                    <a href="{{ route('forums.unread', $readParameters) }}">
                        <i class="fa fa-folder-o"></i>
                    </a>
                @elseif (Auth::check())
                    <a href="{{ route('forums.read', $readParameters) }}">
                        <i class="fa fa-folder"></i>
                    </a>
                @else
                    <i class="fa fa-folder"></i>
                @endif
            </td>
            <td class="board">
                <a href="{{ route('forums.show', [
                    'id' => $forum->id, 'slug' => $forum->slug
                ]) }}">
                    {{ $forum->name }}
                </a>
                <br>
                <div class="subforums">
                    <?php $i = 0 ?>
                    @foreach ($forums as $subforum)
                        @if (preg_match("~$forum->path.~", $subforum->path))

                            @if ($i == 0)
                                <i class="fa fa-long-arrow-right"></i>
                            @endif

                            <?php $i++ ?>
                            <a href="{{ route('forums.show', [
                                'id' => $subforum->id,
                                'slug' => $subforum->slug
                            ]) }}">
                                {{ $subforum->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
                <span class="description">{{ $forum->description }}</span>
            </td>
            <td class="stats">
                <div class="stat">{{ $forum->topic_count }}</div>
                <div class="name">{{ _('Topics') }}</div>
            </td>
            <td class="stats">
                <div class="stat">{{ $forum->post_count }}</div>
                <div class="name">{{ _('Posts') }}</div>
            </td>
            <td class="last-forum">
                @if ($forum->last_topic)
                    @if (file_exists($avatar = $forum->last_topic->last_user->avatar))
                        <img src="{{ $avatar }}" alt="" class="forum-avatar">
                    @endif
                    <div class="last-info">
                        <a href="{{ route('forums.posts.show', [
                            'topicType' => 'forums',
                            'id' => $forum->last_topic->last_post->id
                        ]) }}">
                            {{  $forum->last_topic->title }}
                        </a>
                        <br>
                        <span class="description">
              {{ $forum->last_topic->updated_at->diffForHumans() }} by
            </span>
                        @if ($forum->last_topic->author->user)
                            @if(Route::has('users.show'))
                                <a href="{{ route('users.show', [
                        'id' => $forum->last_topic->last_user->id
                    ]) }}">
                                    {{  $forum->last_topic->last_user->user->name() }}
                                </a>
                            @else
                                {{  $forum->last_topic->last_user->user->name() }}
                            @endif
                        @else
                            {{ _('user deleted') }}
                        @endif
                        <br>
                        <a href="{{ route('forums.posts.show', [
              'topicType' => 'forums',
              'id' => $forum->last_topic->last_post->id]) }}">
                            <i class="icon-chevron-sign-right"
                               style="display: none"></i>
                        </a>
                    </div>
                @endif
            </td>
        </tr>
    @endif
@endforeach
