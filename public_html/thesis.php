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
	
	echo '
	<div class="main-container">
        <h1>Thesis</h1>';
	
	$approved_query =  "SELECT * FROM user u, aspects a WHERE u.uid = ".$uid." AND u.uid = a.id AND a.approveThesis = 1";
            $approved_result = mysqli_query($conn, $approved_query);
            if (mysqli_num_rows($approved_result) > 0) {
                $status = "approved";
            }
	
	    $pending_query =  "SELECT * FROM user u, aspects a, thesis t WHERE u.uid = ".$uid." AND u.uid = a.id AND t.uid=u.uid AND a.approveThesis = 0";
            $pending_result = mysqli_query($conn, $pending_query);
            if (mysqli_num_rows($pending_result) > 0) {
                $status = "pending";
            }
	
	if($status == "approved")
	{
	echo'
	<form action="viewThesis.php" method="post"> 
	<p> Congratulations!  Your thesis has been approved.</p>
	<button>View</button>
	';
	}
	
	else if($status == "pending")
	{
	echo '
	<form action="viewThesis.php" method="post"> 
	Your thesis has been submitted and is awaiting approval.<br>
	<button>View</button>
	';
	}
	
	else
	{
	echo '
	<form action="viewThesis.php" method="post"> 
	Google Drive link: <input type="text" name="link"><br>
	<button>Submit</button>
	';
	}
    ?>

        

</form>
    </div>
</body>

</html> 
