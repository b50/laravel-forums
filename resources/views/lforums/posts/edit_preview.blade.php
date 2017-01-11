@extends('kaamaru/laravel-forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $post->topic, 'Edit'))
@section('title', $post->title)
@section('content')
    @include('kaamaru/laravel-forums/forums.posts._edit_preview')
@stop
