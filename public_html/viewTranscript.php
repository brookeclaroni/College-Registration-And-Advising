<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}

if (
    !in_array("admin", $_SESSION["user_role"]) &&
    !in_array("gs", $_SESSION["user_role"]) &&
    !in_array("instructor", $_SESSION["user_role"])
) {
    header("Location: index.php");
}

$uid = $_POST["uid"];

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
        <h1>Transcript</h1>
        <?php
    // Show the users currently enrolled courses and their grade if entered
        $query = "SELECT uid, schedule.sid, section, term, day, start, end, grade, course.cid, dept, cnum, title FROM enrolls, schedule, course WHERE schedule.sid=enrolls.sid AND course.cid=schedule.cid AND enrolls.uid=" . $uid . " ORDER BY term";
        $result = mysqli_query($conn, $query);

        // Generate a table of all the enrolled courses
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                <tr>
                    <th>Course</th>
                    <th>Title</th>
                    <th>Section</th>
                    <th>Term</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Grade</th>
                </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href=\"transcriptCourse.php?cid=" . $row["cid"] . "\">" . $row["dept"] . " " . $row["cnum"] . "</a></th>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["section"] . "</td>";
                echo "<td>" . $row["term"] . "</td>";
                echo "<td>" . $row["day"] . "</td>";
                echo "<td>" . $row["start"] . "</td>";
                echo "<td>" . $row["end"] . "</td>";
                if ($row["grade"] !== null) {
                    echo "<td>" . $row["grade"] . "</td>";
                } else {
                    echo "<td>IP</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</body>

</html> 