@extends('frontend.includes.main')
@section('content')
<!--================================
=            Page Title            =
=================================-->

<section class="page-title bg-title overlay-dark">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="title">
					<h3>Give us a Feedback</h3>
				</div>
				<ol class="breadcrumb justify-content-center p-0 m-0">
				  <li class="breadcrumb-item"><a href="/">Home</a></li>
				  <li class="breadcrumb-item active">Feedback Us</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<!--====  End of Page Title  ====-->


<section class="section contact-form">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h3>Share Your <span class="alternate">Feedback</span></h3>
                    <p>We value your thoughts! Let us know about your experience with this booking. Your feedback helps us improve and serve you better.</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form id="feedbackUs" action="{{ route('feedback-form.store') }}" method="POST" class="row">
            @csrf
            <input type="hidden" name="url" value="{{$url}}" />
            <div class="col-md-12 mb-3">
                <label for="rating" class="form-label fw-bold">Rate Your Experience</label>
                <select class="form-control main @error('rating') is-invalid @enderror" name="rating" id="rating" required>
                    <option value="" disabled selected>Select a rating</option>
                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                    <option value="4">⭐⭐⭐⭐ Good</option>
                    <option value="3">⭐⭐⭐ Average</option>
                    <option value="2">⭐⭐ Poor</option>
                    <option value="1">⭐ Very Poor</option>
                </select>
                @error('rating')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-12 mb-3 mt-3">
                <label for="comment" class="form-label fw-bold">Your Feedback</label>
                <textarea name="comment" id="comment" class="form-control main @error('comment') is-invalid @enderror" rows="5" placeholder="Write your feedback here..." required>{{ old('comment') }}</textarea>
                @error('comment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-main-md">Submit Feedback</button>
            </div>
        </form>
    </div>
</section>
@endsection
