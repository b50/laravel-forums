@extends('kaamaru/laravel-forums....master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, _('Reply')))
@section('title', $topic->title)

@section('content')
    @include('Kaamaru\Forums::forums.topics._reply')
@stop
