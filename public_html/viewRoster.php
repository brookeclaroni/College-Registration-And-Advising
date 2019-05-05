<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
$uid = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<head>
    <title>View Roster</title>

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
        
        $sem = "select sem from updatesemester where id=1";
        $r = mysqli_query($conn, $sem);
        $s = mysqli_fetch_assoc($r);
        $se = $s["sem"];
        
        
        $schedulenum = $_POST["vscheduleid"];
        
            echo "<h1>Roster List</h1>";
            $query = "SELECT e.sid, u.uid, u.fname, u.lname, e.grade FROM enrolls e, user u where e.sid = '$schedulenum' and u.uid = e.uid and e.semester = '$se'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Grade</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["sid"] . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    if ($row["grade"] == null) {
                      echo "<td>IP</td>";
                    }
                    else {
                      echo "<td>" . $row["grade"] . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
              echo "No one is in this section";
            }


        mysqli_close($conn);
        //header("Location: gradeCourses.php");
        ?>
    </div>
</body>

</html> 