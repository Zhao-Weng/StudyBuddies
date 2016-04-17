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
$userName = $userRow['username'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="UTF-8">
<head>
<title>Chat Room</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
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
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
	<link type="text/css" rel="stylesheet" href="css/chat.css" />
<meta charset="UTF-8">
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
						<li ><a href="change.php">Change</a></li>
						<li class="active"><a href="#">Chat</a></li>
						<li><a href="logout.php?logout">Sign Out</a></li>
					</ul>
				</nav>
			</div>
		</div>

<div id="main">

<div id="wrapper">
    <div id="menu">
        <p class="welcome">Welcome, <?php echo $userName;?><b></b></p>
        <div style="clear:both"></div>
    </div>
     
    <div id="chatbox">
	 
<?php
if(file_exists("scripts/log.html") && filesize("scripts/log.html") > 0){
    $handle = fopen("scripts/log.html", "r");
    $contents = fread($handle, filesize("scripts/log.html"));
    fclose($handle);     
    echo $contents;
}
?>
</div>

    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" maxlength="120"  />
        <button name="submitmsg" type="submit"  id="submitmsg" value="Send" class="btn btn-info">Send</button>
    </form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script type="text/javascript">
function loadLog(){     

        var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; 
        $.ajax({
            url: "scripts/log.html",
            cache: false,
            success: function(html){ 
       
                $("#chatbox").html(html); //Insert chat log into the #chatbox div   
                
                //Auto-scroll      
         
                var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
		
                if(newscrollHeight > oldscrollHeight){

                    $("#chatbox").animate({ scrollTop: newscrollHeight}, 'normal'); //Autoscroll to bottom of div
                }               
            },
        });
    }

setInterval (loadLog, 500);

$("#submitmsg").click(function(){   
        var clientmsg = $("#usermsg").val();

        $.post("scripts/postchat.php", {text: clientmsg});              
        $("#usermsg").attr("value", "");
        
      
        return false;
});
</script>
<style>
#main {
	padding: 1em 1em 1em 1em;
}

</style>
</body>
</html>