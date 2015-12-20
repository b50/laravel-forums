@extends('kaamaru/laravel-forums....forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic))
@section('title', $topic->title)
@section('content')
    @include('kaamaru/laravel-forums/forums.topics._topic')
@stop
