{{ $topics->links() }}
<div class="row">
    <div class="col-md-12">
        @if ($topics->count())
            <div id="topics" class="box">
                <table class="table">
                    <tbody>
                    <tr id="topics-order">
                        <td></td>
                        <td>
                            <a href="{{ $sort->getSortLink('title') }}">
                                {{ _('Title') }}
                            </a>
                        </td>
                        <td class="stats">
                            <a href="{{ $sort->getSortLink('views') }}">
                                {{ _('Views') }}
                            </a>
                            <a href="{{ $sort->getSortLink('replies') }}">
                                {{ _('Replies') }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ $sort->getSortLink('last_post') }}">
                                {{ _('Last post') }}
                            </a>
                        </td>
                    </tr>
                    @foreach ($topics as $topic)
                        <tr>
                            <td class="topic-folder">
                                @if (Auth::check() and $topic->read)
                                    <a href="{{ route('forums.topics.unread', ['type' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => \Route::currentRouteName()]) }}">
                                        <li class="fa fa-circle-o"></li>
                                    </a>
                                @elseif (Auth::check())
                                    <a href="{{ route('forums.topics.read', ['type' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => \Route::currentRouteName()]) }}">
                                        <li class="fa fa-circle"></li>
                                    </a>
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
                                     <a href="{{ route('forums.topics.show', ['id' => $topic->id, 'slug' => $topic->slug]) }}">
                                        {{ $topic->title }}
                                    </a>
                                    <br>
                                        </span>
                                        <span class="description">
                                            {{ _('Started by') }}
                                            <a href="{{ route('users.show', [$topic->user_slug]) }}">
                                                {{ $topic->name }}
                                            </a>
                                            <span class="date">{{ $topic->created_at->diffForHumans() }}</span>
                                        </span>
                            </td>
                            <td class="stats">
                                {{ $topic->posts_count - 1 }} {{ _('replies') }}<br>
                                {{ $topic->views or 0 }} {{ _('views') }}
                            </td>
                            <td class="last-post">
                                @if(File::exists("images/avatars/tiny-{$topic->last_user_slug}.jpg"))
                                    <img src="images/avatars/tiny-{{$topic->last_user_slug}}.jpg"
                                        "class" => "forum-avatar"
                                        alt="{{$topic->last_user_slug}}-avatar">
                                @endif

                                <div class="last-info">
                                    @if ($topic->last_user)
                                    <a href="{{ route('users.show', [$topic->last_user_slug]) }}">
                                        {{ $topic->last_user->name }}
                                    </a>
                                    @else

                                    @endif
                                    <br>
                                    @if (isset($topic->updated_at))
                                        <a href="{{ route('forums.posts.show', ['type' => 'forums', 'id' => $topic->last_post]) }}">
                                            {{ $topic->updated_at }}
                                        </a>
                                        <br>
                                    @endif
                                </div>
                                <a href="{{ route('forums.posts.show', ['id' => $topic->id, 'slug' => $topic->slug], ['page' => $topic->pages.'#last']) }}">
                                    <i class="icon-chevron-sign-right" style="display: none"></i>
                                </a>
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
{{ $topics->links() }}