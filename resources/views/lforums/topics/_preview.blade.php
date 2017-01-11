<div class="posts" id="preview">
    @include('b50/laravel-forums/forums._post', ['preview' => true])
</div>

{{-- Setup as two forms to avoid anoying Codeception (v2.0.5) bug >_> --}}
{!! Form::open(['class' => 'form-horizontal pull-left', 'role' => 'form']); !!}
{!! Form::hidden('content', $post->markdown) !!}
{!! Form::hidden('title', isset($title) ? $title : $topic->title) !!}
{!! Form::hidden('forum', \Input::get('forum')) !!}
@if (\Bouncer::hasPermission('forums.response') and $topic->parents and last($topic->parents)->type == 'suggestions')
    {!! Form::hidden('devresponse', \Input::get('devresponse')) !!}
@endif
@if (Bouncer::hasPermission('forums.tag'))
    {!! Form::hidden('tag', \Input::get('tag')) !!}
@endif
{!! Form::button('Back', ['type' => 'submit', 'class' => 'btn btn-default', 'name' => 'back', 'value' => 1]) !!}
{!! Form::close() !!}

{!! Form::open(['class' => 'form-horizontal pull-left', 'role' => 'form', 'style' => 'margin-left: 10px']); !!}
{!! Form::hidden('content', $post->markdown) !!}
{!! Form::hidden('title',  isset($title) ? $title : $topic->title) !!}
{!! Form::hidden('forum', \Input::get('forum')) !!}
@if (\Bouncer::hasPermission('forums.response') and $topic->parents and last($topic->parents)->type == 'suggestions')
    {!! Form::hidden('devresponse', \Input::get('devresponse')) !!}
@endif
@if (Bouncer::hasPermission('forums.tag'))
    {!! Form::hidden('tag', \Input::get('tag')) !!}
@endif
{!! Form::button(isset($button) ? $button : 'Post', ['type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'post', 'value' => 'post']) !!}
{!! Form::close() !!}

