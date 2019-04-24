<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}

if (
    !in_array("admin", $_SESSION["user_role"]) &&
    !in_array("gs", $_SESSION["user_role"]) &&
    !in_array("instructor", $_SESSION["user_role"]) &&
    !in_array("registrar", $_SESSION["user_role"])
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
    <title>Manage Page</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="main-container">
        <h1>View Transcript</h1>
        <form action="viewTranscript.php" method="post">
            Student ID: <br>
            <input type="text" name="uid" id="uid">
            <button type="submit">View</button>
        </form>
        <?php
        if (in_array("admin", $_SESSION["user_role"])) {
                    echo "<h1>Add Account</h1>";
                    echo "<form method=\"post\">";
                    echo "ID: <br>";
                    echo "<input type=\"text\" name=\"nuid\" id=\"nuid\">";
                    echo "Username: <br>";
                    echo "<input type=\"text\" name=\"nusername\" id=\"nusername\">";
                    echo "Password: <br>";
                    echo "<input type=\"password\" name=\"npass\" id=\"npass\">";
                    echo "email: <br>";
                    echo "<input type=\"text\" name=\"nemail\" id=\"nemail\">";
                    echo "First Name: <br>";
                    echo "<input type=\"text\" name=\"nfname\" id=\"nfname\">";
                    echo "Last Name: <br>";
                    echo "<input type=\"text\" name=\"nlname\" id=\"nlname\">";
                    echo "Address: <br>";
                    echo "<input type=\"text\" name=\"naddress\" id=\"naddress\">";
                    echo "Balance: <br>";
                    echo "<input type=\"text\" name=\"nbalance\" id=\"nbalance\">";
                    echo "SSN: <br>";
                    echo "<input type=\"text\" name=\"nssn\" id=\"nssn\">";
                    echo "Roles: (multiple roles are seperated by ',') <br>";
                    echo "<input type=\"text\" name=\"nroles\" id=\"nroles\">";
                    echo "Program: (only fill out if user is a student (MS or PhD)) <br>";
                    echo "<input type=\"text\" name=\"nprogram\" id=\"nprogram\">";
                    echo "<button type=\"submit\">Add</button>";
                    echo "</form>";
                }
        if (in_array("admin", $_SESSION["user_role"]) || in_array("gs", $_SESSION["user_role"])) {
            echo "<h1>User List</h1>";
            $query = "SELECT * FROM user INNER JOIN role ON user.uid = role.uid";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>User Name</th>
                        <th>User ID</th>
                        <th>Address</th>
                        <th>Role</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . " " . "</td>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        if (in_array("admin", $_SESSION["user_role"]) || in_array("registrar", $_SESSION["user_role"])) {
            echo "<h1>Change Grade</h1>";
            echo "<form method=\"post\">";
            echo "Student ID: <br>";
            echo "<input type=\"text\" name=\"suid\" id=\"suid\">";
            echo "Schedule ID: <br>";
            echo "<input type=\"text\" name=\"sid\" id=\"sid\">";
            echo "Grade: <br>";
            echo "<input type=\"text\" name=\"grade\" id=\"grade\">";
            echo "<button type=\"submit\">Change</button>";
            echo "</form>";
        }
        if (in_array("admin", $_SESSION["user_role"]) || in_array("gs", $_SESSION["user_role"])) {
            echo "<h1>View Roster By Section</h1>";
            echo "<form action=\"viewRoster.php\" method=\"post\">";
            echo "Schedule ID: <br>";
            echo "<input type=\"text\" name=\"vscheduleid\" id=\"vscheduleid\">";
            echo "<button type=\"submit\">View</button>";
            echo "</form>";
        }
        if (in_array("admin", $_SESSION["user_role"]) || in_array("gs", $_SESSION["user_role"]) || in_array("registrar", $_SESSION["user_role"])) {
            echo "<h1>Schedule List</h1>";
            $query = "SELECT * FROM schedule INNER JOIN course ON schedule.cid = course.cid ORDER BY schedule.sid";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Course Title</th>
                        <th>Course ID</th>
                        <th>Section</th>
                        <th>Term</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["sid"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["cid"] . "</td>";
                    echo "<td>" . $row["section"] . "</td>";
                    echo "<td>" . $row["term"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["sid"])) {
            $suid = trim_input($_POST["suid"]);
            $sid = trim_input($_POST["sid"]);
            $grade = trim_input($_POST["grade"]);

            if($grade == "A" || $grade == "A-" || $grade == "B+" || $grade == "B" || $grade == "B-" || $grade == "C+" || $grade == "C" || $grade == "F")
            {
              $sql = "UPDATE enrolls SET grade = '$grade' WHERE uid = '$suid' AND sid='$sid'";
              if (mysqli_query($conn, $sql)) {
                $message = "Grade changed";
                echo "<script type='text/javascript'>alert('$message');</script>";
              } else {
                  $message = "Failed to change grade";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  die();
              }
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["nuid"])) {
            $nuid = trim_input($_POST["nuid"]);
            $nfname = trim_input($_POST["nfname"]);
            $nlname = trim_input($_POST["nlname"]);
            $naddress = trim_input($_POST["naddress"]);
            $nroles = trim_input($_POST["nroles"]);
            $npass = trim_input($_POST["npass"]);
            $nusername = trim_input($_POST["nusername"]);
            $nbalance = trim_input($_POST["nbalance"]);
            $nssn = trim_input($_POST["nssn"]);
            $nemail = trim_input($_POST["nemail"]);
            $nprogram = trim_input($_POST["nprogram"]);

            if (!preg_match("/^[a-zA-Z0-9]*$/", $nuid)) {
                $message = "Only letters and numbers are allowed for UserID";
                echo "<script type='text/javascript'>alert('$message');</script>";
                die();
            }
//TODO: 
            $sql = "INSERT INTO user (uid, password, username, email, fname, lname, address, balance, ssn)
                VALUES ('$nuid', '$npass', '$nusername', '$nemail', '$nfname', '$nlname', '$naddress', '$nbalance', '$nssn')";
            if (mysqli_query($conn, $sql)) {
                $nroles_array = explode(",", $nroles);
                foreach ($nroles_array as $nrole) {
                    $sql = "INSERT INTO role VALUES ('$nuid', '$nrole')";
                    if($nrole == "student")
                    {
                      $sqlaspect = "INSERT INTO aspects VALUES ('$nuid', null, 2019, null, '$nprogram', 0, 0, 0)";
                      if (!mysqli_query($conn, $sqlaspect)) {
                        $message = "Failed to add ASPECTS";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        die();
                      }
                    }
                    if (!mysqli_query($conn, $sql)) {
                        $message = "Failed to add new user";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        die();
                    }
                }
                $message = "Add user successfully";
                echo "<script type='text/javascript'>alert('$message');</script>";
                header("refresh:3;url=manage.php");
            } else {
                $message = "Failed to add new user";
                echo "<script type='text/javascript'>alert('$message');</script>";
                die();
            }
        }
        ?>
    </div>
</body>

</html> 
