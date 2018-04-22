<html>

<head>
	<meta charset="UTF-8">
	<title>Watch This Shit</title>

	<?php include '../resources/externalscripts.php'; ?>
</head>

<body>
	<?php include '../resources/header.php'; ?>

	<?php 
	if (!isset($_SESSION['login_user'])){
		header("Location: login.php");
	}
	
	
	
	?>

	<!-- Introductory Paragraph -->
	<section class="introductory-centered introductory">
		<h1 class="col-xs-11 other-header-centered col-centered">Settings</h1>
		<p class="col-xs-10 col-sm-7 col-centered">Insert settings here</p>
	</section>

	<!-- Settings list -->
	<div class="col-xs-10 col-sm-6 list-centered">
		<div class="list-group">
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">List movie item 1</h5>
					<small>3 days ago</small> </div>
				<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				<small>Starring: </small> </a>
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">List movie item 2</h5>
					<small class="text-muted">3 days ago</small> </div>
				<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				<small class="text-muted">Starring: </small> </a>
			<a href="#" class="list-group-item list-group-item-action flex-column align-items-start list-group-item-danger">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Delete account</h5> </div>
				<p class="mb-1">Delete all your data from the servers, this is irreversible.</p></a>
		</div>
	</div>



	<?php include '../resources/footer.php'; ?>
</body>

<script type="text/javascript">
	$( document ).ready( function () {
		$( "#header-about" ).addClass( "active" );
	} );
</script>

</html>