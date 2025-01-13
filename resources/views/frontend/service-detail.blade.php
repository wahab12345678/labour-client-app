@extends('frontend.includes.main')
@section('header')
<style type="text/css">
    .category-details {
        background-color: #fff;
        padding: 50px 0;
        text-align: center;
    }

    .category-details h2 {
        color: #ff8800; /* Orange */
        font-weight: bold;
    }

    .category-details p {
        color: #333; /* Black */
        font-size: 1.1rem;
    }
</style>
@endsection
@section('content')
<!--================================
=            Page Title            =
=================================-->

<section class="page-title bg-title overlay-dark">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="title">
					<h3>Our Services</h3>
				</div>
				<ol class="breadcrumb justify-content-center p-0 m-0">
				  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
				  <li class="breadcrumb-item active">Services</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="section category-details py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <!-- Category Name -->
                <h2 class="text-uppercase text-warning font-weight-bold">{{ $category->name }}</h2>
                <!-- Category Description -->
                <p class="text-muted mt-3">{{ $category->description }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
