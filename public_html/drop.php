<?php
session_start();

if (empty($_SESSION["user_id"])) {
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
    <title>Drop</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="main-container">
        <h3>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $sid = $_POST["sid"];

                // Get the course that the student would like to drop
                $query = "SELECT * FROM schedule WHERE sid=" . $sid;
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    // Check that this is the current semester
                    if($row["is_current"] == 1){
                        // Drop the course
                        $query = "DELETE FROM enrolls WHERE sid=" . $sid . " AND uid=" . $uid;
                        mysqli_query($conn, $query);
                        if (!mysqli_connect_errno()) {
                            echo "Sucessfully dropped";
                        }
                    } else {
                        echo "You cannot drop a course that was taken in a past semester.";
                    }

                } else {
                    echo "This course does not exist.";
                }
            } else {
                echo "This page must be submitted as POST.";
            }
            ?>
        </h3>
    </div>
</body>

</html> 