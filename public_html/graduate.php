    
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
   
   $sem = "select sem from updatesemester where id=1";
   $r = mysqli_query($conn, $sem);
   $s = mysqli_fetch_assoc($r);
   $se = $s["sem"];
		
   $qu = "UPDATE aspects SET gradYear = '$se' WHERE id = ".$studentid."";
	 mysqli_query($conn,$qu);
   
		
		$assign_query = "UPDATE role SET type = 'alumni' WHERE uid = ".$studentid."";
		if(mysqli_query($conn,$assign_query))
		{
			$_SESSION["processGradSuccess"] = "You have successfully proccessed the graduation of student number: ";
			$_SESSION["processGradSuccess"] .= $studentid;
			header('Location: clearedToGrad.php');
		}
		else
		{
			$_SESSION["processGradFailure"] = "There was an error proccessing the graduation of student number: ";
			$_SESSION["processGradFailure"] .= $studentid;
			header('Location: clearedToGrad.php');
		}
?>
