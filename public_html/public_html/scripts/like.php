<?php
session_start();
include_once 'connectDB.php';

$u1 = $_GET['u1'];
$u2 = $_GET['u2'];

$r1 = mysqli_query($conn, "SELECT * FROM Matches WHERE user1='$u1' AND user2='$u2'");
$r2 = mysqli_query($conn, "SELECT * FROM Matches WHERE user1='$u2' AND user2='$u1'");
if(mysqli_num_rows($r1) === 0 && mysqli_num_rows($r2) === 0){
  	mysqli_query($conn, "INSERT INTO Matches(user1, user2, liked) VALUES ('$u1', '$u2', 0)");  	
	echo "Liked";
} else {
	if(mysqli_num_rows($r2) !== 0){
		$userRow = mysqli_fetch_array($r2);
		if($userRow['liked'] != 1){
			mysqli_query($conn, "UPDATE Matches SET liked = 1 WHERE user1='$u2' AND user2='$u1'");
		}	
		$qry = "SELECT t1.coursecode from (
  					(SELECT DISTINCT coursecode FROM Schedule WHERE useremail = '$u1')
 					UNION ALL 
  					(SELECT DISTINCT coursecode FROM Schedule WHERE useremail = '$u2')
				) AS t1 GROUP BY coursecode HAVING count(*) >= 2;";
		$cq = mysqli_query($conn, $qry);
		$courses = array();
		while($row = mysqli_fetch_array($cq)){
			array_push($courses, $row['coursecode']);	
		}
		
		$message1 = "Hi there, ".$u2." liked you. You are taking the following classes together!\n".implode(", ",$courses)."!\n";
		$message2 = "Hi there, ".$u1." liked you. You are taking the following classes together!".implode(", ",$courses)."!";
		//mail($u1, "We found a Match! - StudyBudies", $message1);
		//mail($u2, "We found a Match! - StudyBudies", $message2);
	echo $message1;
		echo "It's a Match! Check your email!";
	} else {
		echo "Liked Already!";
	}
}

?>
