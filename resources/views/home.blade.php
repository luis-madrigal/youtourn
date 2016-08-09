@extends('layouts.master')

@section('title')
	youTourn - Encourage Competition
@endsection('title')

@section('css_links')
	<link rel="stylesheet" href="{{ URL::to('css/parrallax.css') }}">
@endsection
		
		
@section('content')
	@include('partials.navbar')
	<div
		class="parallax-image-wrapper parallax-image-wrapper-100"
		data-anchor-target="#banner1 + .gap"
		data-bottom-top="transform:translate3d(0px, 200%, 0px)"
		data-top-bottom="transform:translate3d(0px, 0%, 0px)">

		<div
			class="parallax-image parallax-image-100"
			style="background-image:url(images/ytbanner.jpg)"
			data-anchor-target="#banner1 + .gap"
			data-bottom-top="transform: translate3d(0px, -80%, 0px);"
			data-top-bottom="transform: translate3d(0px, 80%, 0px);"
		></div>
	</div>

	<div
		class="parallax-image-wrapper parallax-image-wrapper-100"
		data-anchor-target="#banner2 + .gap"
		data-bottom-top="transform:translate3d(0px, 200%, 0px)"
		data-top-bottom="transform:translate3d(0px, 0%, 0px)">

		<div
			class="parallax-image parallax-image-100"
			style="background-image:url(images/banner.jpg)"
			data-anchor-target="#banner2 + .gap"
			data-bottom-top="transform: translate3d(0px, -80%, 0px);"
			data-top-bottom="transform: translate3d(0px, 80%, 0px);"
		></div>
	</div>

	<div
		class="parallax-image-wrapper parallax-image-wrapper-50"
		data-anchor-target="#banner3 + .gap"
		data-bottom-top="transform:translate3d(0px, 300%, 0px)"
		data-top-bottom="transform:translate3d(0px, 0%, 0px)">

		<div
			class="parallax-image parallax-image-50"
			style="background-image:url(images/ytbantest.jpg)"
			data-anchor-target="#banner3 + .gap"
			data-bottom-top="transform: translate3d(0px, -20%, 0px);"
			data-top-bottom="transform: translate3d(0px, 80%, 0px);"
		></div>
	</div>

	<div id="skrollr-body">
		<div class="header" id="banner1">
		</div>

		<div class="gap gap-100" style="background-image:url({{ URL::to('images/ytbanner.jpg') }});">
			<div class = "container-fluid">
				<div class = "row">
					<div id = "img_caption">
						<div id = "caption_text">
			        		<h1 style = "font-size:52px;font-weight:bold;">Encourage competition</h1>
			        		<p style = "font-size:24px">Create brackets. Manage them online.</p>
			        	</div>
			        	@if(Auth::check())
			        		<p class="text-center"><a href="{{ route('create.tournament') }}" class="btn btn-primary btn-lg">Get Started</a></p>
			        	@else
			        		<p class="text-center"><a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started</a></p>
			        	@endif
		    		</div>
	    		</div>
			</div>
		</div>

		<div class="content" id="banner2">
			<div class = "row" id = "info1">
				<div class = "col-md-6">
					<img style = "padding:40px 40px" src = "{{ URL::to('images/laptop.png') }}" class = "img-responsive">
				</div>
				<div class = "col-md-6" id = "info1_text">
					<h1 style = "font-size:52px;font-weight:bold;">Easy to use</h1>
					<p style = "font-size:24px">Access, create, and publish your brackets online.</p>
				</div>
				
    		</div>
		</div>

		<div class="gap gap-100" style="background-image:url({{ URL::to('images/banner.jpg') }});"></div>

		<div class="content" id="banner3">
			<div class = "container-fluid">
				<div class = "row" id = "info2">
					<div class = "col-md-6" id = "info2_text">
						<h1 style = "font-size:52px;font-weight:bold;">Organize your tournament</h1>
						<p style = "font-size:24px">Choose the type of tournament: Single Elimination, Double Elimination, or Round Robin.</p>
					</div>
					<div class = "col-md-6">
						<img style = "padding:40px 40px;" src = "{{ URL::to('images/american-football.png') }}" class = "img-responsive">
					</div>
	    		</div>
			</div>
		</div>
		<div class="gap gap-50" style="background-image:url({{ URL::to('images/ytbantest.jpg') }});"></div>

		<div class = "container-fluid" style = "background-color:white">
			<div class = "row">
				<div class = "col-md-12">
					<footer>
						<p style = "padding-top:20px; text-align:center;font-weight:bold">Copyright 2016, youTourn. All rights reserved - Authors <a href = "https://web.facebook.com/Fresh.Pear">Maynard Si</a>,
								<a href = "https://web.facebook.com/jj.trin.69">Jj Trinidad</a>, and
								<a href = "https://web.facebook.com/luis.madrigal.378">Luis Madrigal</a>.
						</p>
						
						<div style = "text-align:center;">
							<span class = "centered-content">This website is powered by:</span>
							<a class = "centered-content" href = "https://laravel.com/">
								<img src = "{{ URL::to('images/laravel.png') }}">
							</a>
							<a class = "centered-content" href = "http://getbootstrap.com/">
								<img src = "{{ URL::to('images/bootstrap.png') }}">
							</a>
						</div>
					</footer>
				</div>
			</div>
		</div>

	</div>
@endsection
		
@section('js_links')
	<script src="{{ URL::to('js/skrollr.min.js') }}"></script>
	<script type="text/javascript">
	skrollr.init({
		smoothScrolling: false,
		mobileDeceleration: 0.004
	});
	</script>
@endsection