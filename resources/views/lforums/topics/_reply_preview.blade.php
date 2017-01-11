<div class="box-header-blue">{{ _('Preview') }}: {{{ $topic->title }}}</div>
@include('kaamaru/laravel-forums/forums.topics._preview', ['post' => $post, 'topic' => $topic])
