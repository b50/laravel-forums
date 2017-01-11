@extends('b50/laravel-forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $post->topic, 'Edit'))
@section('title', $post->title)
@section('content')
    @include('b50/laravel-forums/forums.posts._edit_preview')
@stop
