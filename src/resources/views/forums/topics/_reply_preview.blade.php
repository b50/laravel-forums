<div class="box-header-blue">{{ _('Preview') }}: {{{ $topic->title }}}</div>
@include('forums.topics._preview', ['post' => $post, 'topic' => $topic])
