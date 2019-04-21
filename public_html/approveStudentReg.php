<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
$uid = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<head>
    <title>GradeInput</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php

$servername = "127.0.0.1";
$username = "harmonandbrooke";
$password = "DBteam18!";
$dbname = "harmonandbrooke";
    
    include "navbar.php";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    ?>

    <div class="main-container">
        <?php
        
        $student = $_POST["approveSid"];
        
        echo "'$student'";

        $query = "update aspects set reviewForm = 1 where id = '$student'";
        mysqli_query($conn,$query);

        mysqli_close($conn);
        header("Location: approveRegForms.php");
        ?>
    </div>
</body>

</html> 