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
    <title>Course List</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="main-container">
        <h1>Course List</h1>
        <?php
        $adquery = "select reviewForm from aspects where id='$uid'";
        $adresult = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $form = $row["reviewForm"];
          }
        }
        
        if($form == 0){
          echo "Your advisor must approve your form before you may register";
        }
        
        if($form == 1){
        // Get a list of courses
        $query = "SELECT *, fname, lname FROM course LEFT JOIN user ON course.instructor_id=user.uid";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                    <tr>
                        <th>Course</th>
                        <th>Title</th>
                        <th>Instructor</th>
                        <th>Credits</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href=\"course.php?cid=" . $row["cid"] . "\">" . $row["dept"] . " " . $row["cnum"] . "</a></th>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["fname"] . " " . $row["lname"] . "</td>";
                echo "<td>" . $row["credits"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "There are no courses being offered at this time.";
        }
      }
        ?>
    </div>
</body>

</html> 