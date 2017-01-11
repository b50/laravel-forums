@extends('b50/laravel-forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, _('Move topic')))
@section('title', _('Move topic'))

@section('content')
    <h1>{{ _('Move topic') }}</h1>

    <div class="box">
        <div class="box-section">
            {{ BootForm::openHorizontal(1, 11) }}
            {{ BootForm::select('Forum', 'forum', $tree)->select($topic->path) }}
            {{ BootForm::checkbox(_('Post redirection topic.'), 'redirection')->defaultToChecked() }}
            {{ BootForm::submit(_('Move'), 'btn-primary') }}
            {{ BootForm::token() }}

            {{-- TODO Move topic notification --}}
            {{ BootForm::close() }}
        </div>
    </div>
@stop
