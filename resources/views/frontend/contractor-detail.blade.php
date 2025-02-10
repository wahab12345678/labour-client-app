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

{{-- <section class="section category-details py-5 bg-light">
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
</section> --}}
<section class="section category-details py-5 bg-light">
    <div class="container">
        <!-- Contractor Name -->
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="text-uppercase text-warning font-weight-bold mb-4">{{ $contractor->name }}</h2>
                <p class="text-muted">Explore the work done by {{ $contractor->name }}</p>
            </div>
        </div>

        <!-- Vertical Gallery Layout -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                @if ($contractor->contractorImages->isNotEmpty())
                    @foreach ($contractor->contractorImages as $image)
                        <div class="work-item mb-4 shadow-sm">
                            <a href="{{ asset($image->image_url) }}" data-toggle="modal" data-target="#imageModal-{{ $loop->index }}">
                                <img src="{{ asset($image->image_url) }}" alt="Contractor Work" class="img-fluid work-image">
                            </a>
                            <div class="work-description p-3 bg-white">
                                <h5 class="mb-1">Project {{ $loop->iteration }}</h5>
                                <p class="text-muted">{{ $image->description ?? 'Project details unavailable' }}</p>
                            </div>
                        </div>

                        <!-- Image Modal -->
                        <div class="modal fade" id="imageModal-{{ $loop->index }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Project {{ $loop->iteration }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset($image->image_url) }}" class="img-fluid rounded-lg" alt="Contractor Work">
                                        <p class="mt-3 text-muted">{{ $image->description ?? 'No additional details available' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="text-muted">No work images available for this contractor.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS for Vertical Gallery -->
<style>
    .work-item {
        overflow: hidden;
        border-radius: 10px;
        background: white;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }

    .work-item:hover {
        transform: translateY(-5px);
    }

    .work-image {
    width: 100%;
    height: auto;
    max-height: 450px;
    object-fit: contain; /* Maintain aspect ratio without cropping */
}

    .work-description {
        text-align: center;
    }

    .modal-body img {
        max-height: 90vh;
        width: auto;
    }
</style>



@endsection
