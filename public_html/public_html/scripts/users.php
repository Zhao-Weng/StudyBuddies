<?php
session_start();
include_once 'connectDB.php';

if(!isset($_SESSION['user'])){
	header("Location: index.php");
}
$session = $_SESSION['user'];
$qry = "
(SELECT user1 as text, COUNT( user1 ) as count
FROM Matches
WHERE liked =1
GROUP BY user1
ORDER BY COUNT( user1 ) DESC)
UNION
(SELECT user2, COUNT( user2 ) 
FROM Matches
WHERE liked =1
GROUP BY user2
ORDER BY COUNT( user2 ) DESC)
LIMIT 0, 8";
$res = mysqli_query($conn, $qry);
$data = array();
for ($x = 0; $x < mysqli_num_rows($res); $x++) {
    $data[] = mysqli_fetch_assoc($res);
}

$json_data = json_encode($data);
$fp = fopen('data.json', 'w');
fwrite($fp, $json_data);
fclose($fp);
?>
