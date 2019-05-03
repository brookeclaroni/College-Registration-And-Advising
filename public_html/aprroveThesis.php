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
$uid = $_POST["uid"];
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
				
		$approve_query = "UPDATE aspects SET aprroveThesis = 1 WHERE id = ".$uid."";
		if(mysqli_query($conn,$approve_query))
		{
			header('Location: thesisStatus.php');
		}
		else
		{
			echo "error";
		}
?>
