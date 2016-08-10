	@extends('layouts.master')

@section('title')
	youTourn - Encourage Competition
@endsection

@section('css_links')
	<link rel="stylesheet" href="{{ URL::to('css/image-hover-effects.css') }}">
@endsection
		
@section('content')
	@include('partials.navbar')
	<div class = "container-fluid">
		<div class = "col-md-11 col-centered">
			<div class = "row content-box-black" style = "margin-top:100px;">
				<form action = "{{ route('tournament.pool') }}" method = "get">
					<div class = "col-md-2">
						<div class = "drop-down">
							<span style = "color:black; font-weight:bold;">Sort by:</span>
							<select name = "sortBy" class = "drop-button" style = "padding:10px;">
								<option value = "name">A to Z</option>
								<option value = "created_at">Date added</option>
							</select>
						</div>
					</div>

					<div class = "col-md-2">
						<div class = "drop-down">
							<span style = "color:black; font-weight:bold;">Filter:</span>
							<select name = "filter" class = "drop-button" style = "padding:10px;">
								<option value= "None">None</option>
								<option value = "Single Elimination">Single Elimination</option>
								<option value = "Double Elimination">Double Elimination</option>
								<option value = "Round Robin">Round Robin</option>
							</select>
						</div>
					</div>
					<button type="submit" class="btn btn-success" style = "float:right;margin-right:10px;margin-top:2px;">Go</button>
                	<input type="hidden" value="{{ Session::token() }}" name="_token">
				</form>

			</div>

			<div class = "row t-container content-box-scrollable-y" style = "margin-top:10px; max-height:650px;">
				@foreach($tournaments as $tournament)
					<div class = "col-md-4">
						<center>
							<div class = "tilt">
								<a href = "{{ route('tournament.page', ['tournament_id' => $tournament->id]) }}">
									@if (!Storage::disk('local')->has($tournament->name . '-' . $tournament->id . '.jpg'))
										<img src="{{ URL::to('images/default.png' )}}" height = "200" style="padding:10px;">
									@else
										<img src="{{ route('tournament.image', ['filename' => $tournament->name . '-' . $tournament->id . '.jpg']) }}" height = "200" style="padding:10px;">
									@endif
								</a>
							</div>
							<h3><b>{{ $tournament->name }}</b></h3>
							<p><b>{{ $tournament->type }}</b><br>
								<b>By:</b> {{ $tournament->user->username }}<br>
								<b>Created at:</b> {{ $tournament->created_at }}
							</p>
						</center>
							
					</div>
				@endforeach

			</div>
		</div>
	</div>
@endsection
