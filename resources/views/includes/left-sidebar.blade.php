@php
$base  = basename(app("request")->url());
@endphp

<?php if ($detect->isMobile()): ?>
	<div id="accordion">
		<?php foreach ($visa as $d => $v):
			$text = '';
			$sectionArr = array(2,3,4,5,6,7,8,24,29);
			if(in_array($v->sections_id, $sectionArr)){
				$text = "-for-pakistani-nationals";
			}
		 ?>
			<div class="card card-custom">
				<?php if ($v->is_right == 1): ?>
				<div class="box-head orange-background">
					<?php else: ?>
						<div class="box-head ">
					<?php endif ?> 
					<a class="main_title" data-toggle="collapse" href="#bb<?= $d; ?>" data-url="{{ url($v->country_name.'/'.$v->slug.$text) }}">{{ $v->title }}</a>
				</div>

				<div id="bb<?= $d; ?>" class="collapse" data-parent="#accordion">
					<div class="body-card">
								<?php if($slug == $v->slug): ?>
								<div style="margin-top: -5px; width: 100%;">
									<ins class="adsbygoogle" style="display:block;width:100%;height:300px" data-ad-client="ca-pub-9682339330195266" data-ad-slot="1954891333" data-ad-format="auto"></ins>
									<script>
										setTimeout(function(){(adsbygoogle = window.adsbygoogle || []).push({})}, 1000);
									</script>
								</div>
								<?php endif; ?>
								<div class="text-justify" style="padding: 0 8px;">
									@if(!empty($extra_content))
									{!! renderHTML($extra_content) !!}
									@endif
									{!! renderHTML(renderFlags($v->content)) !!}
									@if(!empty($extra_content))
									{!! renderHTML($extra_content) !!}
									@endif
								</div>

								<?php if($slug == $v->slug): ?>
									<div style="margin-bottom: -7px; width: 100%;">
										<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-9682339330195266" data-ad-slot="1954891333" data-ad-format="auto"></ins>
										<script>
											setTimeout(function(){(adsbygoogle = window.adsbygoogle || []).push({})}, 1000);
										</script>
									</div>
								<?php endif; ?>
					</div>
				</div>
			</div>

		<?php endforeach; ?>

	</div>

	<?php else: ?>

		<div class="sidebar">
			<?php foreach ($visa as $d => $v) {
				$text = '';
				$sectionArr = array(2,3,4,5,6,7,8,24,29);
				if(in_array($v->sections_id, $sectionArr)){
					$text = "-for-pakistani-nationals";
				}
				?>
				
				<?php if ($v->is_right == 0 && $d == 0): ?>

					<h3 class="left-sidebar-main-h {{ $base == $v->slug.$text?'active-li':'' }}">
						<a href="{{ url($v->country_name.'/'.$v->slug.$text) }}">{{ $v->title }}</a>
					</h3>

				<?php endif ?>
			<?php } ?>

			<ul>
				<?php foreach ($visa as $d => $v) { 
						$text = '';
						$sectionArr = array(2,3,4,5,6,7,8,24,29);
						if(in_array($v->sections_id, $sectionArr)){
							$text = "-for-pakistani-nationals";
						}
					?>
					<?php if ($v->is_right == 0 && $d != 0 && empty($v->deleted_at)): ?>
						
						<li class="{{ $base == $v->slug.$text?'active-li':'' }}">
							<h3 class="left-sidebar-li-h">
								<a href="{{ url($v->country_name.'/'.$v->slug.$text) }}" class="{{ $base == $v->slug.$text?'active-a':'' }}">{{ $v->title }}</a>
							</h3>
						</li>

					<?php endif ?>
				<?php } ?>
				<li>
					<h3 class="left-sidebar-li-h">
						<a href="{{url('/')}}"><< Back To Home</a>
					</h3>
				</li>
			</ul>
		</div>

		<?php endif ?>