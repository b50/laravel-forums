{{ $topics->links() }}
<div class="row"><div class="col-md-12">
    @if ($topics->count())
        <div id="topics" class="box"><table class="table">
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
                    </a>/
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
                    @include('lforums.forums.topic', compact('topics'))
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
</div></div>
{{ $topics->links() }}