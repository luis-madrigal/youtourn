<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>youTourn - Encourage Competition.</title>

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/jquery.bracket.min.css">
		<link rel="stylesheet" href="css/jquery.group.min.css">
		<link rel="icon" href="images/ytsmalllogo.ico">
	</head>

	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  	<div class="container-fluid">
		    	<div class="navbar-header">
		    		<a href = "index.html">
		      			<img src = "images/ytsmalllogo2.png" class = "img-responsive">
		      		</a>
		    	</div>
		    	<ul class="nav navbar-nav">
			      	<li><a href="create_tournament.html">Create</a></li>
			      	<li><a href="tournament_pool.html">Tournaments</a></li> 
			      	<li>
			      		<input type="text" class="search" placeholder="Search..">
			      	</li>
		    	</ul>
		    	<ul class="nav navbar-nav navbar-right">
      				<li id = "user"><a href="#" id = "signup" role="button" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    			</ul>
		 	</div>
		</nav>

		<div class="container-fluid">
			<div class = "row">
				<div class = "col-lg-4 content-box-blue" style="margin-top:100px; margin-left:20px; ">
					<center><img class = "bordered-content"src="images/dlo.jpg" height = "250">
					</center>
					<p style="color:black;font-size:24px;padding:20px"> <b>Tournament Name:</b> Proball<br>
						<b>Managed By:</b> 420blazeit <br>
						<b>Type:</b> Single Elimination <br>
						<b>Description:</b> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br>
					</p>

				</div>

				<div class= "col-lg-7 content-box-blue" style = "margin-top:100px; margin-left:30px;">
			
					<h1 style = "color:black; float:left;">
						Proball
					</h1>

					<button id = "join-button" type="button" class="btn btn-primary" style = "float:right; margin-top: 17px;">
						<i class="glyphicon glyphicon-envelope"></i> 
						Join
					</button>
				</div>

				<div class= "col-lg-7 content-box-scrollable-y" style = "margin-top:10px; margin-left:30px; max-height:675px;">
					<div id = "view">
					</div>
				</div>
			</div>
		</div>

		<script src = "js/jquery.min.js"></script>
		<script src = "js/underscore-min.js"></script>
		<!-- Courtesy of: https://github.com/baconjs/bacon.js -->
		<script src = "js/Bacon-1ab32ffb.min.js"></script>
		<!-- Courtesy of: https://lodash.com/ -->
		<script src = "js/lodash-2.2.1.min.js"></script>
		<!-- Courtesy of: http://handlebarsjs.com/ -->
		<script src = "js/handlebars.1.0.0.js"></script>

		<!-- Courtesy of: http://www.aropupu.fi/bracket/ -->
		<script src = "js/jquery.group.min.js"></script>
		
		<script src = "js/bootstrap.min.js"></script>
		<script src = "js/round-robin-sample.js"></script>
	</body>

</html>