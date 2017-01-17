@extends('lforums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.all'))

@section('content')
    <h1>{{ _('View all topics') }}</h1>
    @include('lforums.forums.topics', ['topics' => $topics])
@stop
