<?php
session_start();
include_once 'scripts/connectDB.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$session = $_SESSION['user'];
$res = mysqli_query($conn, "SELECT * FROM User WHERE email='$session'");
$userRow = mysqli_fetch_array($res);

if(isset($_POST['registerCourse']))
{
 $email = mysqli_real_escape_string($conn, $_SESSION['user']);
 $code = mysqli_real_escape_string($conn, $_POST['registerCourse']);
 if(mysqli_query($conn, "INSERT INTO Schedule(useremail,coursecode) VALUES('$email','$code')"))
 {
  ?>
        <script>alert('Successfully Registered');
        // window.location = "home.php";
        </script>
        <?php
 } else {
  ?>
        <script>alert('error while registering you...');</script>
        <?php
 }
}

if(isset($_POST['dropCourse']))
{
 $email = mysqli_real_escape_string($conn, $_SESSION['user']);
 $code = mysqli_real_escape_string($conn, $_POST['dropCourse']);
 if(mysqli_query($conn, "DELETE FROM Schedule WHERE Schedule.useremail='$session' AND Schedule.coursecode='$code'"))
 {
  ?>
        <script>alert('Successfully Dropped');
        // window.location = "home.php";
        </script>
        <?php
 } else {
  ?>
        <script>alert('error while dropping course...');</script>
        <?php
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<title>Schedule - <?php echo $userRow['email']; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
	<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="js/skel.min.js"></script>
	<script src="js/skel-panels.min.js"></script>
	<script src="js/init.js"></script>
	<noscript>
		<link rel="stylesheet" href="css/skel-noscript.css"/>
		<link rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" href="css/style-desktop.css"/>

	</noscript>
	<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
</head>
<body>
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
					<li ><a href="home.php">Homepage</a></li>
					<li class="active"><a href="#">Change</a></li>
					<li ><a href="chat.php">Chat</a></li>
					<li><a href="logout.php?logout">Sign Out</a></li>
				</ul>
			</nav>
		</div>
	</div>

	<!-- Main -->
	<div id="main">
	<div id="courses" style="overflow-x:auto;">

		<?php
		$query="SELECT * FROM Course INNER JOIN Schedule 
		ON Course.code = Schedule.coursecode WHERE Schedule.useremail = '$session'";

		$result = mysqli_query($conn,$query);

		echo "<table><caption>Courses You Are In</caption><thead><tr>
		<th>Course Code</th>
		<th>Course Name</th>
		<th>Drop Course</th>
		</tr></thead><tbody>";
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row['code'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
    		// echo "<td>" . $row['date'] . "</td>";
			echo "<td><form method=\"post\">
			<button type=\"submit\" name=\"dropCourse\" value=\"".$row['code']."\" class=\"btn btn-warning\">Drop</button>
			</form></td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
		?>
	</div>

	<div id="addcourses">
		<div>
			<form>
				<select name="course" onchange="chooseCourse(this.value)">
					<option value="">Select a Subject:</option>
					<option value="CS">CS</option>
					<option value="ECE">ECE</option>
					<option value="BUS">BUS</option>
					<option value="PSYC">PSYC</option>
				</select>
			</form>
			<div><b>Courses provided: </b></div>
		</div>
		<div id="txtHint" style="overflow-x:auto;"></div>
	</div>
</div>
</body>

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<script type="text/javascript">
function chooseCourse(str){
	if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
  } else {
    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","scripts/getCourse.php?q="+str,true);
        xmlhttp.send();
  }
}
</script>


<style>
table {
  border-collapse: separate;
  border-spacing: 2px;
  border-color: grey;
  width:100%;
  table-layout: fixed;
}

caption {
  text-align: left;
  color: silver;
  font-weight: bold;
  text-transform: uppercase;
  padding: 2px;
}

thead {
  background: SteelBlue;
  color: white;
}

th,
td {
  padding: 5px 10px;
}

tbody tr:nth-child(even) {
  background: WhiteSmoke;
}

tbody tr td {
  text-align:left;
  font-family: monospace;
}

tfoot {
  background: SeaGreen;
  color: white;
  text-align: right;
}

tfoot tr th:last-child {
  font-family: monospace;
}

#main {
	padding: 1em 1em 1em 1em;
}
</style>
</html>