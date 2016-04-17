<?php
session_start();
include_once 'connectDB.php';
if(isset($_SESSION['user'])){

	$session = $_SESSION['user'];
	$res = mysqli_query($conn, "SELECT * FROM User WHERE email='$session'");
	$userRow = mysqli_fetch_array($res);
	$userName = $userRow['username'];

    $text = $_POST['text'];
    $text = trim($text);
  $text = stripslashes($text);
  //$text = htmlspecialchars($text);
  if($text !==""){
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("M-j g:i A").") <b>".$userName."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
   }
}
?>