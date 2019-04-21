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
?>

<!DOCTYPE html>

<head>
    <title>Approve Advising Forms</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    
    echo '<div class="main-container">';
            echo "<h1>Advising Forms</h1>";
            $query = "SELECT distinct u.fname, u.lname, u.uid, u.email, u.address FROM user u, aspects a, regiform r WHERE u.uid = a.id AND a.advisorid =".$uid." AND u.uid = r.uid and a.reviewForm = 0";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>User Name</th>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Advising Form</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>";
                    echo '<form action="viewRegForm.php" method="post"><input type="hidden" name="idd" value = "'.$row["uid"].'"><button type="submit">View</button></form>';
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
                echo "No one has submitted an advising form";
            }
        
        ?>
    </div>
</body>

</html> 
