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
        
        echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "Semester (sp - -/f - -)(Enter both semesters separated by ',' to get a whole year): ";
                    echo "<input type=\"text\" name=\"semester\" id=\"semester\"><br><br>";
                    echo "Program (MS or PhD): ";
                    echo "<input type=\"text\" name=\"program\" id=\"program\"><br><br>";
        
                    echo '<select name="group">';
                    echo '<option value="graduate">Graduates</option>';
                    echo '<option value="alumni">Alumni</option>';
                    echo '<option value="student">Students</option>';
                    echo '</select>';
        
                    echo "<br><br>";
                    echo "<button type=\"submit\">View People</button>";
                    echo "<br><br>";
                    /*echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "<input type=\"hidden\" name=\"group\" value=\"graduate\">";
                    echo "<input type=\"hidden\" name=\"yyear\" value=\"graduate\">";
                    echo "<button type=\"submit\">View Graduates</button>";
                    echo "<br><br>";
                    echo "</form>";

                    echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "<input type=\"hidden\" name=\"group\" value=\"alumni\">";
                    echo "<button type=\"submit\">View Alumni</button>";
                    echo "<br><br>";
                    echo "</form>";

                    echo "<form method=\"post\" action=\"searchResults.php\">";
                    echo "<input type=\"hidden\" name=\"group\" value=\"student\">";
                    echo "<button type=\"submit\">View Students</button>";
                    echo "<br><br>";*/
                    
        echo "</form>";
        }
        
        ?>
    </div>
</body>

</html> 
