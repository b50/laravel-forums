@extends('b50/laravel-forums....master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, _('Reply')))
@section('title', $topic->title)

@section('content')
    @include('lforums.topics._reply')
@stop
