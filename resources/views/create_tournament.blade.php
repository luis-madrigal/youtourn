@extends('layouts.master')

@section('title')
Create your own tournament!
@endsection
<!-- saved from url=(0054)http://bootsnipp-env.elasticbeanstalk.com/iframe/Qb83E -->

@section('css_links')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="robots" content="noindex">
<link rel="stylesheet" href="{{ URL::to('css/create_sidebar.css') }}">
<link rel="stylesheet" href="{{ URL::to('css/jquery.bracket.min.css') }}">
<link rel="stylesheet" href="{{ URL::to('css/jquery.group.min.css') }}">

@endsection

@section('content')
<div id="wrapper" class="">
	<div class="overlay" style="display: none;"></div>

	<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
		<form style = "color:white; font-size:32px;">
			<span class = "boxless-input">
				"<span id = "name" contenteditable = "true" onkeypress="return (this.innerText.length <= 20)";>My Tournament</span>"
			</span>
		</form>

		<form style = "color:black; font-size:16px;">
			<div class="form-group">
				<label for="comment" style="color:white">Description:</label><br>
				<textarea rows="5" cols="40" id="description" style = "border-radius: 10px; resize: none;"></textarea>
			</div>
		</form>

		<div class = "row">
			<form class = "drop-down">
				<span style = "margin-left:18px;color:white;font-weight:bold">Tournament Type:</span>
				<select id = "choose" class = "drop-button" style = "padding:10px;">
					<option value = "sede">Elimination</option>
					<option value = "rr">Round Robin</option>
				</select>
			</form>
		</div>

		<div class = "row">
			<form class = "drop-down">
				<span style = "margin-left:18px;color:white;font-weight:bold">Privacy:</span>
				<select id = "privacy" class = "drop-button" style = "padding:10px;">
					<option value = "Public">Public</option>
					<option value = "Private">Private</option>
				</select>
			</form>
		</div>

		<div class="row">
			<div class="col-md-12">
				<span class="pull-left">
					<button id = "save-button" type="button" class="btn btn-success">
						<i class="glyphicon glyphicon-floppy-disk"></i> 
						Save
					</button>
				</span>
			</div>
		</div>
	</nav>

	<div id="page-content-wrapper">
		<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
			<span class="hamb-top"></span>
			<span class="hamb-middle"></span>
			<span class="hamb-bottom"></span>
		</button>
		<div class="container">
			<div class = "col-md-12 content-box-black" style = "margin-top:-50px; margin-left:0px; max-height: 600px;
			width: 100%;">
			<div class ="col-sm-2">
				<a href="{{ route('home') }}">
					<img src="{{ URL::to('images/ytbiglogo.png') }}" class = "img-responsive" alt="youtourn logo" >
				</a>
			</div>
			<div class ="col-sm-3">
				<h2>Edit bracket</h2>
			</div>
			
		</div>

		<div class = "col-md-12 content-box-black" style = "background-color:#A9A9A9; max-height: 550px; overflow-y:scroll; width: 100%;">
			<div class = "container-fluid">
				<div class = "row">
					<div class = "col-md-8" style = "padding-bottom:20px">
						<div id = "tournament">
							<div class="elims">
							</div>
						</div>
						<div id = "robin">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div id="modal_success" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">You have successfully created your own tournament!</h4>
			</div>
			<div class="modal-body">
				<p>You can now view it <a id = "linkto">here</a>. Or you can create more amazing tournaments!</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

</div>
@endsection

@section('js_links')
<script type="text/javascript">
	var token = "{{ Session::token() }}";
	var url = "{{ route('save.tournament') }}";
</script>

<script src = "{{ URL::to('js/create_sidebar.js') }}"></script>
<script src = "{{ URL::to('js/underscore-min.js') }}"></script>

<!-- Courtesy of: https://github.com/baconjs/bacon.js -->
<script src = "{{ URL::to('js/Bacon-1ab32ffb.min.js') }}"></script>
<!-- Courtesy of: https://lodash.com/ -->
<script src = "{{ URL::to('js/lodash-2.2.1.min.js') }}"></script>
<!-- Courtesy of: http://handlebarsjs.com/ -->
<script src = "{{ URL::to('js/handlebars.1.0.0.js') }}"></script>
<!-- Courtesy of: http://www.aropupu.fi/bracket/ -->
<script src = "{{ URL::to('js/jquery.bracket.min.js') }}"></script>
<script src = "{{ URL::to('js/jquery.group.min.js') }}"></script>

<script src = "{{ URL::to('js/elimination.js') }}"></script>
@endsection
