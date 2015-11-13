@extends('master')

@section('content')
	<div id="sign"></div>
	<div class="row">
		<div class="col-md-5 sign-container">
			<ul class="nav nav-tabs nav-justified">
				<li>{{ HTML::linkRoute('auth.signIn', 'Sign in') }}</li>
				<li class="active"><a href="#">{{ _('Sign up') }}</a></li>
			</ul>
			<div id="sign-box">
				<h1 class="text-center">{{ _('Sign up') }}</h1>
				<br>
				{{ Form::open(['role' => 'form']) }}
				{{ Form::bsText('username', _('Username')) }}
				{{ Form::bsEmail('email', _('Email')) }}
				{{ Form::bsPassword('password', _('Password')) }}
				{{ Form::bsPassword('password_confirmation', _('Confirm password')) }}
				{{ Form::bsCheckbox('terms', _('I agree to the Terms of Service and Privacy Policy')) }}
				{{ Form::submit('Sign up', ['class' => 'btn btn-primary']) }}
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop
