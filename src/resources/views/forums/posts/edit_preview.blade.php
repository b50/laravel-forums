@extends('forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $post->topic, 'Edit'))
@section('title', $post->title)
@section('content')
    @include('forums.posts._edit_preview')
@stop
