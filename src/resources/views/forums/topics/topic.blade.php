@extends('...forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic))
@section('title', $topic->title)
@section('content')
	@include('forums.topics._topic')
@stop
