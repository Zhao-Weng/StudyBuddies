<?php
session_start();
include_once 'scripts/connectDB.php';
if(isset($_SESSION['user'])!=""){
    header("Location: home.php");
}

if(isset($_POST['btn-signup'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $image = addslashes($_FILES['image']['tmp_name']);
    
    $imgCheck = getimagesize($image);
    if($imgCheck!==FALSE){
        $image = file_get_contents($image);
        $image = base64_encode($image);
    }
    $emailCheck = filter_var($email, FILTER_VALIDATE_EMAIL);
    $nameCheck = preg_match("/^[a-zA-Z0-9 ]*$/",$name);

    $check = $imgCheck && $emailCheck && $nameCheck;

    if($check && mysqli_query($conn, "INSERT INTO User(email,username,password,image) VALUES('$email','$name','$pass','$image')")){
        ?><script>
        alert('Successfully Registered');
        window.location = "index.php";
        </script><?php
    } else {
        if(!$imgCheck){
            ?><script>alert('Please select a picture');</script><?php
        } else {
            if(!$emailCheck){
                ?><script>alert('Email address is not valid');</script><?php
            } else {
                if(!$nameCheck){
                    ?><script>alert('Username is not valid');</script><?php
                } else {
                    ?><script>alert('It seems that the user email already exists');</script><?php
                }
            }
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>Register</title>
    <link rel="stylesheet" href="css/login.css" type="text/css" />
</head>
<body>
    <center>
        <div id="login-form">
            <form method="post" enctype="multipart/form-data">
                <table align="center" width="30%" border="0">
                    <tr><td><input type="text" name="username" placeholder="User Name" required /></td></tr>
                    <tr><td><input type="email" name="email" placeholder="Your Email" required /></td></tr>
                    <tr><td><input type="password" name="password" pattern=".{6,}" title="Password must contain at least 6 characters." placeholder="Your Password" required /></td></tr>
                    <tr><td><input type="file" name="image" id="file" class="inputfile" accept="image/*" required /></td></tr>
                    <tr><td><button type="submit" name="btn-signup">Sign Me Up</button></td></tr>
                    <tr><td><a href="index.php">Sign In Here</a></td></tr>
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