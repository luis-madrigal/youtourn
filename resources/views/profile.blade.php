@extends('layouts.master')

@section('title')
	{{ $user->first_name }} {{ $user->last_name }}
@endsection

@section('css_links')
	<link rel="stylesheet" href="{{ URL::to('css/image-hover-effects.css') }}">
@endsection
		
@section('content')
	@include('partials.navbar')
	<div class="container-fluid">
		<div class = "row col-centered">
			<div class = "col-md-3 content-box-blue content-pane">
				@if(Auth::user() == $user)
					<a class = "upload-pic" type = "button" role = "button" data-toggle="modal" data-target="#upload-modal">
					@if (!Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
						<img class = "bordered-content center-block profile-pic" src="{{ URL::to('images/person.jpg') }}" height = "250">
					@else
						<img class = "bordered-content center-block profile-pic" src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" height = "250">
					@endif
					</a>
					<div class="center">
						<button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block" style = "margin-top: 5px;">
							<i class="glyphicon glyphicon-pencil"></i> Edit
						</button>
					</div>
				@else
					@if (!Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
						<img class = "bordered-content center-block profile-pic" src="{{ URL::to('images/person.jpg') }}" height = "250">
					@else
						<img class = "bordered-content center-block profile-pic" src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" height = "250">
					@endif
				@endif
				<div id="upload-modal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Upload your new profile picture</h4>
							</div>
							<div class="modal-body">
								<form action="{{ route('change.profpic') }}" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label for="exampleInputFile">Upload a Profile Picture</label>
										<input type="file" id="exampleInputFile" name = "image">
										<p class="help-block">Image not be larger than 550 x 400 px.</p>
									</div>
									<div class = "form-group">
										<button type="submit" class="btn btn-primary">Upload</button>
                						<input type="hidden" value="{{ Session::token() }}" name="_token">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<div id="delete-modal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Warning!</h4>
							</div>
							<div class="modal-body">
								<h3>These tournaments have been deleted!</h3>
								<ul id = "tournaments-deleted">
								</ul>
							</div>
							<div class="modal-footer">
								<button id = "undo-button" type="button" class="btn btn-primary" data-dismiss="modal">
									<i class = "glyphicon glyphicon-share-alt"></i>
									Undo
								</button>
								<button id = "continue-button" type="button" class="btn btn-success" data-dismiss="modal">Continue</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
								<h3 class="modal-title" id="lineModalLabel">Edit Profile</h3>
							</div>
							@include('partials/message_block')
							<form action="{{ route('user.edit') }}" method="post">
								<div class="modal-body">
										<div class="form-group">
											<label for="firstname">First Name</label>
											<input type="text" class="form-control" id="firstname" placeholder="Enter First Name" name = "firstname" value = "{{ $user->first_name }}">
										</div>
										<div class="form-group">
											<label for="lastname">Last Name</label>
											<input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" name = "lastname" value = "{{ $user->last_name }}">
										</div>
										<div class="form-group">
											<label for="inputEmail">Email Address</label>
											<input type="email" class="form-control" id="inputEmail" placeholder="Enter email" name = "email" value = "{{ $user->email }}">
										</div>
										<div>
											<label for="description">Description</label>
											<textarea class="form-control" rows="3" id = "description" name = "description">{{ $user->description }}</textarea>
										</div>
										
									

								</div>
								<div class="modal-footer">
									<div class="btn-group btn-group-justified" role="group" aria-label="group button">
										<div class="btn-group" role="group">
											<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
										</div>
										<div class="btn-group btn-delete hidden" role="group">
											<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
										</div>
										<div class="btn-group form-group" role="group">
											<button type="submit" id="saveImage" class="btn btn-primary btn-hover-green" data-action="save" role="button">Save</button>
                							<input type="hidden" value="{{ Session::token() }}" name="_token">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<p class="info-box"> <b>Username:</b> {{ $user->username }}<br>
					<b>Fullname:</b> {{ $user->first_name }} {{ $user->last_name }} <br>
					<b>Birthdate:</b> {{ $user->birthday }} <br>
					<b>Description:</b> {{ $user->description }}<br>
				</p>

			</div>

			<div class= "col-md-8" style = "margin-top:100px; margin-left:30px;">
				
				<ul class="nav nav-tabs">
					<li id = "active" class="active"><a data-toggle="tab" href="#created" class = "tab-style">Tournaments Created</a></li>
					<li><a data-toggle="tab" href="#followed" class = "tab-style">Tournaments Followed</a></li>

					<button id = "delete-tournaments" type="button" class="btn btn-danger hidden" style = "float:right;">
					<i class="glyphicon glyphicon-save"></i> 
					Delete Tournaments
				</button>
				</ul>
				
				

				<div class= "tab-content content-box-scrollable-y"  style = "height:755px;">
					<div id = "created" class = "container-fluid t-container tab-pane fade in active">
						@foreach($tournamentsCreated as $tournament)
							<div class = "row bordered-content" data-tourn-id = '{{ $tournament->id }}' style = "margin-left:10px;">
								<div class = "col-lg-1 grow">
									<a href = "{{ route('tournament.page', ['tournament_id' => $tournament->id]) }}">
										@if (!Storage::disk('local')->has($tournament->name . '-' . $tournament->id . '.jpg'))
											<img src="{{ URL::to('images/default.png' )}}">
										@else
											<img src="{{ route('tournament.image', ['filename' => $tournament->name . '-' . $tournament->id . '.jpg']) }}">
										@endif
									</a>
								</div>
								<div class = "col-lg-8" style = "margin-left:40px;">
									<p style = "font-size:16px;">
										<b>Name:</b> {{ $tournament->name }}<br>
										<b>Type:</b> {{ $tournament->type }}<br>
										<b>Description:</b> {{ $tournament->description }}
									</p>
								</div>
								@if(Auth::user() == $tournament->user)
									<div style = "float:right">
										<a role = "button" class = "delete-button" data-delete = "0"><span class = "glyphicon glyphicon-trash"></span></a>
									</div>
								@endif
							</div>
						@endforeach
					</div>
					<div id = "followed" class = "container-fluid t-container tab-pane">
						@foreach($tournamentsFollowed as $tournament)
							<div class = "row bordered-content" data-tourn-id = '{{ $tournament->id }}' style = "margin-left:10px;">
								<div class = "col-lg-1 grow">
									<a href = "{{ route('tournament.page', ['tournament_id' => $tournament->id]) }}">
										@if (!Storage::disk('local')->has($tournament->name . '-' . $tournament->id . '.jpg'))
											<img src="{{ URL::to('images/default.png' )}}">
										@else
											<img src="{{ route('tournament.image', ['filename' => $tournament->name . '-' . $tournament->id . '.jpg']) }}">
										@endif
									</a>
								</div>
								<div class = "col-lg-8" style = "margin-left:40px;">
									<p style = "font-size:16px;">
										<b>Name:</b> {{ $tournament->name }}<br>
										<b>Type:</b> {{ $tournament->type }}<br>
										<b>Description:</b> {{ $tournament->description }}
									</p>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			
			
		</div>
	</div>

@endsection
	
@section('js_links')
	<script type="text/javascript">
		var token = '{{ Session::token() }}'
		var urlDelete = '{{ route("delete.tournament") }}';
		var urlUndo = '{{ route("undo.delete.tournament") }}';
		@if(count($errors) > 0)
			$(window).load(function(){
		        $('#squarespaceModal').modal('show');
		    });
		@endif
	</script>
	<script src = "{{ URL::to('js/deleting-tournaments.js') }}"></script>
@endsection	
