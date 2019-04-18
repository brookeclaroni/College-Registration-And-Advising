<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
if (
    !in_array("student", $_SESSION["user_role"])
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

echo $_SESSION["error"];
?>

<!DOCTYPE html>

<head>
    <title>Form 1</title>

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
    <form action="form1.php" method="post">Please enter the courses you plan to take to earn your MS degree in Computer Science. You
may enter at most 12 courses, and your Form 1 must meet the degree requirements.<br><br>
  <table>
    <tr>
      <th>Univ ID</th>
      <th>Last Name</th>
      <th>First Name</th>
    </tr>
    <tr>
      <th><input type="text" ID="id" name="id" required></th>
      <th><input type="text" ID="lname" name="lname" required ></th>
      <th><input type="text" ID="fname" name="fname" required ></th>
    </tr>
    <tr>
      <th>Courses In Program:</th>
      <th>DEPT/SUBJECT</th>
      <th>CourseNumber</th>
    </tr>
    <tr>
      <th>1</th>
      <th><input type="text" ID="d1" name="d1" ></th>
      <th><input type="text" ID="num1" name="num1" ></th>
    </tr>
    <tr>
      <th>2</th>
      <th><input type="text" ID="d2" name="d2"></th>
      <th><input type="text" ID="num2" name="num2" ></th>
    </tr>
    <tr>
      <th>3</th>
      <th><input type="text" ID="d3" name="d3" ></th>
      <th><input type="text" ID="num3" name="num3" ></th>
    </tr>
    <tr>
      <th>4</th>
      <th><input type="text" ID="d4" name="d4" ></th>
      <th><input type="text" ID="num4" name="num4" ></th>
    </tr>
    <tr>
      <th>5</th>
      <th><input type="text" ID="d5" name="d5" ></th>
      <th><input type="text" ID="num5" name="num5" ></th>
    </tr>
    <tr>
      <th>6</th>
      <th><input type="text" ID="d6" name="d6" ></th>
      <th><input type="text" ID="num6" name="num6" ></th>
    </tr>
    <tr>
      <th>7</th>
      <th><input type="text" ID="d7" name="d7" ></th>
      <th><input type="text" ID="num7" name="num7" ></th>
    </tr>
    <tr>
      <th>8</th>
      <th><input type="text" ID="d8" name="d8" ></th>
      <th><input type="text" ID="num8" name="num8" ></th>
    </tr>
    <tr>
      <th>9</th>
      <th><input type="text" ID="d9" name="d9" ></th>
      <th><input type="text" ID="num9" name="num9" ></th>
    </tr>
    <tr>
      <th>10</th>
      <th><input type="text" ID="d10" name="d10" ></th>
      <th><input type="text" ID="num10" name="num10" ></th>
    </tr>
    <tr>
      <th>11</th>
      <th><input type="text" ID="d11" name="d11" ></th>
      <th><input type="text" ID="num11" name="num11"></th>
    </tr>
    <tr>
      <th>12</th>
      <th><input type="text" ID="d12" name="d12" ></th>
      <th><input type="text" ID="num12" name="num12" ></th>
    </tr>
  </table>
    <br><br>
    <button class="button" style="vertical-align:middle"><span>Submit</span></button>
</form>
    </div>
</body>

</html> 

