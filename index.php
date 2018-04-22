<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Watch This Shit</title>

<?php include 'src/templates/resources/externalscripts.php'; ?>
</head>

<body>
<?php include 'src/templates/resources/header.php'; ?>

<?php
//For debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- Introductory Paragraph -->
<section class="introductory">
  <h1 class="col-xs-11 index-header-centered col-centered">Watch This Shit</h1>
  <div class="subtitle-responsive-text col-centered">
  	<p class="col-xs-11">This is an experimental website created to help you keep track of movies you want to watch in the most minimalist way possible.</p>
  	<p class="col-xs-11">Create an account today and start keeping track of those films that are important to you.</p>
  </div>
</section>

<!-- Adding movies -->
<div>
  <h1 class="col-xs-10 col-sm-10 col-centered index-subheader">What others have recently added...</h1>
</div>

<!-- Displaying results -->

<?php include 'src/templates/resources/footer.php'; ?>
</body>
</html>