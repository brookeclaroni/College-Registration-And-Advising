<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
$uid = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<head>
    <title>Student Grades</title>

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

    $courseid = $_POST["cid"];
    $scheduleid = $_POST["sid"];
    ?>

    <div class="main-container">


        <?php
        
        $sem = "select sem from updatesemester where id=1";
        $r = mysqli_query($conn, $sem);
        $s = mysqli_fetch_assoc($r);
        $se = $s["sem"];
        
        echo "<h2>Students: </h2><br/>";
        $query = "select enrolls.uid,fname,lname,grade,type from enrolls,user,role where enrolls.sid='$scheduleid' and enrolls.uid=user.uid and user.uid = role.uid and enrolls.semester = '$se'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>

                        <tr>
                                <th>StudentID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Current Grade</th>
                                <th>Input Grade</th>
                                
                        </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
              if($row["type"] == "student"){
                echo "<tr>";
                echo "<td>" . $row["uid"] . "</td>";
                echo "<td>" . $row["fname"] . "</td>";
                echo "<td>" . $row["lname"] . "</td>";
                if ($row["grade"] == null){
                echo "<td>IP</td>";
                }
                else
                {
                echo "<td>" . $row["grade"] . "</td>";
                }

                if ($row["grade"] == null){ 
                echo "<td> 
                
                                <form method=\"post\" action=\"submitGrade.php\">
                                <input type=\"text\" size=\"5\" name=\"gradeinput\">
                                <input type=\"hidden\" name=\"stid\" value=\"" . $row["uid"] . "\">
                                <input type=\"hidden\" name=\"scid\" value=\"$scheduleid\">
                                <button type=\"submit\">Submit</button>
                                </form>
                        </td>";
                }
                else
                {
                echo "<td></td>";
                }
                        
                echo "</tr>";
              }
            }

            echo "</table>";
        } else {
            echo "There are no students enrolled here";
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html> 