<?php
session_start();
include_once 'scripts/connectDB.php';

if(!isset($_SESSION['user'])){
	header("Location: index.php");
}
$session = $_SESSION['user'];
$res = mysqli_query($conn, "SELECT * FROM User WHERE email='$session'");
$userRow = mysqli_fetch_array($res);

if(isset($_POST['changePic'])){
	$image = addslashes($_FILES['image']['tmp_name']);
    
    $imgCheck = getimagesize($image);
    if($imgCheck!==FALSE){
        $image = file_get_contents($image);
        $image = base64_encode($image);
        $r = mysqli_query($conn, "UPDATE User SET image='$image' WHERE email='$session'");
        if($r===FALSE){
        	?><script>alert('Error when updating.');</script><?php
        }
    } else {
    	?><script>alert('Please select a picture!');</script><?php
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<title>StudyBuddies</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
	<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<script src="js/skel.min.js"></script>
	<script src="js/skel-panels.min.js"></script>
	<script src="js/init.js"></script>
	<noscript>
		<link rel="stylesheet" href="css/skel-noscript.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style-desktop.css" />
	</noscript>
	<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
</head>
<body onload="startTime()">
	<!-- Header -->
	<div id="header">
		<div class="container"> 
			<!-- Logo -->
			<div id="logo">
				<h1><a href="#">StudyBuddies</a></h1>
				<span>Design by TEAM 38</span>
			</div>
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li class="active"><a href="#">Homepage</a></li>
					<li><a href="change.php">Change</a></li>
					<li><a href="chat.php">Chat</a></li>
					<li><a href="logout.php?logout">Sign Out</a></li>
				</ul>
			</nav>
		</div>
	</div>
	<!-- Main -->
	<div id="main">
		<div class="container">
			<div class="row">
				<div class="8u skel-cell-important" id="content">
					<section>
						<header>
							<h2>Welcome to Studybuddies</h2>
							<span class="byline"><?php echo $userRow['username'];?></span>
							<h3 class="byline" id="time"></h3>
						</header>
						<a href="#" class="image full"><img src="images/grainger.jpg" height="300px" alt=""/></a>
						<p>Hello! This a class schedule sharing website that helps you manage your time andfind other students who are taking the same classes with you. As a student, you can share your course schedules. This web application can recommend other students who are taking the similar classes to the user. In addition, we provide students with the workload information of each course and users can also use this web application to record their time spent on the specific course.  Essentially, this is a social website where students can find their study buddies and form study groups. We think it would be very useful because this is a fun way where you have the chance to know your classmates. The data for this web application will be based on real data from the college students. To populate the database, we will encourage our friends and classmates to upload their class schedules. The basic functions includes uploading/displaying/editing the course schedule, providing class information to users.</p>
						<ul>
							<li>
								<h3>User photo:</h3>
								<div class="blur-pic">
									<?echo '<img style="height:400px; width:300px" src="data:image;base64,'.$userRow['image'].' "> ';?>
									<form class="cp" method="post" enctype="multipart/form-data">
									<input type="file" name="image" accept="image/*" value="update"/>
									<button type="submit" name="changePic">Update</button>
									</form>
								</div>
							</li>
						</ul>
					</section>
				</div>

				<div class="4u" id="sidebar">
					<section>
						<header>
							<h2>Useful Links</h2>
						</header>
						<ul class="style">
							<li>
								<p class="posted">Piazza</p>
								<a href="http://www.piazza.com" target="_blank"><img src="images/piazza.png" alt="" width="100px" height="100"/></a>
								<p class="text">Piazza is a free online gathering place where students can ask, answer, and explore 24/7, under the guidance of their instructors.</p>
							</li>
							<li>
								<p class="posted">Compass</p>
								<a href="https://compass.illinois.edu" target="_blank"><img src="images/compass.png" alt="" width="100px" height="100"/></a>
								<p class="text">Compass is the Enterprise Learning Management System for the Urbana campus. Compass provides an online learning environment for students.</p>
							</li>
							<li>
								<p class="posted">Moodle</p>
								<a href="https://learn.illinois.edu" target="_blank"><img src="images/moodle.jpeg" alt="" width="100px" height="100"/></a>
								<p class="text">Moodle is the Enterprise Learning Management System for the Urbana campus. Moodle provides an online learning environment for students.</p>
							</li>
							<li>
								<p class="posted">Library</p>
								<a href="http://www.library.illinois.edu" target="_blank"><img src="images/lib.jpg" alt="" width="100px" height="100"/></a>
								<p class="text">The campus library system is one of the largest public academic collections in the world. This is the place you belong to.</p>
							</li>
							<li>
								<p class="posted">Email</p>
								<a href="https://g.illinois.edu" target="_blank"><img src="images/email.jpeg" alt="" width="100px" height="100"/></a>
								<p class="text"> Undergraduates are provided with Google Apps @ Illinois accounts for email, calendar services, online collaboration and file storage.</p>
							</li>
						</ul>
					</section>
				</div>
			</div>
		</div>
	</div>

	<!-- Featured -->
	<div id="featured">
		<div class="container">
			<div class="row">
				<div class="4u">
					<h2>Find Some Friends</h2>
					<a href="match.php" class="image full"><img src="images/pic01.jpg" alt="" /></a>
					<p>Find friends who take similar classes. Also, you can explore friends' album pictures and like their pictures!</p>
					<p><a href="match.php" class="button">More Detail</a></p>
				</div>
				<div class="4u">
					<h2>Chat With Friends</h2>
					<a href="chat.php" class="image full"><img src="images/pic02.jpg" alt="" /></a>
					<p>Chat and share your school life with everyone on this website! </p>
					<p><a href="chat.php" class="button">More Detail</a></p>
				</div>
				<div class="4u">
					<h2>Find popular classes/users</h2>
					<a href="#" class="image full"><img src="images/pic03.jpg" alt="" /></a>
					<p>Find all popular courses and users in a friendly visualization here! </p>
					<p><a href="class.php" class="button">More Detail</a></p>
				</div>
				
			</div>
		</div>
	</div>

	<!-- Copyright -->
	<div id="copyright">
		<div class="container">
			Design: <a href="http://templated.co">TEMPLATED</a> Images: <a href="http://unsplash.com">Unsplash</a> (<a href="http://unsplash.com/cc0">CC0</a>)
		</div>
	</div>

	<script>
	function startTime() {
		var today = new Date();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();
		h = checkTime(h);
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById('time').innerHTML ="It's " +
		h + ":" + m + ":" + s + " now.";
		var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
    	if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    	return i;
	}
	</script>
<style type="text/css">
.blur-pic img {
  -webkit-transition: all 1s ease;
     -moz-transition: all 1s ease;
       -o-transition: all 1s ease;
      -ms-transition: all 1s ease;
          transition: all 1s ease;
}
 
.blur-pic img:hover {
  -webkit-filter: blur(5px);
}
.blur-pic:hover .cp{
	display: block;
}
.blur-pic form{
	display:none;
	top:0;
}
.blur-pic {
	width: 300px;
	position:relative;
}
</style>
</body>
</html>