<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Watch This Shit</title>

	<?php include '../resources/externalscripts.php'; ?>

	<!-- Dropdown Stylesheet -->
	<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
</head>

<body>
	<?php include '../resources/header.php'; ?>

	<?php
	if (!isset($_SESSION['login_user'])) {
		header("Location: login.php");
	}
	
	if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
		$usersearchentry = $_POST[ 'active-search' ];
		
		$htmlfriendly = rawurlencode($usersearchentry);
	
		$moviedata = file_get_contents('https://api.themoviedb.org/3/search/movie?api_key=6e5a5397142e1ba939389bc283a22d54&language=en-US&query=' . $htmlfriendly . '&page=1&include_adult=false');
	}
	
	
	
	?>

	<!-- Introductory Paragraph -->
	<section class="introductory-centered introductory">
		<h1 class="col-xs-10 other-header-centered col-centered">There are way too many good movies out there</h1>
		<p class="col-xs-10 subtitle-responsive-text col-centered">Your friends recommend you movies, you tell them you'd catch it when you get the free time. But then that free time comes and you simply have no idea what movie to watch.</p>
		<p class="col-xs-10 subtitle-responsive-text col-centered" style="padding-top: 16px;">Add that movie to WTS now while it is fresh in your mind. Then when the time comes, clear it!</p>
	</section>

	<!-- Adding movies -->
	<div class="row col-xs-10 searchbar-centered">
		<select id="editable-select" class="form-control form-control-lg searchbar-child-centered" placeholder="Start typing to search for a movie" name="active-search" method="post" data-filter="false" data-effects="slide">
		</select>
		
		<p><?php if (isset($htmlfriendly)) {echo $htmlfriendly;} ?></p>
	</div>

	<!-- Displaying results -->
	<div class="col-xs-10 list-centered">
		<div class="list-group">
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<div class="mb-1">
						<h5>Mad Max: Fury Road</h5>
						<p class="mb-1">Mad Max cray</p>
						<small>Starring: </small>
					</div>
					<small style="text-align: right;">3 days ago
					<div class="poster-alignment">
						<img class="poster-styling" src="https://image.tmdb.org/t/p/w300/kqjL17yufvn9OVLyXYpvtyrFfak.jpg">
					</div>
					</small>
				</div>
			</a>
				
			
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">List movie item 2</h5>
					<small class="text-muted">3 days ago</small> </div>
				<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				<small class="text-muted">Starring: </small> </a>
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">List movie item 3</h5>
					<small class="text-muted">3 days ago</small> </div>
				<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				<small class="text-muted">Starring: </small> </a>
		</div>
	</div>
	<?php include '../resources/footer.php'; ?>
</body>

<!-- Dropdown Scripts -->
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>

<script type="text/javascript">
	$( document ).ready( function () {
		$( "#header-list" ).addClass( "active" );
		$( '#editable-select' ).editableSelect();
		
		//on keyup get the form
		$('#editable-select').on('keypress', function(e) {
			var usersearch = $('#editable-select').html($('input:text').val());
			if (usersearch.val().length >= 0) {
				$('#editable-select').editableSelect('clear');
				$('#editable-select').editableSelect('add', '<img class="search-dropdown-loading" src="../../../img/826.svg">' );
			} else if (usersearch.val().length <= 0 && e.keyCode == 8) {
				$('#editable-select').editableSelect('clear');
			}
			
		})
		
	} );
</script>

</html>