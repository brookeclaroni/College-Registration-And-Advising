<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
if (
    !in_array("gs", $_SESSION["user_role"])
) {
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
function trim_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>

<head>
    <title>Graduate Students</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    
    echo '<div class="main-container">';
       
            echo "<h1>Students Cleared for Graduation</h1>";
	echo "<p style='color:#008000'>";
    echo $_SESSION["processGradSuccess"];
    echo "</p>";
    echo "<p style='color:#FF0000'>";
    echo $_SESSION["processGradFailure"];
    echo "</p>";
    $_SESSION["processGradSuccess"] = "";
    $_SESSION["processGradFailure"] = "";
    echo '<br>';
            $cleared_query =  "SELECT * FROM role r, user u, aspects a WHERE r.uid = u.uid AND u.uid = a.id AND r.type = 'student' AND a.clearedToGrad = 1";
            $cleared_result = mysqli_query($conn, $cleared_query);
            if (mysqli_num_rows($cleared_result) > 0) {
                echo "<table>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Account Balance</th>
                        <th>Transcript</th>
                        <th>Action</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($cleared_result)) {
			$id = $row["uid"];
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["balance"] . "</td>";
                    echo "<td>";
                    echo '<form action="transcript.php" method="post"><input type="hidden" name="id" value = "'.$row["uid"].'"><button type="submit">View</button></form>';
                    echo "</td>";
			echo "<td>";
     echo '<form action="graduate.php" method="post"><input type="hidden" name="id" value = "'.$row["uid"].'"><button type="submit">Graduate</button></form>';
			echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
	  else{
		  echo "There are no students who are currently cleared to graduate.";
	  }
	
	 echo "<h1>Graduated Students</h1>";
            $query =  "SELECT * FROM role r, user u, aspects a WHERE a.id =u.uid AND r.uid = u.uid AND r.type = 'alumni'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Degree Type</th>
                        <th>Year Received</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
			echo "<td>" . $row["degreeType"] . "</td>";
			echo "<td>" . $row["gradYear"] . "</td>";
			
                    echo "</tr>";
                }
                echo "</table>";
            }
	 else{
		  echo "No students have graduated yet.";
	  }
        
        ?>
    </div>
</body>

</html> 

