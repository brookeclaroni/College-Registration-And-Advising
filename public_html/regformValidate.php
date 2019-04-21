<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
$uid = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<head>
    <title>Enter Reg Form</title>

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
        
        $query = "select uid from regiform where uid='$uid'";
        $result = mysqli_query($conn,$query);
        if (mysqli_num_rows($result) > 0) {
            $delquery = "DELETE FROM regiform WHERE uid='$uid'";
            mysqli_query($conn, $query);
        }
        
        
        $d1 = $_POST["d1"];
        $d2 = $_POST["d2"];
        $d3 = $_POST["d3"];
        $d4 = $_POST["d4"];
        $d5 = $_POST["d5"];
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $num3 = $_POST["num3"];
        $num4 = $_POST["num4"];
        $num5 = $_POST["num5"];


            if($d1!="" && $num1!="")
            {
              $query = "insert into regiform values('$uid', '$num1', '$d1')";
              mysqli_query($conn,$query);
            }
            if($d2!="" && $num2!="")
            {
              $query = "insert into regiform values('$uid', '$num2', '$d2')";
              mysqli_query($conn,$query);
            }
            if($d3!="" && $num3!="")
            {
              $query = "insert into regiform values('$uid', '$num3', '$d3')";
              mysqli_query($conn,$query);
            }
            if($d4!="" && $num4!="")
            {
              $query = "insert into regiform values('$uid', '$num4', '$d4')";
              mysqli_query($conn,$query);
            }
            if($d5!="" && $num5!="")
            {
              $query = "insert into regiform values('$uid', '$num5', '$d5')";
              mysqli_query($conn,$query);
            }

        mysqli_close($conn);
        header("Location: index.php");
        ?>
    </div>
</body>

</html> 