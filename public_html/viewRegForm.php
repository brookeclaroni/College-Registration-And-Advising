<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}

if (!in_array("advisor", $_SESSION["user_role"])) {
    header("Location: index.php");
}

$studentid = $_POST["idd"];     
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
    // show courses in reg form
        $query = "select uid, courseNumber, dept from regiform where uid='$studentid'";
        $result = mysqli_query($conn, $query);

        // Generate a table of all courses
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                <tr>
                    <th>Student</th>
                    <th>Department</th>
                    <th>Course Number</th>
                </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["uid"] . "</td>";
                echo "<td>" . $row["dept"] . "</td>";
                echo "<td>" . $row["courseNumber"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "No courses were outlined";
        }
        echo "<form action=\"approveStudentReg.php\" method=\"post\">
        <input type=\"hidden\" name=\"approveSid\" value = \"$studentid\">
        <br>
        <button type=\"submit\">Approve</button></form>";
        ?>
    </div>
</body>

</html> 