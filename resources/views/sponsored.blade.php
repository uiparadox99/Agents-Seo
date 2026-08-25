@extends('layouts.master')
@section('content')
<section class="advertise-header">
	<h1 class="heading">Advertise</h1>
</section>
<section  id="advertise-body " class="mt-3 mb-3" s>
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="advertise-maps">
					<div class="heading">
						Sponsored Content
					</div>
					<div class="adv-glance">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus quaerat rem quidem saepe nam, voluptas in aliquid dolorem ipsa similique, sunt quod ut vitae nemo necessitatibus ratione natus neque eos!. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse amet adipisci iste natus ipsa corporis quod, ea totam magni illo. Dolores at consectetur laborum eum nobis, doloremque temporibus eius magni.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta molestiae delectus sint sit cupiditate, voluptas similique nihil possimus laudantium quasi neque fuga atque dolores fugit repellat error, omnis at, eum.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo ipsum reiciendis ipsam, asperiores tempora quas dolore id molestiae ducimus, quidem aliquid nam neque, voluptate eveniet? Molestias, optio perspiciatis iusto nostrum?</p>
					</div>
					<div class="clearfix"></div>
				</div>

			</div>
			<div class="col-md-3 pl-0">
				@include('includes.advertise-sidebar')
			</div>
		</div>
	</div>	
</section>
@endsection