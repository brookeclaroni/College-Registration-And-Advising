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
    <title>Apply to Graduate</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php
      $id = $_SESSION['user_id'];
      $deptArray = array();
      $numArray = array();
      $gradeArray = array();
      $creditArray = array();
      $creditError=0;
      $gpaError=0;
      $form1Error=0;
      $failMsg= "Your application for graduation could not be submitted due to the following error(s): ";
      // Check connection
      if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
      }
    
    		$idError = 0;
    	if($_POST["id"] != $_SESSION["user_id"])
	{
		$failMsg .= "You did not enter the student ID linked to your account. ";
		$idError = 1;
	}
    
     $degreeType = "";
    $degreeTypeError = 0;
	$degquery = "SELECT * FROM aspects WHERE id =".$id."";
            $degresult = mysqli_query($conn, $degquery);
            if (mysqli_num_rows($degresult) > 0){
		    while ($row = mysqli_fetch_assoc($degresult)) {
		    $degreeType = $row['degreeType'];
		    }
	    }
     
    if($_POST["degree"] != $degreeType)
	{
		$failMsg .= "You did not select the degree type linked to your account. ";
		$degreeTypeError = 1;
	}
    
    
    
      // check if classes taken are equivalent to form1
      $x = 0;
      $query = "SELECT * FROM formOne WHERE id = '$id'";
      $result = mysqli_query($conn, $query) or die("Bad Query: $query");
      while($row = mysqli_fetch_array($result)) {
          $deptArray[$x] = $row['dept'];
          $numArray[$x] = $row['courseNumber'];
          $x++;
      }
      $numformOne = mysqli_num_rows($result);
      $y = 0;
      $queryTaken = "SELECT * FROM enrolls e, schedule s, course c WHERE e.uid = '$id' AND e.sid=s.sid AND s.cid = c.cid";
      $resultTaken = mysqli_query($conn, $queryTaken) or die("Bad Query: $queryTaken");
      while($row = mysqli_fetch_array($resultTaken)){
        $deptTaken[$y] = $row['dept'];
        $numTaken[$y] = $row['cnum'];
          if($row['grade']!="" && $row['grade']!="IP")
          {
          $gradeArray[$y] = $row['grade'];
          $creditArray[$y] = $row['credits'];
          }
        $y++;
      }
      sort($deptArray);
      sort($numArray);
      sort($deptTaken);
      sort($numTaken);
      if($deptArray == $deptTaken && $numArray == $numTaken){
        $form1Error = 0;
      }
      else{
          $form1Error = 1;
      }

      $creditCount = 0;
      for($x = 0; $x < $y; $x++){
        $creditCount = $creditCount + $creditArray[$x];
      }
        $failCounter = 0;
        $totalGPA = 0.0;
        $error = 0;
        for($x = 0; $x < $y; $x++){
          if($gradeArray[$x] != "A" && $gradeArray[$x] != "A-" && $gradeArray[$x] != "B+" && $gradeArray[$x] != "B" && $gradeArray[$x] != "IP" && $gradeArray[$x] != ""){
            $failCounter++;
          }
          if($gradeArray[$x] == "A"){
            $totalGPA = $totalGPA + (4.0 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "A-"){
            $totalGPA = $totalGPA + (3.7 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "B+"){
            $totalGPA = $totalGPA + (3.3 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "B"){
            $totalGPA = $totalGPA + (3.0 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "B-"){
            $totalGPA = $totalGPA + (2.7 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "C+"){
            $totalGPA = $totalGPA + (2.3 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "C"){
            $totalGPA = $totalGPA + (2.0 * $creditArray[$x]);
          }
          if($gradeArray[$x] == "IP" || $gradeArray[$x] == ""){
            $ipError = 1;
          }
        }
    
            $numClasses = 0;
        $query3 = "SELECT * FROM enrolls WHERE uid = '$id'";
        $result3 = mysqli_query($conn, $query3) or die("Bad Query: $query3");
        $numClasses = mysqli_num_rows($result3);
        $totalGPA = $totalGPA / $creditCount;
       
        if($form1Error == 1)
        {
            $failMsg .= "You did not complete the courses you listed on Form 1. ";
        }
    if($failCounter > 2)
        {
        $failError == 1;
        $failMsg .= "You received more than two grades below a B. ";
        }
    if($totalGPA < 3.0)
        {
        $gpaError == 1;
        $failMsg .= "Your GPA is too low. ";
        }
    if($ipError == 1)
        {
        $failMsg .= "You still have courses in progress. ";
        }
    
        if($ipError != 1 && $gpaError!= 1 && $failError != 1 && $form1Error != 1 && $idError != 1 && $degreeTypeError != 1){
          $query4 = "UPDATE aspects SET clearedToGrad = 1 WHERE uid = '$id'";
          $result4 = mysqli_query($conn, $query4) or die("Bad Query: $query4");
             $deleteQuery = "DELETE FROM formOne WHERE id = $id";
          $deleteResult = mysqli_query($conn, $deleteQuery);
            $_SESSION["gradSuccess"] = "Your application for graduation has been submitted and will be reiewed by a graduate secretary soon.";
          header("Location: applyToGraduate.php");
        }
        else{
            $_SESSION["gradFailure"] = $failMsg;
          header("Location: applyToGraduate.php");
        }
      //close connection
        mysqli_close($conn);
    ?>
      </div>
</body>
</html> 
