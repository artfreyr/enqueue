

<html>

<head>
	<meta charset="UTF-8">
	<title>Watch This Shit</title>

	<?php include '../resources/externalscripts.php'; ?>
</head>

<body>
	<?php include '../resources/header.php'; ?>

	

	<!-- Introductory Paragraph -->
	<section class="introductory-centered introductory">
		<h1 class="col-xs-11 other-header-centered col-centered">About</h1>
		<p class="col-xs-11 subtitle-responsive-text col-centered">This website was created out of an intent to learn and practice PHP/MySQL concepts.</p>
	</section>
	
	<section class="introductory-centered introductory">
		<h1 class="col-xs-11 other-header-centered col-centered">Credits</h1>
		<img class="tmdb-logo" src="../../../img/primary-green-d70eebe18a5eb5b166d5c1ef0796715b8d1a2cbc698f96d311d62f894ae87085.svg">
		<p class="col-xs-11 subtitle-responsive-text col-centered" style="padding-bottom: 190px;">Movie data on this website is courtesy of TMDb @ <a href="https://www.themoviedb.org/">https://www.themoviedb.org/</a>.</p>
		<p class="col-xs-11 subtitle-responsive-text col-centered" style="padding-bottom: 190px;">Icons made by <a href="https://www.flaticon.com/authors/roundicons-freebies">Roundicons Freebies </a>from www.flaticon.com.</p>
	</section>
	
	

	<?php include '../resources/footer.php'; ?>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        $("#header-about").addClass("active");
    });
</script>

</html>