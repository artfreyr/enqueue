<?php

include( "config/config.php" );
session_start();

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

	$myusername = mysqli_real_escape_string( $conn, $_POST[ 'username' ] );
	$mypassword = mysqli_real_escape_string( $conn, $_POST[ 'password' ] );
	$myemail = mysqli_real_escape_string($conn, $_POST['email']);

	$usernamesql = "SELECT memberid FROM userprofile WHERE username = '$myusername'";
	$usernameresult = mysqli_query( $conn, $usernamesql );
	$usernamerow = mysqli_fetch_array( $usernameresult, MYSQLI_ASSOC );
	$usernameactive = $usernamerow[ 'active' ];
	$usernamecount = mysqli_num_rows( $usernameresult );
	
	$emailsql = "SELECT memberid FROM userprofile WHERE email = '$myemail'";
	$emailresult = mysqli_query($conn, $emailsql);
	$emailrow = mysqli_fetch_array($emailresult, MYSQLI_ASSOC);
	$emailactive = $emailrow['active'];
	$emailcount = mysqli_num_rows($emailresult);

	if ( $usernamecount == 1 ) {
		$error = "The username already exists.";
	} else if ($emailcount == 1) {
		$error = "The email already exists.";
	} else {
		$registsql = "INSERT INTO userprofile (username, email, password) VALUES ('$myusername', '$myemail', '$mypassword')";
		$emailresult = mysqli_query($conn, $registsql);
		if ($emailresult) {
			$error = "User Created Successfully.";
		} else {
			$error = "Some sort of registration error.";
		}
		
	}
}

?>


<html>
   
   <head>
      <title>Registration Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Username  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/>
                  <label>Email  :</label><input type = "email" name = "email" class = "box"/><br /><br /><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?>
               <?php //if(isset($smsg)){ ?> <?php //echo $smsg; ?> </div><?php// } ?>
               </div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>