<?php
session_start();
include_once 'connectDB.php';

if(!isset($_SESSION['user'])){
	header("Location: index.php");
}
$session = $_SESSION['user'];
$res = mysqli_query($conn, "SELECT coursecode, COUNT(coursecode) FROM Schedule GROUP BY coursecode ORDER BY COUNT(coursecode) DESC LIMIT 0, 7");
$data = array();
for ($x = 0; $x < mysqli_num_rows($res); $x++) {
    $data[] = mysqli_fetch_assoc($res);
}

$json_data = json_encode($data);
$fp = fopen('data.csv', 'w');
$col = array();
$col[] = "coursecode";
$col[] = "num";
fputcsv($fp,$col);
foreach($data as $f){
	fputcsv($fp, $f);
}
fclose($fp);
?>
