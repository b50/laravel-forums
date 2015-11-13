<h1>{{ _('Report post') }}</h1>
<hr>
<div class="row">
	<div class="col-md-12">
		<p class="pull-left button-align">{{ _('Are you sure you want to report this post?') }}</p>
        <div class="pull-right">
        	{{ Form::open() }}
        		{{ HTML::linkRoute('forums.posts.show', _('Back to post'), [\Route::current()->parameter('topicType'), 'id' => $post->id], ['class' => 'btn btn-default']) }}
        		{{ Form::hidden('id', $post->id) }}
        		{{ Form::submit(_('Report'), ['class' => 'btn btn-primary']) }}
        	{{ Form::close() }}
        </div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="box padding margin">
			{{ $post->markdown }}
		</div>
	</div>
</div>
