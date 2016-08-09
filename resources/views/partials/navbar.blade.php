<nav class="navbar navbar-inverse navbar-fixed-top">
  	<div class="container-fluid">
    	<div class="navbar-header">
      		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	      	</button>
	      	<a class = "logo" href = "/">
      			<img src = "{{ URL::to('images/ytsmalllogo2.png') }}" class = "img-responsive">
      		</a>
    	</div>
    	<div class="collapse navbar-collapse" id="myNavbar">
	    	<ul class="nav navbar-nav">
		      	<li><a href="{{ route('create.tournament') }}">Create</a></li>
		      	<li><a href="{{ route('tournament.pool') }}">Tournaments</a></li> 
		      	<li>
              <form action = "{{ route('search.autocomplete') }}" method = "get">
                <input id = "search-bar" type="text" class="search" placeholder="  Search..">
                <i class="glyphicon glyphicon-search form-control-feedback" style = "margin-top:9px;"></i>
              </form>
		      	</li>
	    	</ul>
	    	<ul class="nav navbar-nav navbar-right">
		    	
		    	@if(!Auth::check())
  				<li id = "user">
  					<a href="{{ route('register') }}" id = "signup" role="button">
  						<span class="glyphicon glyphicon-user"></span> Sign Up
  					</a>
  				</li>
  				@else

            <li id = "notifications">
              <div class="dropdown" style="padding:10px;">
                <button class="btn btn-notifs dropdown-toggle" id = "notif-button" type="button" data-toggle="dropdown">
                <span class="badge" id = "notif-count"></span> <span class="glyphicon glyphicon-chevron-down"></span></button>
                <ul class="dropdown-menu" id = "notif-container">

                </ul>
              </div>
            </li>
    				<li id = "user">
    					<a href="{{ route('user.page', ['user_id' => Auth::user()->id]) }}" id = "signup" role="button">
                @if (!Storage::disk('local')->has(Auth::user()->first_name . '-' . Auth::user()->id . '.jpg'))
                  <img src="{{ URL::to('images/person.jpg') }}" height = "25" width = "25">
                @else
                  <img src="{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}" height = "25" width = "25"> 
                @endif
                {{ Auth::user()->username }} 
    					</a>
    				</li>
            <li id = "logout_user">
              <a href="{{ route('logout') }}" id = "signup" role="button">
                <span class="glyphicon glyphicon-logout"></span>Logout
              </a>
            </li>
  				@endif

			</ul>
		</div>

 	</div>
</nav>