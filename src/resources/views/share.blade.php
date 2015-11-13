<!-- Twitter -->
<li>
	{{ HTML::uLink("https://twitter.com/intent/tweet?text={e($topic->slug)}&url=".URL::full(),
	'<i class="fa fa-twitter"></i>'
	) }}
</li>

<!-- Facebook -->
<li>
	{{ HTML::uLink("http://www.facebook.com/sharer.php?t={e($topic->slug)}&u=".URL::full(),
	'<i class="fa fa-facebook-square"></i>'
	) }}
</li>

<!-- Google+ -->
<li>
	{{ HTML::uLink('https://plus.google.com/share?url='.URL::full(),
	'<i class="fa fa-google-plus-square"></i>'
	) }}
</li>