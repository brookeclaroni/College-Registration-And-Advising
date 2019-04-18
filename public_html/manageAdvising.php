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
    <title>Advising</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    
    echo '<div class="main-container">';
       
            echo "<h1>Students without an Adivisor</h1>";
            $query =  "SELECT * FROM role r, user u, aspects a WHERE r.uid = u.uid AND u.uid = a.id AND r.type = 'student' AND a.advisorid IS NULL";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>User Name</th>
                        <th>User ID</th>
                        <th>Select Advisor</th>
                        <th>Action</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>";
                        	echo '<form action="assignAdvisor.php" method="post">';
				            echo '<select name="advisorid">';
					        $advisor_query = "SELECT * FROM role r, user u WHERE r.uid = u.uid AND r.type = 'advisor'";
					        $advisor_result = mysqli_query($conn,$advisor_query);
					        if (mysqli_num_rows($advisor_result) > 0)
					        {
						        while ($row = mysqli_fetch_assoc($advisor_result))
						        {
							        $advisor_id = $row["uid"];
							        $advisor_fname = $row["fname"];
							        $advisor_lname = $row["lname"];
  							        echo '<option value="'.$advisor_id.'">'.$advisor_fname.' '.$advisor_lname.'</option>';
						        }
					        }
				            echo '</select>';
                            
                    echo "</td>";
			echo "<td>";
				echo '<input type="hidden" name="id" value = "'.$id.'">';
    				echo '<button type="submit">Assign</button>';
			echo '</form>';
			echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        
        ?>
    </div>
</body>

</html> 
