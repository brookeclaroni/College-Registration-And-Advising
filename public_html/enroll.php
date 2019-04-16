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
    <title>Enroll</title>

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
                /* Make sure this course does not conflict with 
            any other currently enrolled courses */

                // Time allowed between classes in seconds
                $time_buffer = 1800;  // = 30 minutes
                $sid = $_POST["sid"];

                // Get the schedule that the student would like to enroll for
                $query = "SELECT * FROM schedule WHERE sid=" . $sid;
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    // Get the day, start, and end time of the requested course
                    $cid = $row["cid"];
                    $day = $row["day"];
                    $term = $row["term"];
                    $start_time = strtotime($row["start"]);
                    $end_time = strtotime($row["end"]);

                    // Variable to check for a conflict
                    $conflict = "";

                    // Check if student meets the prerequisites
                    $query = "SELECT prereq1_id, prereq2_id FROM course WHERE cid=" . $cid;
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        if ($row["prereq1_id"] !== null) {
                            // Check if user is enrolled in this course
                            $query = "SELECT * FROM enrolls, schedule WHERE enrolls.sid=schedule.sid AND enrolls.uid=" . $uid . " AND schedule.cid=" . $row["prereq1_id"] . " AND grade IS NOT NULL";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) == 0) {
                                $conflict = "You do not meet the prerequisites to enroll for this course.";
                            }
                        }
                        if ($row["prereq2_id"] !== null) {
                            // Check if user is enrolled in this course
                            $query = "SELECT * FROM enrolls, schedule WHERE enrolls.sid=schedule.sid AND enrolls.uid=" . $uid . " AND schedule.cid=" . $row["prereq2_id"] . " AND grade IS NOT NULL";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) == 0) {
                                $conflict = "You do not meet the prerequisites to enroll for this course.";
                            }
                        }
                    }

                    // If prereqs are met, check for time conflicts
                    if (empty($conflict)) {
                        // Get all of the users currently enrolled courses
                        $query = "SELECT uid, schedule.sid, term, day, start, end, course.cid, dept, cnum FROM enrolls, schedule, course WHERE schedule.sid=enrolls.sid AND course.cid=schedule.cid AND enrolls.uid=" . $uid;
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            // Check each enrolled course for a time conflict
                            while ($row = mysqli_fetch_assoc($result)) {
                                $this_day = $row["day"];
                                $this_term = $row["term"];
                                $this_start_time = strtotime($row["start"]);
                                $this_end_time = strtotime($row["end"]);

                                // Check for same day
                                if (strcmp($day, $this_day) == 0 && strcmp($term, $this_term) == 0) {
                                    // Check for overlap
                                    if (
                                        ($start_time >= $this_start_time && $start_time <= $this_end_time)
                                        || ($end_time >= $this_start_time && $end_time <= $this_end_time)
                                    ) {
                                        $conflict = "This course conflicts with " . $row["dept"] . " "  . $row["cnum"];
                                    } else {
                                        // Check for 30 minute window before and after class
                                        if (
                                            ($start_time >= $this_end_time && ($start_time - $this_end_time < $time_buffer))
                                            || ($end_time <= $this_start_time && ($this_start_time - $end_time < $time_buffer))
                                        ) {
                                            $conflict = "This course is scheduled too close to " . $row["dept"] . " "  . $row["cnum"] . ".  There must be 30 minutes in between courses.";
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // If no conflict, enroll the student in this course
                    if (empty($conflict)) {
                        $query = "INSERT INTO enrolls VALUES (" . $uid . ", " . $sid . ", NULL)";
                        mysqli_query($conn, $query);
                        if (!mysqli_connect_errno()) {
                            echo "Sucessfully enrolled";
                        }
                    } else {
                        echo $conflict;
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
