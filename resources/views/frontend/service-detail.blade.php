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
				  <li class="breadcrumb-item active">{{$category->name}}</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="section category-details py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <!-- Category Image -->
                @if($category->img_path)
                    <img src="{{ asset($category->img_path) }}" alt="{{ $category->name }}" class="category-image img-fluid rounded-lg shadow mb-5" style="max-width: 100%; height: auto;">
                @endif

                <!-- Category Name -->
                <h2 class="text-uppercase text-warning font-weight-bold mb-4">{{ $category->name }}</h2>

                <!-- Category Description -->
                <p class="text-muted lead mb-5">{{ $category->description }}</p>

                <!-- Key Points Section -->
                @if (isset($category->key_points) && !empty($category->key_points))
                    <div class="key-points-section bg-light p-4 rounded-lg shadow">
                        <h2 class="text-uppercase text-warning font-weight-bold mb-4">Key Points</h2>
                        <ul class="list-group list-group-flush">
                            @foreach(json_decode($category->key_points) as $item)
                                <li class="list-group-item bg-transparent border-0 text-left py-2">
                                    <i class="fas fa-check-circle text-success mr-2"></i> {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
