@extends('master')

@section('content')

    <div id="sign"></div>
    <div class="row">
        <div class="col-md-5 sign-container">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#">Sign in</a></li>
                <li>{{ HTML::linkRoute('auth.register', _('Register')); }}</li>
            </ul>
            <div id="sign-box">
                <h1 class="text-center">{{ _('Login') }}</h1>
                {{ BootForm::open() }}
                {{ bootForm::text(_('Username or email'), 'usermail') }}
                {{ bootForm::password(_('Password'), 'password') }}
                {{ bootForm::checkbox(_('Remember me (private computers)'), 'remember') }}
                {{ bootForm::token() }}
                {{ bootForm::submit(_('Login'), 'btn-primary') }}
                {{ bootForm::close() }}
            </div>
        </div>
    </div>
@stop
