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
					<h3>Client Registration</h3>
				</div>
				<ol class="breadcrumb justify-content-center p-0 m-0">
				  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
				  <li class="breadcrumb-item active">Client Form</li>
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
                    <h3>Register As <span class="alternate">Client</span></h3>
                    <p>
                        Are you looking for skilled laborers for your projects? Register as a client on {{env('APP_NAME')}} and gain access to a network of verified professionals ready to assist you. Whether you need workers for construction, maintenance, or specialized tasks, we make hiring simple, secure, and efficient.
                    </p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form id="clientForm" action="{{ route('client_register.store') }}" method="POST" class="row">
            @csrf
            <div class="col-md-3">
                <input type="text" class="form-control main @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control main @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3">
                <input type="email" class="form-control main @error('cnic_no') is-invalid @enderror" name="email" id="email" placeholder="Email. (abc@gmail.com)" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
             <div class="col-md-3">
                <input type="number" class="form-control main @error('cnic_no') is-invalid @enderror" name="cnic_no" id="cnic_no" placeholder="CNIC No. (Without dashes)" value="{{ old('cnic_no') }}" required>
                @error('cnic_no')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <textarea name="address" id="address" class="form-control main @error('address') is-invalid @enderror" rows="4" placeholder="Your Address" required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-main-md">Register</button>
            </div>
        </form>
    </div>
</section>
@endsection
