@section('scripts', HTML::script('scripts/ace/ace.js'))
@section('styles')
	@parent
    {{ HTML::style('styles/editor.css') }}
@show

{{-- Show content error to the right of tabs --}}
@if ($errors->has('content'))
	<div class="has-error pull-right">
		<div class="help-block">{{ $errors->first('content') }}</div>
	</div>
@endif

@if (Input::get('tab') == 'visual')
    <ul class="nav nav-tabs editor-tabs">
        {{ HTML::linkRoute('forums.topics.new', $forum->name, $forum->slug) }}
        <li>{{ HTML::link(Request::url().'?tab=visual', 'Visual') }}</li>
        <li class="active"><a {{ $errors->has('content') ? 'class="error"' : '' }} href="#">{{ _('Source') }}</a></li>
    </ul>
@else
    <ul class="nav nav-tabs editor-tabs">
        <li class="active"><a {{ $errors->has('content') ? 'class="error"' : '' }} href="#">{{ _('Visual') }}</a></li>
        <li>{{ HTML::link(Request::url().'?tab=source', 'Source') }}</li>
    </ul>
    <noscript>
        <div class="box" id="article-content">
            {{ _('You need javascript to use the visual editor. Enable javascript or click the source tab.') }}
        </div>
    </noscript>
@endif
<div id="editor-pannel" {{ $errors->has('content') ? 'class="error"' : '' }}>
	<p>{{ HTML::link('http://www.enable-javascript.com', _(' Enable javascript for more features!'), ['target' => '_blank']) }}</p>
    <button type="button" class="btn btn-default" id="bold"><i class="fa fa-bold"></i></button>
    <button type="button" class="btn btn-default" id="italic"><i class="fa fa-italic"></i></button>
    <button type="button" class="btn btn-default" id="strikethrough"><i class="fa fa-strikethrough"></i></button>
    <button type="button" class="btn btn-default" id="list-ul"><i class="fa fa-list-ul"></i></button>
    <button type="button" class="btn btn-default" id="list-ol"><i class="fa fa-list-ol"></i></button>
    <button type="button" class="btn btn-default" id="spoiler"><i class="fa fa-warning"></i></button>
    <button type="button" class="btn btn-default" id="quote"><i class="fa fa-quote-left"></i></button>
    <button type="button" class="btn btn-default" id="link"><i class="fa fa-link"></i></button>
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" id="image"><i class="fa fa-picture-o"></i></button>
    <button type="button" class="btn btn-default" id="rule"><i class="fa fa-minus"></i></button>
    <div class="pull-right">
        {{ Form::button('Preview', ['type' => 'submit', 'class' => 'btn btn-default', 'name' => 'preview', 'value' => 1]) }}
        {{ Form::button(isset($button) ? $button: 'Post', ['type' => 'submit', 'class' => 'btn btn-primary', 'value' => 'post' ]) }}
    </div>
</div>
<div id="editor">{{{ \Input::get('content') ?: $content }}}</div>
{{ Form::textarea('content', \Input::get('content') ?: $content, ['id' => 'editor-text', 'name' => 'content']) }}

{{ Form::token() }}

{{--<script type="text/javascript">--}}
    {{--var editor = ace.edit("editor");--}}
    {{--editor.getSession().setUseWrapMode(true);--}}
    {{--editor.getSession().setMode("ace/mode/markdown");--}}
    {{--editor.setShowPrintMargin(false);--}}
    {{--editor.renderer.setShowGutter(false);--}}
    {{--$('#editor').show();--}}
    {{--$('#editor-pannel>button').show();--}}
    {{--$('#editor-pannel>p').hide();--}}
    {{--$('#editor-text').hide();--}}

    {{--$('form').submit(function() {--}}
        {{--$('#editor-text').val(editor.getSession().getValue());--}}
    {{--});--}}
{{--</script>--}}


