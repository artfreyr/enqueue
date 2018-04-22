

<html>

<head>
	<meta charset="UTF-8">
	<title>Watch This Shit</title>

	<?php include '../resources/externalscripts.php'; ?>
</head>

<body>
	<?php include '../resources/header.php'; ?>

	<?php
	// If browser has existing session, direct user to their list
	if(isset($_SESSION['login_user'])){
		header("Location: userlist.php");
	}
	
	// On browser POST request, submit registration form
	if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

		$myusername = mysqli_real_escape_string( $conn, $_POST[ 'username' ] );
		$mypassword = mysqli_real_escape_string( $conn, $_POST[ 'password' ] );
		$myemail = mysqli_real_escape_string( $conn, $_POST[ 'email' ] );

		
		
		// Following lines of code determine if there is a matching username in the database
		$sql = "SELECT memberid FROM userprofile WHERE username = '$myusername'";

		$result = mysqli_query( $conn, $sql );

		$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );

		$active = $row[ 'active' ];

		$count = mysqli_num_rows( $result );

		// If username exists then return error
		if ( $count == 1 ) {
			$returnmessage = "This username has been taken";
		} else {
			// Else insert user details into database
			if ($myemail == NULL) {
				$sql = "INSERT INTO userprofile (username, password, email) VALUES ('$myusername', '$mypassword', NULL)";
				
				createuser($conn, $sql);
			} else {
				$sql = "INSERT INTO userprofile (username, password, email) VALUES ('$myusername', '$mypassword', '$myemail')";
				
				createuser($conn, $sql);
			}
		}
	}
	
	// Function createuser to prevent duplicate code and insert new user
	function createuser($conn, $incomingsql) {
		if (mysqli_query($conn, $incomingsql)){
			global $returnmessage;
			$returnmessage = "User created successfully";
		}
	}
	?>

	<!-- Introductory Paragraph -->
	<section class="introductory-centered introductory">
		<h1 class="col-xs-11 other-header-centered col-centered">Create a WTS account</h1>
		<p class="col-xs-10 subtitle-responsive-text col-centered"><strong>NOTICE:</strong> Passwords are not currently encrypted, please do not use secure password.</p>
	</section>

	<!-- Respective forms -->
	<div class="col-centered regist-form">
		<form action="" method="post">
			<div class="col-xs-10 col-sm-8 col-lg-5 container">
				<div class="form-group">
					<div>
						<input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Username*" name="username">
					</div>
				</div>
			</div>
			<div class="col-xs-10 col-sm-8 col-lg-5 container">
				<div class="form-group">
					<div>
						<input type="password" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Password*" name="password">
					</div>
				</div>
			</div>
			<div class="col-xs-10 col-sm-8 col-lg-5 container">
				<div class="form-group">
					<div>
						<input type="email" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Email (Optional)" name="email">
					</div>
				</div>
			</div>
			<div>
				<button type="submit" class="btn btn-lg btn-primary" type="submit" value="submit">Create Account</button>
			</div>
		</form>
		<div class="col-xs-12">
			<?php if(isset($returnmessage)) { echo $returnmessage;} ?>
		</div>
	</div>

	<?php include '../resources/footer.php'; ?>
</body>

</html>