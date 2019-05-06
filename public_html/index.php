<?php
session_start();

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
    <title>Home</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <form action="reset.php" method="post" class="reset-button">
        <button type="submit" style="display: block; margin: 0 auto;">Reset</button>
    </form>
    <div class="main-container">
        <img style="width:1000px;height:600px" src="img/harmonandbrooke.jpg">
    </div>

</body>

</html> 
