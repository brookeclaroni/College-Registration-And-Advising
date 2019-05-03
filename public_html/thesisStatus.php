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
       
            echo "<h1>Students awaiting thesis approval</h1>";
    echo '<br>';
            $submitted_query =  "SELECT * FROM thesis t, user u, aspects a WHERE u.uid = a.id AND t.uid = u.uid AND a.approveThesis = 0";
            $submitted_result = mysqli_query($conn, $submitted_query);
            if (mysqli_num_rows($submitted_result) > 0) {
                echo "<table>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Thesis</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($submitted_result)) {
			$id = $row["uid"];
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>";
                    echo '<form action="viewThesis.php" method="post"><input type="hidden" name="uid" value = "'.$row["uid"].'"><button type="submit">View</button></form>';
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
	  else{
		  echo "There are no students who are awaiting thesis approval.";
	  }
	
        
        ?>
    </div>
</body>

</html> 


