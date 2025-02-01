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
					<h3>Our Contractors</h3>
				</div>
				<ol class="breadcrumb justify-content-center p-0 m-0">
				  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
				  <li class="breadcrumb-item active">{{$contractor->name}}</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="section category-details py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <!-- Contractor Name -->
                <h2 class="text-uppercase text-warning font-weight-bold mb-4">{{ $contractor->name }}</h2>
            </div>
        </div>

        <!-- Contractor Images -->
        <div class="row">
            @if ($contractor->contractorImages->isNotEmpty())
                @foreach ($contractor->contractorImages as $image)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contractor-image-card card shadow-sm border-0 h-100">
                            <img src="{{ asset($image->image_url) }}" alt="Contractor Image" class="img-fluid rounded-lg">
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">No images available for this contractor.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
