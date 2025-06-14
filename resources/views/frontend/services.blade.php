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
    /* height: 200px; Fixed height */
      height: 275px;
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
<section class="section pricing py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <h2 class="text-uppercase font-weight-bold">Our <span class="text-warning">Services</span></h2>
                    <p class="lead text-muted mx-auto" style="max-width: 800px;">
                        At {{ env('APP_NAME') }}, we are committed to providing top-notch solutions for both labor and client booking needs. With a focus on efficiency, reliability, and customer satisfaction, we offer a wide range of services to meet your unique requirements. Whether you're looking for skilled professionals or want to book services for your business, we’re here to help.
                    </p>
                </div>
            </div>
        </div>
            <!-- $categories = \App\Models\Category::where('status', '1')->get(); -->

        @php
            $categories = \App\Models\Category::where('is_visible', '1')->get();

        @endphp

        <div class="row">
            @foreach ($categories as $key => $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <!-- Pricing Item -->
                    <div class="pricing-item card h-100 shadow-sm border-0 transition-all hover-shadow">
                        <div class="card-body p-4">
                            <!-- Image -->
                            <div class="text-center mb-4">
                                <img src="{{ asset($category->img_path) }}" alt="{{ $category->name }}" class="img-fluid rounded-lg" style="max-height: 275px; object-fit: cover;">
                            </div>

                            <!-- Title -->
                            <div class="pricing-heading text-center mb-3">
                                <h5 class="text-uppercase font-weight-bold text-dark">{{ $category->name }}</h5>
                            </div>

                            <!-- Description -->
                            <div class="price text-center mb-4">
                                <p class="text-muted description">{{ Str::limit($category->description, 100) }}</p>
                            </div>

                            <!-- Call to Action Button -->
                            <div class="text-center">
                                <a href="{{ route('service.details', $category->slug) }}" class="btn btn-warning btn-lg px-4">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section pricing py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <div class="section-title">
                    <h2 class="text-uppercase font-weight-bold">Our <span class="text-warning">Contractors</span></h2>
                    <p class="lead text-muted mx-auto" style="max-width: 800px;">
                        At {{ env('APP_NAME') }}, we pride ourselves on working with a dedicated team of skilled contractors who deliver high-quality results across a variety of sectors. Whether you are looking for specialized labor, experienced tradespeople, or general contractors, our network of trusted professionals ensures your projects are completed on time and to the highest standards.
                    </p>
                </div>
            </div>
        </div>

        @php
            $contractors = \App\Models\User::role('contractor')->where('status', 1)->get();

        @endphp

        <div class="row">
            @foreach ($contractors as $contractor)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <!-- Contractor Card -->
                    <div class="contractor-card card h-100 shadow-sm border-0 transition-all hover-shadow">
                        <div class="card-body p-4 text-center">
                            <!-- Image -->
                            <div class="image mb-4">
                                <img src="{{ $contractor->image_url ?? 'images/speakers/speaker-one.jpg' }}" alt="{{ $contractor->name }}" class="img-fluid rounded-circle mx-auto d-block" style="max-width: 150px; height: 150px; object-fit: cover;">
                            </div>

                            <!-- Name -->
                            <h5 class="card-title text-uppercase font-weight-bold text-dark mb-3">{{ $contractor->name }}</h5>

                            <!-- Call to Action Button -->
                            <a href="{{ route('contractor.details', $contractor->meta->slug ?? '#') }}" class="btn btn-warning btn-sm px-4">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
