@extends('forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, 'Reply'))
@section('title', $topic->title)
@section('content')
    @include('forums.topics._reply_preview')
@stop
