@php
$base  = basename(app("request")->url());
@endphp
<div class="sidebar right-sidebar">

	<ul>
		<?php foreach ($visa as $v) { ?>

			<?php if ($v->is_right == 1):

				$text = '';
				$sectionArr = array(2,3,4,5,6,7,8,24,29);
				if(in_array($v->sections_id, $sectionArr)){
					$text = "-for-pakistani-nationals";
				}
				?>
			<li class="{{ $base == $v->slug.$text?'active-li':'' }}">
				<h3 class="left-sidebar-li-h">
					<a class="{{ $base == $v->slug.$text?'active-a':'' }}" href="{{ url($v->country_name.'/'.$v->slug.$text) }}">{{ $v->title }}</a>
				</h3>
			</li>
		<?php endif ?>
		
		<?php } ?>
	</ul>


</div>
