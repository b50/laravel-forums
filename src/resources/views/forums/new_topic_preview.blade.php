@extends('forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.show', $forum->parents, 'New topic'))
@section('title', $topic->title)
@section('content')

<div class="box-header">{{ _('Preview') }}: {{{ $topic->title }}}</div>
@include('topics._preview')
@stop
