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
    ?>
    <div class="main-container">
        <h1>Thesis</h1>
        
        <form action="viewThesis.php" method="post" role="form" enctype="multipart/form-data"> 
	<input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" />
	<button id="send" type="submit" name="submit" class="btn btn-success">Submit</button>
</form>
    </div>
</body>

</html> 
