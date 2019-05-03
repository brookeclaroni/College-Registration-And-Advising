<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
else if (!in_array("student", $_SESSION["user_role"]))
{
  header("Location: index.php");
}
$uid = $_SESSION["user_id"];
$link = $_POST["link"];
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
?>

<!DOCTYPE html>

<head>
    <title>Thesis</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    echo '<div class="main-container">';
    echo '<h1>Thesis</h1>';
    

    if (isset($_POST['link']))
    {
    $pdfQuery = "INSERT INTO thesis (uid, link) VALUES( '$uid', '$link' )";
    if(mysqli_query($conn,$pdfQuery))
		{
			echo "Your thesis was successfully submitted!";
		}
	
    }
	
	$viewQuery="SELECT * FROM thesis WHERE uid = '$uid'";
	$viewResult=mysqli_query($conn,$viewQuery);
	while ($row = mysqli_fetch_assoc($viewResult)) {
		
		echo '<a href="';
		echo $row['link'];
		echo '" target="_blank">View in a separate tab</a>';
		$pdflink = $row['link'];
		echo '<iframe src="'.$pdflink.'" width="640" height="480"></iframe>';
	}
	
        ?>
   	
       
    </div>
</body>

</html> 
