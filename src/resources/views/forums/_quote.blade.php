> <cite>{{ '@'.$quote->author->slug }} wrote on {{ $quote->created_at_date }}</cite>
>
@foreach (explode("\n", $quote->html) as $line)
    > {{ $line }}
@endforeach
