@extends('layouts.master')

@section('title')
	{{ $tournament->name }} - youTourn
@endsection

@section('css_links')
	<link rel="stylesheet" href="{{ URL::to('css/jquery.bracket.min.css') }}">
	<link rel="stylesheet" href="{{ URL::to('css/jquery.group.min.css') }}">
@endsection
	
@section('content')
	@include('partials.navbar')
	<div class="container-fluid">
		<div class = "col-md-12 col-centered">
			<div class = "col-md-4 content-box-blue content-pane">
				
				<center>
					@if (!Storage::disk('local')->has($tournament->name . '-' . $tournament->id . '.jpg'))
						<img class = "bordered-content img-circle" src="{{ URL::to('images/default.png') }}" height = "250">
					@else
						<img class = "bordered-content img-circle" src="{{ route('tournament.image', ['filename' => $tournament->name . '-' . $tournament->id . '.jpg']) }}" height = "250">
					@endif
				</center>
				<p class = "info-box"> <b>Tournament Name:</b> {{ $tournament->name }}<br>
					<b>Managed By:</b> {{ $tournament->user->username }}<br>
					<b>Type:</b> {{ $tournament->type }}<br>
					<b>Description:</b> {{ $tournament->description }}<br>
				</p>

			</div>

			<div class= "col-md-7 content-box-blue" style = "margin-top:100px; margin-left:30px;">
		
				<h1 style = "color:black; float:left;">
					{{ $tournament->name }}
				</h1>

				@if(Auth::check())
					@if($message == 'Creator')
						@if($tournament->winner == NULL)
							<button id = "edit-button" type="button" class="btn btn-primary" style = "float:right; margin-top: 17px;">
								<i class="glyphicon glyphicon-pencil"></i> 
								Edit
							</button>
							<button id = "done-button" type="button" class="btn btn-success" style = "float:right; margin-top: 17px;margin-right:10px">
								<i class="glyphicon glyphicon-thumbs-up"></i> 
								Declare as Done
							</button>
							<button id = "save-button" type="button" class="btn btn-success hidden" style = "float:right; margin-top: 17px;">
								<i class="glyphicon glyphicon-floppy-disk"></i> 
								Save
							</button>
						@endif
					@else
						@if($following)
							<button id = "follow-button" type="button" class="btn btn-primary" style = "float:right; margin-top: 17px;">
								<i class="glyphicon glyphicon-thumbs-down"></i> 
								Unfollow
							</button>
						@else
							<button id = "follow-button" type="button" class="btn btn-primary" style = "float:right; margin-top: 17px;">
								<i class="glyphicon glyphicon-thumbs-up"></i> 
								Follow
							</button>
						@endif
					@endif
				@endif
				
			</div>

			<div class= "col-md-7 content-box-scrollable-y" style = "margin-top:10px; margin-left:30px; height:722px;">
				<div id = "view">
				</div>
				<div id = "editor">
				</div>
			</div>

			<div class = "col-md-1">
			</div>
		</div>

		<div id="notif-modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id = "modal-title-text">You followed a tournament!</h4>
					</div>
					<div class="modal-body">
						<p id = "modal-text"></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div id="done-modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id = "done-modal-title-text"></h4>
					</div>
					<div class="modal-body">
						<p id = "done-modal-text"></p>
					</div>
					<div class="modal-footer">
						<button id = "done-modal-yes" type="button" class="btn btn-primary hidden" data-dismiss="modal">Yes</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
		
@section('js_links')
	<script type="text/javascript">
		var token = '{{ Session::token() }}';
		var tournamentType = {!! json_encode($tournament->type) !!};
		var data = {!! json_encode($tournament->tourn_data) !!};
		var tournamentData;
		var tournamentId = {!! $tournament->id !!};
		var urlNotif = '{{ route("follow.notif") }}';
		var urlEdit = '{{ route("edit.tournament") }}';
		var urlWin = '{{ route("set.winner.tournament") }}';
	</script>
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

	<script src = "{{ URL::to('js/show-tournament.js') }}"></script>
	<script src = "{{ URL::to('js/send-follow-notif.js') }}"></script>
@endsection
