@extends('layouts.master')

@section('title')
	youTourn - Log In or Sign Up
@endsection

@section('css_links')
	<style type="text/css">
		.form-control { 
			margin-bottom: 1px; 
		}
		.row {
	    margin-right: -15px;
	    margin-left: -7px;
	}
	body{
			background-repeat:no-repeat;
			background-attachment:fixed;
			background-image:url({{ URL::asset('images/bracketimage.PNG')}})
	}
	</style>
@endsection	

@section('content')
	@include('partials.navbar')
	<div class="container-fluid" style="margin-top:4.5%;">
		<div class="col-md-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-8 well well-sm">
					<legend><a href="#"><i class="glyphicon glyphicon-globe"></i></a> Sign In!</legend>
					@include('partials.message_block')
					<form action="{{ route('signin') }}" method = "post" class="form">
						<div class="row">
							<div class="col-xs-12 col-md-12 form-group {{ $errors->has('username') ? 'has-error':'' }}">
								<input class="form-control " name="username" id = "username" placeholder="Username" type="text" value="{{ Request::old('username') }}" required autofocus />
							</div>
						</div>
						<div class="row">
							<div class = "col-xs-8 col-md-8 form-group {{ $errors->has('password') ? 'has-error':'' }}">
								<input class="form-control" id = "password" name="password" placeholder="Password" type="password" />
							</div>
							<div class = "col-xs-4 col-md-4">
								<button class="btn btn-md btn-primary btn-block" type="submit">Log in</button>
							</div>
							<input type = "hidden" name = "_token" value = "{{ Session::token() }}">
						</div>
						<div class = "row">
							<div class = "col-xs-3">
								<div class="checkbox">
									<label><input type="checkbox" name = "remember" value="remember">Remember me</label>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-8 well well-sm">
					<legend><a href="#"><i class="glyphicon glyphicon-globe"></i></a> Sign up!</legend>
					<form action="{{ route('signup') }}" method="post" class="form" role="form" id = "forms">
						<div class="row">
							<div class="col-xs-6 col-md-6 form-group">
								<input class="form-control" name="firstname" placeholder="First Name" type="text" value = "{{ Request::old('firstname') }}" required autofocus />
							</div>
							<div class="col-xs-6 col-md-6 form-group">
								<input class="form-control" name="lastname" placeholder="Last Name" type="text" value = "{{ Request::old('lastname') }}" required />
							</div>
						</div>
						<div class = "form-group {{ $errors->has('email') ? 'has-error':'' }}">
							<input class="form-control" name="email" placeholder="Your Email" type="email" value = "{{ Request::old('email') }}" required />
						</div>
						<div class = "form-group {{ $errors->has('username') ? 'has-error':'' }}">
							<input class="form-control" name="username" placeholder="Username" type="text" value = "{{ Request::old('username2') }}" required />
						</div>
						<div class = "form-group {{ $errors->has('password') ? 'has-error':'' }}">
							<input class="form-control" name="password" placeholder="Password" type="password" value="{{ Request::old('password2') }}" required />
						</div>
						<label for="">Birth Date</label>
						<div class="row form-group">
							<div class="col-xs-6 col-md-6 row">
								<input type="text" id="datepicker" name = "birthdate" required readonly>
							</div>
						</div>
						<div class = "form-group {{ $errors->has('password2') ? 'has-error':'' }}">
							<label class="radio-inline">
								<input type="radio" name="sex" id="inlineCheckbox1" value="male" required />
								Male
							</label>
							<label class="radio-inline">
								<input type="radio" name="sex" id="inlineCheckbox2" value="female" required/>
								Female
							</label>
						</div>
						<br />
						<br />
						<button class="btn btn-lg btn-primary btn-block" type="submit">	Register</button>                 
						<input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
					</form>
				</div>
			</div>

		</div>
	</div>
@endsection

@section('js_links')
	<script src = "{{ URL::to('js/calendar.js') }}"></script>
	<script type="text/javascript">	
		$( function() {
			$( "#datepicker" ).datepicker({
				maxDate: "-1D",
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>
@endsection