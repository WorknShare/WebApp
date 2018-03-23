<!DOCTYPE html>
<html class="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Work\'n Share')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Heebo:100%7COpen+Sans:300,400,400i,600,700,800">
    
    <link rel="stylesheet" href="{{ asset('landing/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/vendor/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('landing/vendor/bootsnav/css/bootsnav.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/vendor/alien-icon/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/vendor/switchery/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/vendor/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/vendor/swiper/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/alien.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/custom.css') }}">

    @yield('css')

    <!-- Favicon -->
	<link rel="icon" type="image/png" href="{{ asset('img/logo16.png') }}" sizes="16x16">
	<link rel="icon" type="image/png" href="{{ asset('img/logo32.png') }}" sizes="32x32">
	<link rel="icon" type="image/png" href="{{ asset('img/logo64.png') }}" sizes="64x64">
	<link rel="icon" type="image/png" href="{{ asset('img/logo128.png') }}" sizes="128x128">
	<link rel="icon" type="image/png" href="{{ asset('img/logo256.png') }}" sizes="256x256">

</head>
<body>

    @yield('navigation')

	@yield('content-wrapper')


	<script src="{{ asset('landing/vendor/jquery/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/bootsnav/js/bootsnav.js') }}"></script>
    <script src="{{ asset('landing/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/jquery.countTo/jquery.countTo.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/owl.carousel2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/jquery.appear/jquery.appear.js') }}"></script>
    <script src="{{ asset('landing/vendor/parallax.js/parallax.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/imagesloaded/imagesloaded.js') }}"></script>
    <script src="{{ asset('landing/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('landing/vendor/swiper/js/swiper.min.js') }}"></script>
    <script src="{{ asset('landing/js/alien.js') }}"></script>
	@yield('scripts')
</body>
</html>
