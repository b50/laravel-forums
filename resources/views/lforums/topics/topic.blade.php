@extends('lforums....master')
@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic))
@section('title', $topic->title)
@section('content')
    @include('lforums.topics._topic')
@stop
