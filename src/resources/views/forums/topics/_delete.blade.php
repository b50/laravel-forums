<h1>{{ _('Delete topic') }}</h1>
<hr>
{!! Html::flash() !!}
<div class="row">
    <div class="col-md-9">
        <p>{{ sprintf(_('Are you sure you want to delete the topic, %s?'),
        	Html::linkRoute('forums.topics.show', $topic->title, ['topicType' => 'forums', 'id' => $topic->id, 'slug' => $topic->slug])) }}</p>
    </div>
    <div class="col-md-3">
        <div class="pull-right">
            {!! Form::open() !!}
            {{ Html::linkRoute('forums.topics.show', _('Back to topic'), [\Route::current()->parameter('topicType'), 'id' => $topic->id, 'slug' => $topic->slug],
                ['class' => 'btn btn-default']) }}
            {!! Form::hidden('id', $topic->id) !!}
            {!! Form::submit(_('Delete'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
