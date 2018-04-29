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
	
	// Check user's movie list
	$currentmemberid = $_SESSION['memberid'];
	
	$listcheck = "SELECT * FROM usermovielist WHERE memberid = '$currentmemberid'";
	$planninglist = mysqli_query($conn, $listcheck);
	$planninglistarray = mysqli_fetch_array($planninglist);
	
	$planningstatus = $planninglistarray['planning'];
	
	$watchlistoutput = "";
	
	if ($planninglistarray['planning'] == NULL) {
		$watchlistoutput = "<div class='list-group-item flex-column'><div class='empty-list'>
								<img class='empty-list-egg' src='../../../img/lucky-egg.svg' />
								<p class='empty-list-title'>There are no movies in your list</p>
								<p class='empty-list-text'>List zero you need to ask your friends to intro you to some movies.</p>
							</div></div>";
	} else {
		// Get planning JSON
		$obtainjson_sql = "SELECT * FROM usermovielist WHERE memberid = $currentmemberid";
		$obtainjson_dbreturn = mysqli_query($conn, $obtainjson_sql);
		$obtainjson_dbassocarr = mysqli_fetch_array( $obtainjson_dbreturn, MYSQLI_ASSOC );
		$obtainjson_jsonarray = json_decode($obtainjson_dbassocarr['planning'], true);
		
		// Display JSON data
		$jsonsize = count($obtainjson_jsonarray);
		
		
		for ($i = 0; $i < count($obtainjson_jsonarray); $i++){
			
			$currtitle = $obtainjson_jsonarray[$i]['title'];
			$currposter = 'https://image.tmdb.org/t/p/w300/' . $obtainjson_jsonarray[$i]['poster'];
			$currdesc = $obtainjson_jsonarray[$i]['overview'];
			$curryear = substr($obtainjson_jsonarray[$i]['year_released'],0 , 4);
			$curractors = $obtainjson_jsonarray[$i]['actors'];
			
			$watchlistoutput = $watchlistoutput . "<a href='#' class='list-group-item list-group-item-action flex-column align-items-start'>
				<div class='d-flex w-100 justify-content-between'>
					<div class='mb-1'>
						<h5>$currtitle</h5>
						<p>$currdesc</p>
						<small class='description-gap'>Starring: $curractors</small>
						<br><small>Year Released: $curryear</small>
					</div>
					<small style='text-align: right;'>3 days ago
					<div class='poster-alignment'>
						<img class='poster-styling' src='$currposter'>
					</div>
					</small>
				</div>
			</a>";
		}
		
	}
	
	
	?>

	<!-- Introductory Paragraph -->
	<section class="introductory-centered introductory">
		<h1 class="col-xs-10 other-header-centered col-centered">There are way too many good movies out there</h1>
		<p class="col-xs-10 subtitle-responsive-text col-centered">Your friends recommend you movies, you tell them you'd catch it when you get the free time. But then that free time comes and you simply have no idea what movie to watch.</p>
		<p class="col-xs-10 subtitle-responsive-text col-centered" style="padding-top: 16px;">Add that movie to WTS now while it is fresh in your mind. Then when the time comes, clear it!</p>
	</section>

	<!-- Movie search box -->
	<div class="row col-xs-10 searchbar-centered">
		<select id="editable-select" class="form-control form-control-lg searchbar-child-centered" placeholder="Start typing to add a movie" name="active-search" method="post" data-filter="false" data-effects="slide">
		</select>
		
		<p><?php if (isset($htmlfriendly)) {echo $htmlfriendly;} ?></p>
	</div>

	<!-- Displaying watchlist -->
	<div class="col-xs-10 empty-list-centered">
		<div class="list-group">
		<?php echo $watchlistoutput; ?>
			
		</div>
	</div>
	<?php include '../resources/footer.php'; ?>
</body>

<!-- Dropdown Scripts -->
<!-- https://github.com/indrimuska/jquery-editable-select -->

<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>

<script type="text/javascript">
	$( document ).ready( function () {
		$( "#header-list" ).addClass( "active" );
		var movieselect = $( '#editable-select' );
		movieselect.editableSelect();
		
		
		// Global timeout variable for delayed search Reference: https://bit.ly/2qWuEyN
		var globaltimeout = null;
		
		// On keyup start searching
		$('#editable-select').on('keypress', function(e) {
			// Set globaltimeout back to null to reset search delay
			if (globaltimeout != null) {
				clearTimeout(globaltimeout);
			}
			
			// Saves current query into a variable
			var usersearch = $('.es-input').val();
			
			// Starts searching if length > 0
			if (usersearch.length >= 0) {
				// Add a loading indicator
				$('#editable-select').editableSelect('clear');
				$('#editable-select').editableSelect('add', '<img class="search-dropdown-loading" src="../../../img/826.svg">' );
				
				// Get search results after 0.5 seconds to reduce API calls
				globaltimeout = setTimeout(function(){
					globalTimeout = null;
					
					// Send to searchfunction to handle search and list population
					searchfunction(usersearch);
				}, 500);
			} 
			
			// Hide the dropdown when there is no entry
			if (usersearch.length <= 0) {
				$('#editable-select').editableSelect('hide');
				$('#editable-select').editableSelect('clear');
			}
		})
		
		// Search function
		function searchfunction(usersearch){
			// Reference: https://bit.ly/2K4IDKy
				$.ajax({ 
					url: 'tmdbinterface.php',
					data: {action: usersearch},
					type: 'post',
					dataType: 'json',
					success: function(output){
						// Clear loading indicator
						$('#editable-select').editableSelect('clear');
						
						// Add movie suggestions to dropdown
						$.each(output, function(index, value){
							$('#editable-select').editableSelect('add', function(){
								$(this).val(output[index].id);
								$(this).text(output[index].title);
							});
						})
					}
				});
		}
		
		// Submit movie to database Reference: https://bit.ly/2JrOEQG
		movieselect.on('select.editable-select', function(e, li) {
			// Reference: https://bit.ly/2HZ2Sc6
			var userselection = li.val();
			console.log("The user clicked " + userselection);
			
			$.ajax({ 
					url: 'tmdbinterface.php',
					data: {addtolist: userselection},
					type: 'post',
					//dataType: 'json',
					success: function(output2){
						console.log("The server returned" + output2);
						
					}
				});
		});
		
		function appendtolist(jsonreceived) {
			
		}
		
		
	});
</script>

</html>