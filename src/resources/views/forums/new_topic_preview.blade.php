@extends('Kaamaru\Forums::forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.show', $forum->parents, 'New topic'))
@section('title', $topic->title)
@section('content')

    <div class="box-header">{{ _('Preview') }}: {{{ $topic->title }}}</div>
    @include('Kaamaru\Forums::topics._preview')
@stop
