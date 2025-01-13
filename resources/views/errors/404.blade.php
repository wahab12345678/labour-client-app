@extends('frontend.includes.main')
@section('content')
<!--===================================
=            Error Section            =
====================================-->

<section class="section error">
	<div class="container">
		<div class="row">
			<div class="col-md-6 m-auto">
				<div class="block text-center">
					<img src="{{ asset('images/404.png')}}" class="img-fluid" alt="404">
					<h3>Oops!... <span>Page Not Found.</span></h3>
					<a href="{{ url('/')}}" class="btn btn-main-md">Go to home</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of Error Section  ====-->

@endsection
