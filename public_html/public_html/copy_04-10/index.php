<?php
session_start();
include_once 'scripts/connectDB.php';

if(isset($_SESSION['user'])!=""){
	header("Location: home.php");
}
if(isset($_POST['btn-login'])){
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = md5($_POST['password']);
	$check = filter_var($email, FILTER_VALIDATE_EMAIL);
	$res=mysqli_query($conn, "SELECT * FROM User WHERE email='$email'");
	$row=mysqli_fetch_array($res);
	if($check && $row['password']== $pass){
		$_SESSION['user'] = $row['email'];
		header("Location: home.php");
	} else {
		?><script>alert('Wrong User Info');</script><?php
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/login.css" type="text/css" />
	<title>Team 38 CS 411</title>
</head>

<body>
	<center>
		<div id="login-form">
			<form method="post">
				<table align="center" width="30%" border="0" >
					<tr><td><input type="text" name="email" placeholder="Your Email" required /></td></tr>
					<tr><td><input type="password" name="password" placeholder="Your Password" required /></td></tr>
					<tr><td><button type="submit" name="btn-login">Sign Me In</button></td></tr>
					<tr><td><a href="register.php">Sign Up Here</a></td></tr>
				</table>
			</form>
		</div>
	</center>

	<video id="bgvideo" preload="auto" autoplay="autoplay" loop="loop">
		<source src="/video/curious.webm" type="video/webm">
		<source src="/video/curious.mp4" type="video/mp4">
		Sorry, your browser does not support HTML5 video.
		</video>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>