<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}

if (
    !in_array("registrar", $_SESSION["user_role"])
) {
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

function trim_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>

<head>
    <title>Manage Page</title>

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
        echo "<h1>Schedule List</h1>";
            $query = "SELECT * FROM schedule INNER JOIN course ON schedule.cid = course.cid ORDER BY schedule.sid";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Course Title</th>
                        <th>Course ID</th>
                        <th>Section</th>
                        <th>Term</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["sid"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["cid"] . "</td>";
                    echo "<td>" . $row["section"] . "</td>";
                    echo "<td>" . $row["term"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            echo "<h1>Edit Schedule</h1>";
            echo "Enter Schedule ID in every field to remove it from the list <br>";
            echo " <br>";
            echo "<form method=\"post\">";
            echo "Course ID: <br>";
            echo "<input type=\"text\" name=\"courseid\" id=\"courseid\">";
            echo "Section: <br>";
            echo "<input type=\"text\" name=\"section\" id=\"section\">";
            echo "Term (f - - or sp - -): <br>";
            echo "<input type=\"text\" name=\"term\" id=\"term\">";
            echo "Day (M, T, W, R, or F): <br>";
            echo "<input type=\"text\" name=\"day\" id=\"day\">";
            echo "Start Time (xx:xx:00): <br>";
            echo "<input type=\"text\" name=\"stime\" id=\"stime\">";
            echo "End Time (xx:xx:00): <br>";
            echo "<input type=\"text\" name=\"etime\" id=\"etime\">";
            echo "<button type=\"submit\">Add / Remove</button>";
            echo "</form>";
            
            echo "<h1>Course List</h1>";
            $query = "SELECT c.cid, c.dept, c.cnum, c.title, c.credits, u.fname, u.lname FROM course c, user u where c.instructor_id = u.uid";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>CID</th>
                        <th>Dept</th>
                        <th>Course Number</th>
                        <th>Title</th>
                        <th>Credits</th>
                        <th>Instructor</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["cid"] . "</td>";
                    echo "<td>" . $row["dept"] . "</td>";
                    echo "<td>" . $row["cnum"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["credits"] . "</td>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            
            
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["courseid"]) && !empty($_POST["section"]) && !empty($_POST["term"]) && !empty($_POST["day"]) && !empty($_POST["stime"]) && !empty($_POST["etime"])) {
            $courseid = trim_input($_POST["courseid"]);
            $section = trim_input($_POST["section"]);
            $term = trim_input($_POST["term"]);
            $day = trim_input($_POST["day"]);
            $stime = trim_input($_POST["stime"]);
            $etime = trim_input($_POST["etime"]);

              if($courseid == $section && $courseid == $term && $courseid == $day && $courseid == $stime && $courseid == $etime){
              $sql = "delete from schedule where sid = '$courseid'";
                if (mysqli_query($conn, $sql)) {
                  $message = "Schedule Removed";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  header("refresh:3;url=editschedule.php");
                } else {
                  $message = "Failed to Remove Schedule";
                  $mess = "Error deleting record: " . mysqli_error($conn);
                  echo "<script type='text/javascript'>alert('$mess');</script>";
                  die();
                }
              }
              else {
                $sql = "insert into schedule(cid, section, term, day, start, end, is_current) values('$courseid', '$section', '$term', '$day', '$stime', '$etime', 1)";
                if (mysqli_query($conn, $sql)) {
                  $message = "Schedule Added";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  header("refresh:3;url=editschedule.php");
                } else {
                  $message = "Failed to Add Schedule";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  die();
                }
              }
        }       
        
        ?>
    </div>
</body>

</html> 
