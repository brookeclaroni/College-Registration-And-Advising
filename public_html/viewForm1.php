<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
if (
    !in_array("advisor", $_SESSION["user_role"]) &&  !in_array("student", $_SESSION["user_role"])
) {
    header("Location: index.php");
}
if (!empty($_POST["id"])) {
    $uid = $_POST["id"];    
} else {  
    $uid = $_SESSION["user_id"];
}
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
        <h1>Form 1</h1>
        <?php
    // Show only form 1 inputs from the student selected
        $query = "SELECT * FROM formOne f, course c WHERE f.id=" . $uid . " AND f.dept = c.dept AND f.courseNumber = c.cnum";
        $result = mysqli_query($conn, $query);
        // Generate a table of all the classes listed in form 1
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                <tr>
                    <th>Course</th>
                    <th>Title</th>
                </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["dept"] . " " . $row["courseNumber"] . "</th>";
                echo "<td>" . $row["title"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "Form 1 has not been submitted.";
        }
        ?>
    </div>
</body>

</html> 
