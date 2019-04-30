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
    <title>Search Page</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="main-container">
        <?php
        if (in_array("gs", $_SESSION["user_role"])) {
                    echo "<h1>View Grads By Year</h1>";
                    echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "Year: <br>";
                    echo "<input type=\"text\" name=\"gyear\" id=\"gyear\">";
                    echo "<button type=\"submit\">View</button>";
                    echo "</form>";
        }
        
        if (in_array("gs", $_SESSION["user_role"])) {
                    echo "<h1>View Alumni By Grad Year</h1>";
                    echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "Year: <br>";
                    echo "<input type=\"text\" name=\"ayear\" id=\"ayear\">";
                    echo "<button type=\"submit\">View</button>";
                    echo "</form>";
        }
        
        if (in_array("gs", $_SESSION["user_role"])) {
                    echo "<h1>View Students By Year/Program</h1>";
                    echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "Year: <br>";
                    echo "<input type=\"text\" name=\"syear\" id=\"syear\">";
                    echo "Program: <br>";
                    echo "<input type=\"text\" name=\"sprogram\" id=\"sprogram\">";
                    echo "<button type=\"submit\">View</button>";
                    echo "</form>";
        }
        
        ?>
    </div>
</body>

</html> 
