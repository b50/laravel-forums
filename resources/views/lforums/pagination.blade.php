<?php $presenter = new \Kaamaru\Forums\Core\Pagination\CustomPresenter($paginator); ?>

<ul class="pagination pagination-md">
    <li><span class="pages">{{ _('Pages:') }}</span></li>
    @if($paginator->getLastPage() > 1)
        {{ $presenter->render(); }}
    @else
        <li class="active"><span>1</span></li>
    @endif
</ul>

