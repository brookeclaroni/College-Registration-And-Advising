<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
$id = $_SESSION["user_id"];
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
    <title>Apply to Graduate</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    session_start();
    include "navbar.php";
    echo '<div class="main-container">';
    echo '<h1>Apply to Graduate</h1>';
    echo "<p style='color:#008000'>";
    echo $_SESSION["gradSuccess"];
    echo "</p>";
    echo "<p style='color:#FF0000'>";
    echo $_SESSION["gradFailure"];
    echo "</p>";
    $_SESSION["gradSuccess"] = "";
    $_SESSION["gradFailure"] = "";
    echo '<br>';
    ?>
   
        
      <form action="graduateValidate.php" method="post">
        Student Number:<input type="text" name="id" required ><br><br>
        Degree Type:<br>
        <input type="radio" name="degree" value="masters">Masters<br>
        <input type="radio" name="degree" value="phd">PhD<br>
         <br>
        <button class="button" style="vertical-align:middle"><span>Apply</span></button>
  </form>
    </div>
</body>

</html> 

