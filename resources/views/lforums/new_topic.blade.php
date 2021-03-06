@extends('b50/laravel-forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.show', $forum->parents, _('New topic')))
@section('title', _('New topic'))

@section('content')
    <h1>{{ _('New topic') }}</h1>
    {{ BootForm::openHorizontal(1, 11); }}
    {{ BootForm::text(_('Title'), 'title', \Input::old('title'), [], [1, 11]) }}
    {{ BootForm::select(_('Forum'), 'path', $forums)->select(\Input::old('path') ?: $forum->path) }}
    @include('b50/laravel-forums/forums._editor', ['content' => ''])
    {{ BootForm::close() }}
@stop
