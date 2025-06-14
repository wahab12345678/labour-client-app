<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Eventre - Event &amp; Conference Html5 Template</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Event and Conference Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Eventre HTML Template v1.0">

  <!-- theme meta -->
  <meta name="theme-name" content="eventre" />

  <!-- PLUGINS CSS STYLE -->
  <!-- Bootstrap -->
  <link href="{{ asset('plugins/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Font Awesome -->
  <link href="{{ asset('plugins/font-awsome/css/font-awesome.min.css')}}" rel="stylesheet">
  <!-- Magnific Popup -->
  <link href="{{ asset('plugins/magnific-popup/magnific-popup.css')}}" rel="stylesheet">
  <!-- Slick Carousel -->
  <link href="{{ asset('plugins/slick/slick.css')}}" rel="stylesheet">
  <link href="{{ asset('plugins/slick/slick-theme.css')}}" rel="stylesheet">
  <!-- CUSTOM CSS -->
  <link href="{{ asset('css/style.css')}}" rel="stylesheet">

  <!-- FAVICON -->
  <link href="{{ asset('images/favicon.png')}}" rel="shortcut icon">
    @yield('header')
</head>

<body class="body-wrapper">


<!--========================================
=            Navigation Section            =
=========================================-->
<nav class="navbar main-nav border-less fixed-top navbar-expand-lg p-0">
  <div class="container-fluid p-0">
    <!-- logo -->
    <a class="navbar-brand" href="{{ url('/') }}">
      {{-- <img src="{{ asset('images/logo.png')}}" alt="logo"> --}}
      <img style=" max-width: 100px;height: auto;     display: block;" src="{{ asset('images/final_logo.png')}}" >

    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Home
                <span>/</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/about') }}">About Us
            <span>/</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/contact') }}">Contact Us
              <span>/</span>
            </a>
          </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#!" data-toggle="dropdown">Register <i class="fa fa-angle-down"></i><span>/</span></a>
          <!-- Dropdown list -->
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ url('/client_register') }}">Client</a></li>
            {{-- <li><a class="dropdown-item" href="single-speaker.html">Labour</a></li>
            <li><a class="dropdown-item" href="gallery.html">Contractor</a></li> --}}
            {{-- <li><a class="dropdown-item" href="gallery-two.html">Gallery-02</a></li>
            <li><a class="dropdown-item" href="testimonial.html">Testimonial</a></li>
            <li><a class="dropdown-item" href="pricing.html">Pricing</a></li>
            <li><a class="dropdown-item" href="FAQ.html">FAQ</a></li>
            <li><a class="dropdown-item" href="404.html">404</a></li> --}}

            {{-- <li class="dropdown dropdown-submenu dropright">
              <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0301" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>

              <ul class="dropdown-menu" aria-labelledby="dropdown0301">
                <li><a class="dropdown-item" href="index.html">Submenu 01</a></li>
                <li><a class="dropdown-item" href="index.html">Submenu 02</a></li>
              </ul>
            </li> --}}
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('/services')}}">Services</a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" href="sponsors.html">Sponsors<span>/</span></a>
        </li> --}}
        {{-- <li class="nav-item dropdown">
          <a class="nav-link" href="#!" data-toggle="dropdown">News <i class="fa fa-angle-down"></i><span>/</span>
          </a>
          <!-- Dropdown list -->
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="news.html">News without sidebar</a></li>
            <li><a class="dropdown-item" href="news-right-sidebar.html">News with right sidebar</a></li>
            <li><a class="dropdown-item" href="news-left-sidebar.html">News with left sidebar</a></li>
            <li><a class="dropdown-item" href="news-single.html">News Single</a></li>

            <li class="dropdown dropdown-submenu dropleft">
              <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0501" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>

              <ul class="dropdown-menu" aria-labelledby="dropdown0501">
                <li><a class="dropdown-item" href="index.html">Submenu 01</a></li>
                <li><a class="dropdown-item" href="index.html">Submenu 02</a></li>
              </ul>
            </li>
          </ul>
        </li> --}}
        {{-- <li class="nav-item">
          <a class="nav-link" href="contact.html">Contact</a>
        </li> --}}
      </ul>
      <a href="{{ url('/contact') }}" class="ticket">
        <img src="{{ asset('images/icon/ticket.png')}}" alt="ticket">
        <span>Book Now</span>
      </a>
    </div>
  </div>
</nav>

<!--====  End of Navigation Section  ====-->
