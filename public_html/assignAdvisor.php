<?php

	session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
if (
    !in_array("gs", $_SESSION["user_role"])
) {
    header("Location: index.php");
}
$uid = $_SESSION["user_id"];
$servername = "127.0.0.1";
$username = "harmonandbrooke";
$password = "DBteam18!";
$dbname = "harmonandbrooke";
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    // Redirect to user friendly error page
    die('Error: ' . mysqli_connect_error());
}

		$studentid = $_POST["id"];
		$advisorid = $_POST["advisorid"];
		
		
		$assign_query = "UPDATE aspects SET advisorid = ".$advisorid." WHERE id = ".$studentid."";
		if(mysqli_query($conn,$assign_query))
		{
			echo "assigned";
			echo 'header("Location: manageAdvising.php")';
		}
		else
		{
			echo "error";
		}
?>
