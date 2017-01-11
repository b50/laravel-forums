@extends('kaamaru/laravel-forums.master')

@section('title', _('Favorites'))
@section('breadcrumbs', Breadcrumbs::render('forums.favorites'))

@section('content')
    <h1>{{ _('Favorites') }}</h1>
    <div class="row">
        <div class="col-md-12">
            @include('kaamaru/laravel-forums/forums._topics', ['topics' => $favorites, 'route' => 'forums.favorites', 'routeParams' => []])
        </div>
    </div>
@stop
