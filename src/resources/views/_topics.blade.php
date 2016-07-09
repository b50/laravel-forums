{{ $topics->render() }}
<div class="row">
    <div class="col-md-12">
        @if ($topics->count())
            <div id="topics" class="box">
                <table class="table">
                    <tbody>
                    <tr id="topics-order">
                        <td></td>
                        <td>
                            {{ $sort->getSortLink('title') }}
                        </td>
                        <td class="stats">
                            {{ $sort->getSortLink('views') }} / {{ $sort->getSortLink('replies') }}
                        </td>
                        <td>
                            {{ $sort->getSortLink('last_post', _('Last post')) }}
                        </td>
                    </tr>
                    @foreach ($topics as $topic)
                        <tr>
                            <td class="topic-folder">
                                @if (Auth::check() and $topic->read)
                                    {{ Html::uLinkRoute('forums.topics.unread', '<li class="fa fa-circle-o"></li>',
                                        ['type' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => \Route::currentRouteName()]) }}
                                @elseif (Auth::check())
                                    {{ Html::uLinkRoute('forums.topics.read', '<li class="fa fa-circle"></li>',
                                        ['type' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => \Route::currentRouteName()]) }}
                                @else
                                    <li class="fa fa-circle"></li>
                                @endif
                            </td>
                            <td class="topic">
                                @if ($topic->locked)
                                    <i class="fa fa-lock"></i>
                                @endif
                                @if ($topic->sticky)
                                    <i class="fa fa-thumb-tack"></i>
                                @endif
                                <span class="title @if ($topic->sticky) sticky @endif">
                                            {{ $topic->tag }} {{ Html::linkRoute('forums.topics.show', $topic->title, ['id' => $topic->id, 'slug' => $topic->slug]) }}
                                    <br>
                                        </span>
                                        <span class="description">
                                            {{ _('Started by') }}
                                            {!! Html::linkRoute('users.show', $topic->username, $topic->user_slug) !!},
                                            <span class="date">{{ $topic->created_at->diffForHumans() }}</span>
                                        </span>
                            </td>s
                            <td class="stats">
                                {{ $topic->posts_count - 1 }} {{ _('replies') }}<br>
                                {{ $topic->views or 0 }} {{ _('views') }}
                            </td>
                            <td class="last-post">
                                {{ Html::imageExists("images/avatars/tiny-{$topic->last_user_slug}.jpg",
                                    $topic->username, ['class' => 'forum-avatar']
                                ) }}

                                <div class="last-info">
                                    {!! Html::linkRoute('users.show', $topic->last_user_username, $topic->last_user_slug) !!}
                                    <br>
                                    @if (isset($topic->updated_at))
                                        {!! Html::linkRoute('forums.posts.show', $topic->updated_at, ['type' => 'forums', 'id' => $topic->last_post]) !!}
                                        <br>
                                    @endif
                                </div>

                                {!! Html::uLinkRoute('forums.topics.show', '<i class="icon-chevron-sign-right" style="display: none"></i>',
                                    ['id' => $topic->id, 'slug' => $topic->slug], ['page' => $topic->pages.'#last']
                                ) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="box margin padding">
                {{ _('No topics found.') }}
            </div>
        @endif
    </div>
</div>
{{ $topics->render() }}