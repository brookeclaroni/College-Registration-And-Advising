
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
    $id = $_POST["id"];    
} else {  
    $id = $_SESSION["user_id"];
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
    <title>Form 1</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php
      $courseInt = 0;
      $creditInt = 0;
      $courseBool = 0;
      $hoursBool = 0;
      $courseOutsideBool = 1;
      //$alreadyBool = 1;
      $error = "Error: ";
      $deptArray = array(
        $_POST['d1'], $_POST['d2'], $_POST['d3'],
        $_POST['d4'], $_POST['d5'], $_POST['d6'],
        $_POST['d7'], $_POST['d8'], $_POST['d9'],
        $_POST['d10'], $_POST['d11'], $_POST['d12']
      );
      $numArray = array(
        $_POST['num1'], $_POST['num2'], $_POST['num3'],
        $_POST['num4'], $_POST['num5'], $_POST['num6'],
        $_POST['num7'], $_POST['num8'], $_POST['num9'],
        $_POST['num10'], $_POST['num11'], $_POST['num12']
      );
      
//       $queryAlready = "SELECT * FROM formOne WHERE id = '$id'";
//       $alreadyResult = mysqli_query($conn, $queryAlready);
//       if(mysqli_num_rows($alreadyResult) > 0){
//         $alreadyBool = 0;
// 	$error .= "You have already submitted a Form 1. ";
//       }
        // add form data to testing database
        for($x = 0; $x < 12; $x++) {
          $queryInsert = "INSERT INTO formOneValid(id, courseNumber, dept)
            VALUES ('$id', '$numArray[$x]', '$deptArray[$x]')";
          $result = mysqli_query($conn, $queryInsert);
        }
        // delete all null rows from table
        $queryRemoveNull = "DELETE FROM formOneValid WHERE dept = '' OR courseNumber = ''";
        $result8 = mysqli_query($conn, $queryRemoveNull);
        // check if user chose CSCI 6212
        $queryCourse1 = "SELECT * FROM formOneValid WHERE dept = 'CSCI' AND courseNumber = '6212'";
        $result1 = mysqli_query($conn, $queryCourse1);
        if(mysqli_num_rows($result1)>0){
          $courseInt++;
        }
        // check if user chose CSCI 6221
        $queryCourse2 = "SELECT * FROM formOneValid WHERE dept = 'CSCI' AND courseNumber = '6221'";
        $result2 = mysqli_query($conn, $queryCourse2);
        if(mysqli_num_rows($result2)>0){
          $courseInt++;
        }
        // check if user chose CSCI 6461
        $queryCourse3 = "SELECT * FROM formOneValid WHERE dept = 'CSCI' AND courseNumber = '6461'";
        $result3 = mysqli_query($conn, $queryCourse3);
        if(mysqli_num_rows($result3)>0){
          $courseInt++;
        }
        // check passes if all three courses are chosen
        if($courseInt == 3){
          $courseBool = 1;
        }
	else{
	  $error .= "You have not submitted all of the required courses: CSCI 6212, CSCI 6221, and CSCI 6461. ";
	}
        for($x = 0; $x < 12; $x++){
          $queryCredits = "SELECT credits FROM course
            WHERE dept = '$deptArray[$x]'
              AND cnum = '$numArray[$x]'";
          $result4 = mysqli_query($conn, $queryCredits) or die("Bad Query: $query");
          while($row = mysqli_fetch_array($result4)){
            $creditInt = $creditInt + $row['credits'];
            echo "<p>creditInt = ".$creditInt."</p><br>";
          }
        }
        // check passes if the number of credits is over 30
        if($creditInt >= 30){
          $hoursBool = 1;
        }
	else{
	  $error .= "You have not submitted 30 credits. ";
	}
        // check to see if the number of outside classes is at most 2
        $queryOutside = "SELECT * FROM formOneValid WHERE NOT dept = 'CSCI'";
        $result5 = mysqli_query($conn, $queryOutside);
        // check passes if the number of outside classes is at most 2
        if(mysqli_num_rows($result5) > 2){
          $courseOutsideBool = 0;
	  echo "<p>".mysqli_num_rows($result5)."</p>";
	  $error .= "You have submitted more than 2 classes outside of your major. ";
        }
        echo "<p>courseBool = ".$courseBool."</p><br>";
        echo "<p>hoursBool = ".$hoursBool."</p><br>";
        echo "<p>courseOutsideBool = ".$courseOutsideBool."</p><br>";
        //echo "<p>alreadyBool = ".$alreadyBool."</p>";
	echo "<p>".$error."</p>";
        // insert the data into form 1 database if all checks pass
        if($courseBool == 1 && $hoursBool == 1 && $courseOutsideBool == 1){
          $deleteQuery = "DELETE FROM formOneValid WHERE id = $id";
          $deleteResult = mysqli_query($conn, $deleteQuery);
	  $deleteDuplicateQuery = "DELETE FROM formOne WHERE id = $id";
          $deleteDuplicateResult = mysqli_query($conn, $deleteDuplicateQuery);
          for($x = 0; $x < 12; $x++) {
            if($numArray[$x] != '' && $deptArray[$x] != ''){
              $queryValid = "INSERT INTO formOne(id, courseNumber, dept)
                VALUES ('$id', '$numArray[$x]', '$deptArray[$x]')";
              $result7 = mysqli_query($conn, $queryValid) or die("Bad Query: $queryValid");
            }
          }
          header("Location: viewForm1.php");
        }
	
        else{
	  $queryDeleteTest = "DELETE FROM formOneValid WHERE id = '$id'";
          $resultDeleteTest = mysqli_query($conn, $queryDeleteTest);
	  session_start();
	  $_SESSION["error"] = $error;
          header("Location: form1.php");
          exit();
        }
	
      mysqli_close($conn);
    ?>
      </div>
</body>
</html> 
