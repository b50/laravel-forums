@extends('kaamaru/laravel-forums.forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $post->topic, 'Edit'))
@section('title', $post->title)
@section('content')
    @include('Kaamaru\Forums::forums.posts._edit_preview')
@stop
