@extends('forums.master')

@section('breadcrumbs', Breadcrumbs::render('forums.topics.show', $post->topic, _('Edit')))
@section('title', $post->topic->title)

@section('content')
	 @include('forums.posts._edit_post')
@stop
