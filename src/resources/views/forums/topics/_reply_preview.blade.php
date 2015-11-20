<div class="box-header-blue">{{ _('Preview') }}: {{{ $topic->title }}}</div>
@include('Kaamaru\Forums::forums.topics._preview', ['post' => $post, 'topic' => $topic])
