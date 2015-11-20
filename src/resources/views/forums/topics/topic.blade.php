@extends('Kaamaru\Forums::...forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic))
@section('title', $topic->title)
@section('content')
    @include('Kaamaru\Forums::forums.topics._topic')
@stop
