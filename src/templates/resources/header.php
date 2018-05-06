

<?php
include(dirname(__FILE__).'../../../config/config.php');
session_start();

function signout() {
	unset($_SESSION['login_user']);
	session_destroy();
}

if (isset($_GET['logout'])){
	signout();
}

if(isset($_SESSION['login_user'])) {
	$loginlabel = "<a class='nav-link dropdown-toggle dropdown-display' href='#signuplogin' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" .  "Welcome back, " . $_SESSION['login_user'] . "!" . " </a>";
	$dropdowncontents = "<div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='http://development.daniell.im/src/templates/pages/settings.php'>Settings</a><a class='dropdown-item' href='header.php?logout=true'>Sign Out</a></div>";
} else {
	$loginlabel = "<a class='nav-link' id='navbarDropdownMenuLink' href='http://development.daniell.im/src/templates/pages/login.php'>Login</a>";
	unset($dropdowncontents);
}
?>

<html>
<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
	<div class="collapse navbar-collapse" id="navbarText">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item" id="header-list"> <a class="nav-link" href="/src/templates/pages/userlist.php">List</a> </li>
			<li class="nav-item" id="header-about"> <a class="nav-link" href="/src/templates/pages/about.php">About</a> </li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown"><?php echo $loginlabel; ?>
			<?php if(isset($dropdowncontents)) {echo $dropdowncontents;} ?>
			</li>
		</ul>
		<span> </span> </div>
</nav>



</html>


