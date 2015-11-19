<h1>{{ _('Delete post') }}</h1>
<hr>
{{ HTML::flash() }}
<div class="row">
    <div class="col-md-9">
        <p class="pull-left button-align">{{ _('Are you sure you want to delete this post?') }}</p>
    </div>
    <div class="col-md-3">
        <div class="pull-right">
            {{ Form::open() }}
            {{ HTML::linkRoute('forums.posts.show', _('Back to post'), [\Route::current()->parameter('topicType'), 'id' => $post->id], ['class' => 'btn btn-default']) }}
            {{ Form::hidden('id', $post->id) }}
            {{ Form::submit(_('Delete'), ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="box margin padding">
            {{ $post->html }}
        </div>
    </div>
</div>
