@extends('kaamaru/laravel-forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, 'Reply'))
@section('title', $topic->title)
@section('content')
    @include('kaamaru/laravel-forums/forums.topics._reply_preview')
@stop
