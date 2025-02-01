@extends('frontend.includes.main')
@section('header')
<style type="text/css">
    /* Define your theme colors */
    :root {
        --theme-orange: #FFA500;  /* Orange */
        --theme-black: #000000;   /* Black */
        --theme-white: #ffffff;   /* White */
    }
    .pricing-item, .contractor-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Ensures equal height */
    min-height: 400px; /* Adjust as needed */
}

.pricing-item img, .contractor-card img {
    width: 100%; /* Full width */
    height: 200px; /* Fixed height */
    object-fit: cover; /* Ensures images are uniformly cropped */
    border-radius: 8px; /* Slight rounding for a better look */
}

.card-body {
    flex-grow: 1; /* Ensures content stretches evenly */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

    .section {
        padding: 40px 0 !important;
    }

    /* Card */
    .pricing-item {
        border: 1px solid #f1f1f1;
        background-color: var(--theme-white);  /* White background for the card */
        transition: transform 0.3s ease-in-out;
    }

    .pricing-item:hover {
        transform: translateY(-10px);  /* Lift the card on hover */
    }

    /* Category title */
    .title h5 {
        color: var(--theme-black);  /* Black for service title */
    }

    /* Category price */
    .price h2 {
        color: var(--theme-orange);  /* Orange for the category name */
        font-size: 2rem;
        font-weight: 600;
    }

    .price p {
        font-size: 1.1rem;
        color: var(--theme-black);  /* Black for description text */
    }

    /* Button */
    .btn-orange {
        background-color: var(--theme-orange);  /* Orange button */
        color: var(--theme-white);  /* White text */
        border-color: var(--theme-orange);
        transition: background-color 0.3s ease-in-out;
    }

    .btn-orange:hover {
        background-color: #ff8c00;  /* Darker shade of orange on hover */
        border-color: #ff8c00;
    }

    /* Button hover effect */
    .btn:hover {
        color: var(--theme-white);
    }

    /* Additional spacing */
    .mb-4 {
        margin-bottom: 1.5rem;
    }

    /* Ensure text is truncated to one line with ellipsis */
    .description {
        white-space: nowrap;            /* Prevent wrapping */
        overflow: hidden;               /* Hide overflowed content */
        text-overflow: ellipsis;        /* Show ellipsis (...) when the text is too long */
        display: block;                 /* Make the paragraph behave like a block element */
        width: 100%;                    /* Ensure the text container takes the full width */
        text-align: center;             /* Center the description */
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

<!--====  End of Page Title  ====-->
<section class="section pricing">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h3>Our <span class="alternate">Services</span></h3>
					<p>
                        At {{env('APP_NAME')}}, we are committed to providing top-notch solutions for both labor and client booking needs. With a focus on efficiency, reliability, and customer satisfaction, we offer a wide range of services to meet your unique requirements. Whether you're looking for skilled professionals or want to book services for your business, we’re here to help.
                    </p>
				</div>
			</div>
		</div>
        @php
            $categories = \App\Models\Category::where('status', '1')->get();
        @endphp
		<div class="row">
            @foreach ($categories as $key => $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    
                    <!-- Pricing Item -->
                    <div class="pricing-item featured card shadow-lg border-light">
                        <div class="card-body">
                            <!-- Image -->
                            <div class="text-center">
                                <img src="{{ $category->img_path }}" alt="{{ $category->img_path }}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                            </div>
        
                            <!-- Title -->
                            <div class="pricing-heading text-center mb-4">
                                <h5 class="text-uppercase font-weight-bold text-dark">{{ $category->name }}</h5>
                            </div>
        
                            <!-- Price / Description -->
                            <div class="price text-center mb-3">
                                <p class="text-muted description">{{ Str::limit($category->description, 100) }}</p>
                            </div>
        
                            <!-- Call to Action Button -->
                            <div class="text-center">
                                <a href="{{ route('service.details', $category->slug) }}" class="btn btn-orange btn-lg">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
	</div>
</section>

<section class="section pricing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-5">
                    <h3 class="text-uppercase font-weight-bold">Our <span class="alternate">Contractors</span></h3>
                    <p class="text-muted">
                        At {{ env('APP_NAME') }}, we pride ourselves on working with a dedicated team of skilled contractors who deliver high-quality results across a variety of sectors. Whether you are looking for specialized labor, experienced tradespeople, or general contractors, our network of trusted professionals ensures your projects are completed on time and to the highest standards.
                    </p>
                </div>
            </div>
        </div>

        @php
            $contractors = \App\Models\User::role('contractor')->get();
        @endphp

        <div class="row">
            @foreach ($contractors as $contractor)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <!-- Contractor Card -->
                <div class="contractor-card card shadow-sm border-light">
                    <div class="image">
                        <img src="images/speakers/speaker-one.jpg" alt="contractor" class="img-fluid rounded-circle mx-auto d-block mt-2" style="max-width: 150px;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title >{{ $contractor->name }}</h5>
                        {{-- <a href="{{ route('contractor.details', $contractor->meta->slug ?? '#') }}" class="btn btn-warning btn-sm">View Profile</a> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
