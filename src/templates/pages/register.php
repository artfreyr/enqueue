

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
		
		// Check to see if username already exists in DB
		$registcheck = "SELECT memberid FROM userprofile WHERE username = ?";
		$registcheck->bind_param("s", $_POST['username']);
		$registcheck->execute();
		$duperesult = $registcheck->get_result();
		
		if ($duperesult->num_rows > 0) { // Return error string that username is taken
			$returnmessage = "This username has been taken";
		} else if ("" == trim($_POST['username']) || "" == trim($_POST['password'])) { // Check if Username and Password fields are empty
			$returnmessage = $conn->prepare("Username or password field cannot be empty");
		} else { // Insert registration data into DB
			if ("" == trim($_POST['email'])) { // If user did not provide email
				$registstatement = $conn->prepare("INSERT INTO userprofile (username, password, email) VALUES (?, ?, ?)");
				$registstatement->bind_param("sss", $_POST['username'], $_POST['password'], NULL);
				$succstatus = $registstatement->execute();
				
				// Initialise supplementary tables after successful user creation
				if ($succstatus != false) {
					$returnmessage = initialisetables($conn, $_POST['username']);;
				}	
			} else { // If user provides email
				$registstatement = $conn->prepare("INSERT INTO userprofile (username, password, email) VALUES (?, ?, ?)");
				$registstatement->bind_param("sss", $_POST['username'], $_POST['password'], $_POST['email']);
				$registstatement->execute();
				
				// Initialise supplementary tables after successful user creation
				if ($succstatus != false) {
					$returnmessage = initialisetables($conn, $_POST['username']);;
				}
			}
		}
	}
	
	// Function to initialise other tables
	function intialisetables($conn, $uname) {
		// Query memberid from DB first
		$memberidstatement = $conn->prepare("SELECT * FROM userprofile WHERE username = ?");
		$memberidstatement->bind_param("s", $uname);
		$result = $memberidstatement->get_result();
		
		// Obtain ID and use it on the new tables
		if ($memberidstatement->execute() == FALSE || $result->num_rows == 0){
			return "Unacceptable input may have been detected";
		} else {
			$row = $result->fetch_assoc();
			$newmemberid = $row['memberid'];
			$initialisesql = "INSERT INTO usermovielist (memberid) VALUES ($newmemberid)";
			
			mysqli_query($conn, $initialisesql);
			
			return "User created successfully, you may now login.";
		}
	}
	?>

	<!-- Introductory Paragraph -->
	<section class="introductory-centered introductory">
		<h1 class="col-xs-11 other-header-centered col-centered">Create a WTS account</h1>
		<p class="col-xs-10 subtitle-responsive-text col-centered"><strong>NOTICE:</strong> Passwords are not hashed, please do not use secure password.</p>
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
						<small id="passwordHelpBlock" class="form-text text-muted">
						  Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
						</small>
					</div>
				</div>
			</div>
			<div class="col-xs-10 col-sm-8 col-lg-5 container">
				<div class="form-group">
					<div>
						<input type="email" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Email (Optional)" name="email">
						<small id="passwordHelpBlock" class="form-text text-muted">
						  An email address is optional and would only be used as a password recovery option.
						</small>
					</div>
				</div>
			</div>
			<div>
				<button type="submit" class="btn btn-lg btn-primary" type="submit" value="submit">Create Account</button>
				<button type="button" class="btn btn-secondary btn-lg" onclick="window.location.href = 'login.php';">Login</button>
			</div>
		</form>
		<div class="col-xs-12">
			<?php if(isset($returnmessage)) { echo $returnmessage;} ?>
		</div>
	</div>

	<?php include '../resources/footer.php'; ?>
</body>

</html>