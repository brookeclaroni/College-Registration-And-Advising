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
        if(in_array("student", $_SESSION["user_role"])){
        $adquery = "select reviewForm from aspects where id='$uid'";
        $adresult = mysqli_query($conn, $adquery);
        if (mysqli_num_rows($adresult) > 0) {
          while ($row = mysqli_fetch_assoc($adresult)) {
            $form = $row["reviewForm"];
          }
        }
        
        if($form == 0){
        echo "<form action=\"regformValidate.php\" method=\"post\">
            Your advisor must approve your form before you may register
            <table>
    <tr>
      <th>Courses In Program:</th>
      <th>DEPT/SUBJECT</th>
      <th>CourseNumber</th>
    </tr>
    <tr>
      <th>1</th>
      <th><input type=\"text\" ID=\"d1\" name=\"d1\" ></th>
      <th><input type=\"text\" ID=\"num1\" name=\"num1\" ></th>
    </tr>
    <tr>
      <th>2</th>
      <th><input type=\"text\" ID=\"d2\" name=\"d2\"></th>
      <th><input type=\"text\" ID=\"num2\" name=\"num2\" ></th>
    </tr>
    <tr>
      <th>3</th>
      <th><input type=\"text\" ID=\"d3\" name=\"d3\" ></th>
      <th><input type=\"text\" ID=\"num3\" name=\"num3\" ></th>
    </tr>
    <tr>
      <th>4</th>
      <th><input type=\"text\" ID=\"d4\" name=\"d4\" ></th>
      <th><input type=\"text\" ID=\"num4\" name=\"num4\" ></th>
    </tr>
    <tr>
      <th>5</th>
      <th><input type=\"text\" ID=\"d5\" name=\"d5\" ></th>
      <th><input type=\"text\" ID=\"num5\" name=\"num5\" ></th>
    </tr>
  </table>
    <br><br>
    <button class=\"button\" style=\"vertical-align:middle\"><span>Submit</span></button>
</form>";
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
      }
      else{
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