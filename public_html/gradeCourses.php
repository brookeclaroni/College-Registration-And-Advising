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
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>

<!DOCTYPE html>

<head>
    <title>Grades</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
  <?php
  include "navbar.php";
  ?>
    <div class="main-container">

        <?php
        if (in_array("student", $_SESSION["user_role"]))
        {
        echo "<h2>Your Grades: </h2><br/>";
        $query = "select course.dept,course.cnum,course.title,enrolls.grade from course,enrolls,schedule where enrolls.uid='$uid' and enrolls.sid=schedule.sid and schedule.cid=course.cid and schedule.is_current=1";
        $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
            echo "<table>

                        <tr>
                                <th>Dept</th>
                                <th>Num</th>
                                <th>Title</th>
                                <th>Grade</th>
                        </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                //echo "<td>" . $row["cid"] . "</td>";
                echo "<td>" . $row["dept"] . "</td>";
                echo "<td>" . $row["cnum"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                if ($row["grade"] == null){
                echo "<td>IP</td>";
                }
                else{
                echo "<td>" . $row["grade"] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "You have no grades";
        }
        }
        
        if (in_array("instructor", $_SESSION["user_role"]))
        {
        echo "<h2>Your Courses: </h2><br/>";
        $query = "select c.cid,c.dept,c.cnum,c.title,s.sid from course c, schedule s where c.instructor_id='$uid' and s.cid=c.cid and s.is_current=1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>

                        <tr>
                                <th>Dept</th>
                                <th>Num</th>
                                <th>Title</th>
                                <th></th>
                        </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                //echo "<td>" . $row["cid"] . "</td>";
                echo "<td>" . $row["dept"] . "</td>";
                echo "<td>" . $row["cnum"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td> 
                                <form method=\"post\" action=\"gradeUsers.php\">
                                <input type=\"hidden\" name=\"cid\" value=\"" . $row["cid"] . "\">
                                <input type=\"hidden\" name=\"sid\" value=\"" . $row["sid"] . "\">
                                <button type=\"submit\">View</button>
                                </form>
                        </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "You teach no courses";
        }
        }
        mysqli_close($conn);
        ?>
    </div>
</body>

</html> 