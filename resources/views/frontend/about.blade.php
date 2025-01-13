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
					<h3>About Us</h3>
				</div>
				<ol class="breadcrumb justify-content-center p-0 m-0">
				  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
				  <li class="breadcrumb-item active">About US</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<!--====  End of Page Title  ====-->


<!--===========================
=            About            =
============================-->

<section class="section about">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6 align-self-center">
				<div class="image-block bg-about">
					<img class="img-fluid" src="images/speakers/featured-speaker.jpg" alt="">
				</div>
			</div>
			<div class="col-lg-8 col-md-6 align-self-center">
				<div class="content-block">
					<h2>About The <span class="alternate">{{env('APP_NAME')}}</span></h2>
					<div class="description-one">
						<p>
							Welcome to {{env('APP_NAME')}}, your trusted platform for connecting skilled laborers with clients who need reliable services. Our mission is to simplify the process of hiring labor by providing a seamless and efficient booking system that benefits both workers and clients.
						</p>
					</div>
                    <h2>Who We Are</h2>
					<div class="description-two">
						<p>
                            At {{env('APP_NAME')}}, we understand the challenges faced by both workers looking for job opportunities and clients searching for skilled labor. Our platform bridges this gap by offering a transparent, secure, and user-friendly system that ensures fair and hassle-free hiring.
                        </p>
					</div>
                    <h2>Our Mission</h2>
					<div class="description-two">
						<p>
                            We aim to empower skilled workers by giving them access to more job opportunities while ensuring that clients receive high-quality, professional services. By leveraging technology, we streamline the hiring process, making it quicker, safer, and more efficient for everyone involved.
                        </p>
					</div>
                    <h2>What We Offer</h2>
					<div class="description-three">
						<p>
                            <b>For Clients:</b> Easily find and book verified laborers for various tasks, from construction and home maintenance to specialized services.
                        </p>
                        <p>
                            <b>For Laborers:</b> Gain access to a wide range of job opportunities and get paid fairly for your work.
                        </p>
                        <p>
                            <b>Secure & Reliable:</b> We ensure all transactions are secure, and our verification process guarantees trustworthy connections.
                        </p>
                    </div><br>
                    <h2>Why Choose Us?</h2>
					<div class="description-three">
						<p>
                            <b>Easy Booking Process -</b> Find and hire skilled labor in just a few clicks.
                        </p>
                        <p>
                            <b>Verified Workers -</b> We ensure quality and reliability through our screening process.
                        </p>
                        <p>
                            <b>Fair Pricing -</b> Transparent pricing that benefits both clients and workers.
                        </p>
                        <p>
                            <b>Customer Support -</b> Dedicated assistance to help you every step of the way.
                        </p><br/>
                        <p>
                            Join {{env('APP_NAME')}} today and experience a smarter way to connect with skilled laborers or find work opportunities!
                        </p><br/>
                    </div>
					<ul class="list-inline">
						<li class="list-inline-item">
							<a href="{{url('contact')}}" class="btn btn-main-md">Contact Us</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<!--====  End of About  ====-->
@endsection
