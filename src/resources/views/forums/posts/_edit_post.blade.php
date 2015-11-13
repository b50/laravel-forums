<h1>{{ _('Edit post') }}</h1>

{{ BootForm::openHorizontal(1, 11); }}

@if ($firstPost)
	 {{ BootForm::text(_('Title'), 'title', \Input::old('title') ?: $post->topic->title) }}
@endif

@include('forums._editor', ['content' => \Input::old('content') ?: $post->markdown, 'button' => _('Edit')])

@if (Bouncer::hasPermission('forums.tag') and $firstPost)
	{{ BootForm::text(_('Tag'), 'tag', \Input::old('tag') ?: $post->topic->tag) }}
@endif

{{ Form::close() }}
