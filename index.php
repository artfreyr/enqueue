<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Watch This Shit</title>

<?php 
	// Includes externalscripts.php with common CSS and JS scripts for every page
	include 'src/templates/resources/externalscripts.php'; 
?>

<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick/slick/slick.css"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick/slick/slick-theme.css"/>
</head>

				

<body>
<?php 
	// Includes common site wide header template
	include 'src/templates/resources/header.php'; 
?>

<?php
	// For debugging purposes
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	// To populate homepage carousel
	// Query database for array of recently added movies
	$recentquery = "SELECT * FROM appdatastore WHERE datapoint = 1";
	$recentquery_dbreturn = mysqli_query($conn, $recentquery);
	
	$row = mysqli_fetch_array( $recentquery_dbreturn, MYSQLI_ASSOC );
	
	$recentquery_array = unserialize($row['appdata']);
	
	// Poster code variable
	$outputposters = "";
	
	foreach ($recentquery_array as $key=>$value) {
		$outputposters = $outputposters . "<div><img class='index-poster' src=https://image.tmdb.org/t/p/w500/$recentquery_array[$key]></div>";
	}
	
?>

<!-- Introductory Paragraph -->
<section class="introductory">
  <h1 class="col-xs-11 index-header-centered col-centered">Watch This Shit</h1>
  <div class="subtitle-responsive-text col-centered">
  	<p class="col-xs-11">This is an experimental website created to help you keep track of movies you want to watch in the most minimalist way possible.</p>
  	<p class="col-xs-11">Create an account today and start keeping track of those films that are important to you.</p>
  </div>
</section>

<!-- User movies scroller -->
<div class="poster-carousel-formatting">
  <h1 class="col-xs-10 col-sm-10 col-centered index-subheader">What others have recently added...</h1>
  <div class="slick-list draggable center-posters">
  	<div class="poster-carousel slick-track">
  	  <?php echo $outputposters; ?>
    </div>
  </div>
  
</div>

<!-- Displaying results -->

<?php 
	// Includes common site wide footer template
	include 'src/templates/resources/footer.php'; 
?>


<!-- Scripts for Slick carousel-->

<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick/slick/slick.min.js"></script>

<script>
	$(document).ready(function(){
	  $('.poster-carousel').slick({
	  dots: true,
	  infinite: true,
	  speed: 300,
	  slidesToShow: 4,
	  slidesToScroll: 3,
	  autoplay: true,
      autoplaySpeed: 2500,
	  centerMode: true,
      centerPadding: '40px',
	  arrows: true,
	  responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
			dots: true
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		}
		// You can unslick at a given breakpoint now by adding:
		// settings: "unslick"
		// instead of a settings object
	  ]
	  });
	});
</script>


</body>


</html>