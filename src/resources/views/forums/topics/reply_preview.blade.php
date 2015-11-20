@extends('kaamaru/laravel-forums.forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, 'Reply'))
@section('title', $topic->title)
@section('content')
    @include('Kaamaru\Forums::forums.topics._reply_preview')
@stop
