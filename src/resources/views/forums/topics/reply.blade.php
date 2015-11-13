@extends('...master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $topic, _('Reply')))
@section('title', $topic->title)

@section('content')
	@include('forums.topics._reply')
@stop
