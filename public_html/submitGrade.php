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
        
        
            $grade = $_POST["gradeinput"];
            $suid = $_POST["stid"];
            $scheduleid = $_POST["scid"];
            
            echo "'$grade' '$suid' '$scheduleid'";

            if($grade == "A" || $grade == "A-" || $grade == "B+" || $grade == "B" || $grade == "B-" || $grade == "C+" || $grade == "C" || $grade == "F")
            {
              $query = "update enrolls set grade = '$grade' where uid = '$suid' and sid = '$scheduleid'";
              mysqli_query($conn,$query);
            }

        mysqli_close($conn);
        header("Location: gradeCourses.php");
        ?>
    </div>
</body>

</html> 