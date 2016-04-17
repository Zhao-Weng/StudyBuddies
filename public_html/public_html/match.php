<?php
session_start();
include_once 'scripts/connectDB.php';

if(!isset($_SESSION['user'])){
	header("Location: index.php");
}
$session = $_SESSION['user'];
$res = mysqli_query($conn, "SELECT * FROM User WHERE email='$session'");
$userRow = mysqli_fetch_array($res);
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
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<!-- Header -->
	<div id="header">
		<div class="container"> 
			<!-- Logo -->
			<div id="logo">
				<h1><a href="#" style="font-size:3em;">StudyBuddies</a></h1>
				<span>Design by TEAM 38</span>
			</div>
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li><a href="home.php">Homepage</a></li>
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
			<br>
			<!-- Match -->
			<div>
				<?php 	
				$result = mysqli_query($conn, "SELECT username, email, image FROM User  WHERE email = ANY(SELECT S2.useremail FROM Schedule S1, Schedule S2 WHERE S1.useremail = '$session' AND S1.coursecode = S2.coursecode AND S1.useremail <> S2.useremail GROUP BY S2.useremail HAVING COUNT(S2.useremail) >= 2) ORDER BY RAND()");
				$num = mysqli_num_rows($result);
				if($num == 0){
					echo "<h1>Sorry we can't find any matches...</h1>";
				}
				else{ 
					echo '<center>';
					echo '<div class="carousel slide" data-ride="carousel" id="myCarousel" data-interval="false">';
						echo '<ol class="carousel-indicators">';
						for ($x = 0; $x < $num; $x++) {
							if($x!==0){
	   							echo '<li data-target="#myCarousel" data-slide-to="'.$x.'"></li>'; 
	   						} else {
	   							echo '<li data-target="#myCarousel" data-slide-to="'.$x.'" class="active"></li>';
	   						}
						}
						echo "</ol>";

						$first = true;
						echo '<div class="carousel-inner" role="listbox">';
						while($row = mysqli_fetch_array($result)){
							if($first){
								echo '<div class="item active">';
								$first = false;
							} else {
								echo '<div class="item">';
							}
							
							echo '<div class = "blur-img"><img src="data:image;base64,'.$row['image'].'" height="400" width="400"></div>';
								echo '<div class="carousel-caption">';
									echo '<h4>'.$row['username'].'</h4>';
									echo '<button class="likeMatch" type="submit" name="like" value="'.$row['email'].'" id="'.$row['email'].'">like</button>';
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
					echo '<a href="#myCarousel" id="leftc" class="left carousel-control" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></a>';
					echo '<a href="#myCarousel" id="rightc" class="right carousel-control" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></a>';
					echo '</div></center>';
				}
				?>
			</div>

			<!-- Result -->
			<div class="message">
				<h3 id="re"> </h3>
			</div>
		</div>
	</div>


	<script type="text/javascript">
	$(document).ready(function(){
		$("#leftc").click(function(){
			$("#re").text("");
		})
		$("#rightc").click(function(){
			$("#re").text("");
		})
		$("button").click(function(){
			var me = "<?php echo $session?>";
			var you = $(this).attr("value");
			$.ajax({
				url:"scripts/like.php",
				type:"GET",
				data: {u1: me, u2: you},
				success:function(data, textStatus, jqXHR)
				{
					$("#re").text(jqXHR.responseText);
					document.getElementById(you).style.visibility = "hidden";
				},
				error: function (jqXHR, textStatus, errorThrown)
				{

				}
			});
		});
	});
	</script>


	<style>
	#main {
		padding: 2em 0em 2em 0em;
	}
	.carousel-control {
		background:transparent;
		width:0%;
	}
	#re {
		font-size: 24px;
		text-align: center;
		text-transform: none;
		color:tomato;
	}
	</style>
</body>
</html>



