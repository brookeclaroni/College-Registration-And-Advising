<?php
session_start($options = []);
$servername = "127.0.0.1";
$username = "harmonandbrooke";
$password = "DBteam18!";
$dbname = "harmonandbrooke";

function trim_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    // Redirect to user friendly error page
    die('Error: ' . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="main-container">
        <form method="post">
            <table style="max-width: 500px">
                <tr>
                    <td>UserId:</td>
                    <td><input type="text" name="user_id"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password"></td>
                </tr>
            </table>
            <br>
            <button type="submit" value="Submit">Submit</button>
        </form>
        <br>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = trim_input($_POST["user_id"]);
            $password = trim_input($_POST["password"]);

            if (!preg_match("/^[a-zA-Z0-9]*$/", $user_id)) {
                $message = "Only letters and numbers are allowed for UserID";
                echo "<script type='text/javascript'>alert('$message');</script>";
                die();
            }

            $query = "SELECT uid FROM user WHERE uid = '$user_id' AND password = '$password'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();

                $user_name = $row["name"];

                $_SESSION["user_name"] = $user_name;
                $_SESSION["user_id"] = $user_id;

                $query = "SELECT type FROM role WHERE uid = '$user_id'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $_SESSION["user_role"] = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        array_push($_SESSION["user_role"], $row["type"]);
                    }
                } else {
                    die("Error: Failed to get roles<br>");
                }

                echo ("Login sucessfully<br>");
            } else {
                die("Invalid password / Invalid username<br>");
            }

            header("refresh:1;url=index.php");
            mysqli_close($conn);
        }
        ?>
    </div>
</body>

</htm l> 