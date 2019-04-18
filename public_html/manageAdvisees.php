<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
if (
    !in_array("advisor", $_SESSION["user_role"])
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
    <title>Manage Advisees</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    
    echo '<div class="main-container">';
            echo "<h1>Advisee List</h1>";
            $query = "SELECT * FROM user u, aspects a WHERE u.uid = a.id AND a.advisorid =".$uid."";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>User Name</th>
                        <th>User ID</th>
                        <th>Address</th>
                        <th>Transcript</th>
                        <th>Form 1</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>";
                    echo '<form action="transcript.php" method="post"><input type="hidden" name="id" value = "'.$id.'"><button type="submit">View</button></form>';
                    echo "</td>";
                    echo "<td>View</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        
        ?>
    </div>
</body>

</html> 
