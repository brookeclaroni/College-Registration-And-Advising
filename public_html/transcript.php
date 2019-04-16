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
        <h1>Transcript</h1>
        <?php
        // Show the users currently enrolled courses and their grade if entered
        $query = "SELECT uid, schedule.sid, credits, section, term, day, start, end, is_current, grade, course.cid, dept, cnum, title FROM enrolls, schedule, course WHERE schedule.sid=enrolls.sid AND course.cid=schedule.cid AND enrolls.uid=" . $uid . " ORDER BY term";
        $result = mysqli_query($conn, $query);

        $gpa = 0.0;
        $credit_hours = 0;

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
                    <th>Credits</th>
                    <th>Grade</th>
                    <th></th>
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
                echo "<td>" . $row["credits"] . "</td>";
                if ($row["grade"] !== null) {
                    echo "<td>" . $row["grade"] . "</td>";
                    $credits = (int)$row["credits"];
                    $credit_hours += $credits;
                    if(strcmp($row["grade"], "A") == 0){
                        $gpa += 4.0 * $credits;
                    } elseif(strcmp($row["grade"], "A-") == 0){
                        $gpa += 3.70 * $credits;
                    } elseif(strcmp($row["grade"], "B+") == 0){
                        $gpa += 3.30 * $credits;
                    } elseif(strcmp($row["grade"], "B") == 0){
                        $gpa += 3.0 * $credits;
                    } elseif(strcmp($row["grade"], "B-") == 0){
                        $gpa += 2.7 * $credits;
                    } elseif(strcmp($row["grade"], "C+") == 0){
                        $gpa += 2.3 * $credits;
                    } elseif(strcmp($row["grade"], "C") == 0){
                        $gpa += 2.0 * $credits;
                    } elseif(strcmp($row["grade"], "C-") == 0){
                        $gpa += 1.7 * $credits;
                    } elseif(strcmp($row["grade"], "D+") == 0){
                        $gpa += 1.3 * $credits;
                    } elseif(strcmp($row["grade"], "D") == 0){
                        $gpa += 1.0 * $credits;
                    } elseif(strcmp($row["grade"], "D-") == 0){
                        $gpa += 0.70 * $credits;
                    }
                } else {
                    echo "<td>IP</td>";
                }
                // Allow dropping so long as this is a current semester course
                if($row["is_current"] == 1) {
                    echo "<td>
                            <form method=\"post\" action=\"drop.php\">
                                <input type=\"hidden\" name=\"sid\" value=\"" . $row["sid"] . "\">
                                <button class=\"danger-button\" type=\"submit\">Drop</button>
                            </form>
                        </td>";
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            
            // Finalize gpa calcualtion
            if($gpa > 0)
                $gpa /= $credit_hours;
            echo "<h1>Current GPA: " . $gpa . "</h1>";
        }
        ?>
    </div>
</body>

</html> 