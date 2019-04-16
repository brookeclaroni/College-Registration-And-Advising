<?php
session_start();

if (empty($_SESSION["user_id"])) {
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
    <title>Info Page</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="main-container">
        <h1>User Info</h1>
        <?php
        $query = "SELECT * FROM user WHERE uid = '$uid'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                    <tr>
                        <th>User Name</th>
                        <th>User ID</th>
                        <th>Address</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                echo "<td>" . $row["uid"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
        <h1>Your Current Roles</h1>
        <?php
        $query = "SELECT * FROM role WHERE uid = '$uid'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                    <tr>
                        <th>Roles</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["type"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
        <h1>Change Password</h1>
        <form method="post">
            <input type="password" name="npass" id="npass">
            <button type="submit">Change</button>
        </form>
        <h1>Log out</h1>
        <form method="post">
            <input type="hidden" name="logout" value="true">
            <button type="submit">Logout</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["logout"])) {
                session_destroy();
                mysqli_close($conn);
                header("Location: index.php");
                die();
            }

            $npass = trim_input($_POST["npass"]);

            $sql = "UPDATE user SET password = '$npass' WHERE uid = '$uid'";
            if (mysqli_query($conn, $sql)) {
                echo "Password Changed successfully";
                header("refresh:3;url=info.php");
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        ?>
    </div>
</body>

</html> 