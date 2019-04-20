
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
    <title>Form 1</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php
	 $idError = 0;
	 $fnameError = 0;
	 $lnameError = 0;
      $courseInt = 0;
      $creditInt = 0;
      $courseBool = 0;
      $hoursBool = 0;
      $courseOutsideBool = 1;
	$csciBool = 1;
      //$alreadyBool = 1;
      $error = "Your Form 1 could not be submitted due to the following error(s): ";
      $deptArray = array(
        $_POST['d1'], $_POST['d2'], $_POST['d3'],
        $_POST['d4'], $_POST['d5'], $_POST['d6'],
        $_POST['d7'], $_POST['d8'], $_POST['d9'],
        $_POST['d10'], $_POST['d11'], $_POST['d12'],
	$_POST['d13'], $_POST['d14'], $_POST['d15']
      );
      $numArray = array(
        $_POST['num1'], $_POST['num2'], $_POST['num3'],
        $_POST['num4'], $_POST['num5'], $_POST['num6'],
        $_POST['num7'], $_POST['num8'], $_POST['num9'],
        $_POST['num10'], $_POST['num11'], $_POST['num12'],
	$_POST['num13'], $_POST['num14'], $_POST['num15']
      );
      
	if($_POST["id"] != $_SESSION["user_id"])
	{
		$idError = 1;
	}
	
	$nameQuery = "SELECT * FROM user WHERE uid = ".$_SESSION['user_id']."";
          $nameResult = mysqli_query($conn, $nameQuery) or die("Bad Query: $query");
          while($row = mysqli_fetch_array($nameResult)){
            $sessionFname = $row['fname'];
            $sessionLname = $row['lname'];
          }
	
	if($_POST["fname"] != $sessionFname)
	{
		$fnameError = 1;
	}
	if($_POST["lname"] != $sessionLname)
	{
		$lnameError = 1;
	}

        // add form data to testing database
        for($x = 0; $x < 15; $x++) {
          $queryInsert = "INSERT INTO formOneValid(id, courseNumber, dept)
            VALUES ('$id', '$numArray[$x]', '$deptArray[$x]')";
          $result = mysqli_query($conn, $queryInsert);
        }
        // delete all null rows from table
        $queryRemoveNull = "DELETE FROM formOneValid WHERE dept = '' OR courseNumber = ''";
        $result8 = mysqli_query($conn, $queryRemoveNull);
	
	
	//see what degree they are
		$degquery = "SELECT * FROM aspects WHERE id =".$id."";
            $degresult = mysqli_query($conn, $degquery);
            if (mysqli_num_rows($degresult) > 0){
		    while ($row = mysqli_fetch_assoc($degresult)) {
		    $degreeType = $row['degreeType'];
		    }
	    }
	
	//ms requirement to check for these three courses
	if ($degreeType == "MS"){
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
	}
	
	
        for($x = 0; $x < 15; $x++){
          $queryCredits = "SELECT credits FROM course
            WHERE dept = '$deptArray[$x]'
              AND cnum = '$numArray[$x]'";
          $result4 = mysqli_query($conn, $queryCredits) or die("Bad Query: $query");
          while($row = mysqli_fetch_array($result4)){
            $creditInt = $creditInt + $row['credits'];
            echo "<p>creditInt = ".$creditInt."</p><br>";
          }
        }
        // check passes if the number of credits is over 30 for MS and 36 for PhD
        if(($creditInt >= 30 && $degreeType == "MS") || ($creditInt >= 36 && $degreeType == "PhD")){
          $hoursBool = 1;
        }
	else{
	  $error .= "You have not submitted enough credits. ";
	}
        // check to see if the number of outside classes is at most 2 for MS
	
	if ($degreeType == "MS"){
        $queryOutside = "SELECT * FROM formOneValid WHERE NOT dept = 'CSCI'";
        $result5 = mysqli_query($conn, $queryOutside);
        // check passes if the number of outside classes is at most 2
        if(mysqli_num_rows($result5) > 2){
          $courseOutsideBool = 0;
	  echo "<p>".mysqli_num_rows($result5)."</p>";
	  $error .= "You have submitted more than 2 classes outside of your major. ";
        }
	}
	
	if ($degreeType == "PhD"){
		$courseBool = 1;
        $csciQuery = "SELECT * FROM formOneValid WHERE dept = 'CSCI'";
        $csciResult = mysqli_query($conn, $csciQuery);
        // check passes if the number of outside classes is at most 2
        if(mysqli_num_rows($csciResult) < 10){
          $csciBool = 0;
	  $error .= "You have not taken enough classes in the CSCI department. ";
        }
	}

	if ($idError == 1 || $fnameError == 1 || $lnameError == 1)
	{
		$error = "Your Form 1 could not be submitted due to the following error(s): ";
		if($idError == 1)
		{
					$error .= "You did not enter the student ID linked to your account. ";

		}
			if($fnameError == 1)
			{
						$error .= "You did not enter the first name linked to your account. ";

			}
		if($lnameError == 1)
		{
					$error .= "You did not enter the last name linked to your account. ";

		}
	}
        // insert the data into form 1 database if all checks pass
        if($courseBool == 1 && $hoursBool == 1 && $courseOutsideBool == 1  && $csciBool == 1 && $idError == 0 && $fnameError == 0 && $lnameError == 0){
          $deleteQuery = "DELETE FROM formOneValid WHERE id = $id";
          $deleteResult = mysqli_query($conn, $deleteQuery);
	  $deleteDuplicateQuery = "DELETE FROM formOne WHERE id = $id";
          $deleteDuplicateResult = mysqli_query($conn, $deleteDuplicateQuery);
          for($x = 0; $x < 15; $x++) {
            if($numArray[$x] != '' && $deptArray[$x] != ''){
              $queryValid = "INSERT INTO formOne(id, courseNumber, dept)
                VALUES ('$id', '$numArray[$x]', '$deptArray[$x]')";
              $result7 = mysqli_query($conn, $queryValid) or die("Bad Query: $queryValid");
            }
          }
	$_SESSION["success"] = "You have successfully entered Form 1!";
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
