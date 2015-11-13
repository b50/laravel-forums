{{ $topics->links() }}
<ul class="nav nav-pills navbar-left">
	<li>{{ HTML::linkRoute($route, _('Top'), array_merge($routeParams, [
    	'sort' => 'vote', 'order' => 'desc', 'page' => \Input::get('page')
    ])); }}</li>

	<li>{{ HTML::linkRoute($route, _('New'), array_merge($routeParams, [
		'sort' => 'created_at', 'order' => 'desc', 'page' => \Input::get('page')
	])); }}</li>
</ul>
<div class="row">
	<div class="col-md-12">
		@if ($topics->count())
			<div id="topics" class="box">
				<table class="table"><tbody>
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
								{{ HTML::uLinkRoute('forums.topics.unread', '<li class="fa fa-circle-o"></li>',
									['topicType' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => \Route::currentRouteName()]) }}
							@elseif (Auth::check())
								{{ HTML::uLinkRoute('forums.topics.read', '<li class="fa fa-circle"></li>',
									['topicType' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug, '_token' => csrf_token(), 'route' => \Route::currentRouteName()]) }}
							@else
								<li class="fa fa-circle"></li>
							@endif
							{{ $topic->votes }}
							</td>
							<td class="topic">
								@if ($topic->locked)
									<i class="fa fa-lock"></i>
								@endif
								@if ($topic->sticky)
									<i class="fa fa-thumb-tack"></i>
								@endif
								<span class="title @if ($topic->sticky) sticky @endif">
									{{$topic->tag}} {{ HTML::linkRoute('forums.topics.show', $topic->title,
										['topicType' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug]) }}<br>
								</span>
								<span class="description">
									{{ _('Started by') }}
									{{ HTML::linkRoute('users.show', $topic->username, $topic->user_slug) }},
									<span class="date">{{ $topic->created_at }}</span>
								</span>
							</td>
							<td class="stats">
								{{ $topic->posts_count - 1 }} {{ _('replies') }}<br>
								{{ $topic->views or 0 }} {{ _('views') }}
							</td>
							<td class="last-post">
								{{ HTML::imageExists("images/avatars/tiny-{$topic->last_user_slug}.jpg",
									$topic->username, ['class' => 'forum-avatar']
								) }}

								<div class="last-info">
									{{ HTML::linkRoute('users.show', $topic->last_user_username, $topic->last_user_slug) }}
									<br>
									@if (isset($topic->updated_at))
										{{ HTML::linkRoute('forums.posts.show', $topic->updated_at, ['topicType' => 'forums', 'id' => $topic->last_post]) }}
										<br>
									@endif
								</div>

								{{ HTML::uLinkRoute('forums.topics.show', '<i class="icon-chevron-sign-right" style="display: none"></i>',
									[], ['page' => $topic->pages.'#last']
								) }}
							</td>
						</tr>
						@endforeach
					</tbody></table>
			</div>
		@else
			<div class="box">
				<div class="box-section">
					{{ _('No topics found.'); }}
				</div>
			</div>
		@endif
	</div>
</div>
{{ $topics->links() }}
<ul class="nav nav-pills navbar-left">
	<li>{{ HTML::linkRoute($route, _('Top'), array_merge($routeParams, [
    	'sort' => 'vote', 'order' => 'desc', 'page' => \Input::get('page')
    ])); }}</li>

	<li>{{ HTML::linkRoute($route, _('New'), array_merge($routeParams, [
		'sort' => 'created_at', 'order' => 'desc', 'page' => \Input::get('page')
	])); }}</li>
</ul>
