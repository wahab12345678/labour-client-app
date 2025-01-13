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
					<h3>Contact Us</h3>
				</div>
				<ol class="breadcrumb justify-content-center p-0 m-0">
				  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
				  <li class="breadcrumb-item active">Contact Us</li>
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
                    <h3>Get in <span class="alternate">Touch</span></h3>
                    <p>We’re here to help! Whether you have a question, need assistance, or want to give feedback, our team is ready to assist you. Feel free to reach out.</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form id="contactUs" action="{{ route('contact.store') }}" method="POST" class="row">
            @csrf
            <div class="col-md-6">
                <input type="text" class="form-control main @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <input type="email" class="form-control main @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <input type="text" class="form-control main @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <textarea name="message" id="message" class="form-control main @error('message') is-invalid @enderror" rows="10" placeholder="Your Message" required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-main-md">Send Message</button>
            </div>
        </form>
    </div>
</section>

<!--================================
=            Google Map            =
=================================-->
<section class="map">
	<!-- Google Map -->
	<div id="map" data-latitude="40.712776" data-longitude="-74.005974" data-marker="images/icon/marker.png" data-marker-name="{{env('APP_NAME')}}"></div>
	<div class="address-block">
		<h4>Docklands Convention</h4>
		<ul class="address-list p-0 m-0">
			<li><i class="fa fa-home"></i><span>Street Address, Location, <br>City, Country.</span></li>
			<li><i class="fa fa-phone"></i><span>[00] 000 000 000</span></li>
		</ul>
		<a href="#" class="btn btn-white-md">Get Direction</a>
	</div>
</section>
<!--====  End of Google Map  ====-->
@endsection
