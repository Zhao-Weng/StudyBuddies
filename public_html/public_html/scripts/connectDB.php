<?php
$servername = "engr-cpanel-mysql.engr.illinois.edu";
$username = "team38cs_admin";
$password = "admin";
$dbname = "team38cs_project_db";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn){
    die("Connection failed: " . $conn->connect_error);
    ?>
        <script>alert('successfully registered ');</script>
        <?php
}
//echo "Connected successfully"; 
?>