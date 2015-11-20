@extends('kaamaru/laravel-forums.forums.master')
@section('breadcrumbs', Breadcrumbs::render('forums.all'))

@section('content')
    <h1>{{ _('View all topics') }}</h1>

    <ul class="nav nav-pills navbar-right">
        <li>{!! Html::linkRoute('forums.topics.new', _('New topic'), ['id' => 5, 'slug' => 'general']) !!}</li>
    </ul>
    @include('Kaamaru\Forums::forums._topics', ['topics' => $topics])
    <ul class="nav nav-pills navbar-right">
        <li>{!! Html::linkRoute('forums.topics.new', _('New topic'), ['id' => 5, 'slug' => 'general']) !!}</li>
    </ul>
@stop
