
<div class="sidebar">
	<ul>
		<?php foreach ($home as $h) { 
			?>
			<li>
				<h3 class="left-sidebar-li-h">
					<a href="{{ url($h->country_name.'/'.$h->slug) }}">{{ $h->title }}</a>
				</h3>
			</li>
		<?php } ?>
	</ul>
</div>