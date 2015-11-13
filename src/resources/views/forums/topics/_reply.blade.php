<h1>{{ _('Reply') }}</h1>

{{ BootForm::openHorizontal(0, 12); }}
	@include('forums._editor', ['content' => $quotes, 'button' => _('Reply')])
@if (\Bouncer::hasPermission('forums.response') and $topic->parents and last($topic->parents)->type == 'suggestions')
	@if (\Input::get('devresponse'))
		{{ BootForm::checkbox(_('Developer response'), 'devresponse')->check() }}
	@else
		{{ BootForm::checkbox(_('Developer response'), 'devresponse') }}
	@endif
@endif
{{ Form::close() }}
