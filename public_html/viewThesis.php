<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
else if (!in_array("student", $_SESSION["user_role"]))
{
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
    <title>Thesis</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    echo '<div class="main-container">';
    echo '<h1>Thesis</h1>';
    
//     $allowedExts = array("pdf");
//     $temp = explode(".", $_FILES["pdf_file"]["name"]);
//     $extension = end($temp);
//     $upload_pdf=$_FILES["pdf_file"]["name"];
//     move_uploaded_file($_FILES["pdf_file"]["tmp_name"],"uploads/pdf/" . $_FILES["pdf_file"]["name"]);
//     $sql=mysqli_query($con,"INSERT INTO thesis (uid, pdf)VALUES('$uid', '$upload_pdf')");
    
    
    $filePointer = fopen($_FILES['pdf_file']['name'], 'r');
    $fileData = fread($filePointer, filesize($_FILES['pdf_file']['name']));
    $fileData = addslashes($fileData);
    $pdfQuery = "INSERT INTO thesis (uid, data) VALUES( '$uid', '$fileData' )";
    if(mysqli_query($conn,$pdfQuery))
		{
			echo "Your thesis was successfully uploaded!";
		}
		else
		{
			echo "There was an issue with uploading your thesis.";
		}
	
	
	
	$sqll="select * from thesis";
	$query=mysql_query($sqll) or die(mysql_error());
	$result=mysql_fetch_array($query);
	$content=$result['pdf'];
	echo '<object data="data:application/pdf;base64,<?php echo base64_encode(content) ?>" type="application/pdf" style="height:200px;width:60%"></object>';
	
    ?>
   
       
    </div>
</body>

</html> 
