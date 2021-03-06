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
    <title>View Searches</title>

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
        
            $semester = trim_input($_POST["semester"]);
            $program = trim_input($_POST["program"]);
            
            $group = $_POST["group"];
            
            $sem_array = explode(",", $semester);
            
              if($group == "alumni"){
                if($semester != "" && $program != ""){
                foreach ($sem_array as $sem) {
                      $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'alumni' and u.uid = r.uid and u.uid = a.id and a.gradYear = '$sem' and a.degreeType = '$program'";
                      $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No alumni with those parameters";
                  echo "<br>";
              }
            } 
            }

                else if($semester != ""){
                    foreach ($sem_array as $sem) {
                      $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'alumni' and u.uid = r.uid and u.uid = a.id and a.gradYear = '$sem'";
                      $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No alumni with those parameters";
                  echo "<br>";
              }
            } 
            }
                else {
                if($program != ""){
                    $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'alumni' and u.uid = r.uid and u.uid = a.id and a.degreeType = '$program'";
                }
                else {
                $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'alumni' and u.uid = r.uid and u.uid = a.id";
                }
                
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No alumni with those parameters";
                  echo "<br>";
              }
            } 
          }
            
            
            
            
            if($group == "graduate"){
                if($semester != "" && $program != ""){
                foreach ($sem_array as $semester) {
                      $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.clearedToGrad = 1 and a.gradYear = '$semester' and a.degreeType = '$program'";
                      $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No graduate with those parameters<br>";
              }
            } 
            }

                else if($semester != ""){
                    foreach ($sem_array as $semester) {
                      $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.clearedToGrad = 1 and a.gradYear = '$semester'";
                      $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No graduate with those parameters<br>";
              }
            } 
            }
                else {
                if($program != ""){
                    $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.degreeType = '$program' and a.clearedToGrad = 1";
                }
                else {
                $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.clearedToGrad = 1";
                }
                
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No graduate with those parameters<br>";
              }
            } 
          }
          
          
          
          
          if($group == "student"){
                if($semester != "" && $program != ""){
                foreach ($sem_array as $semester) {
                      $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.startYear = '$semester' and a.degreeType = '$program'";
                      $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No students with those parameters";
              }
            } 
            }

                else if($semester != ""){
                    foreach ($sem_array as $semester) {
                      $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.startYear = '$semester'";
                      $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No students with those parameters";
              }
            } 
            }
                else {
                if($program != ""){
                    $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id and a.degreeType = '$program'";
                }
                else {
                $sql = "select u.uid, u.fname, u.lname, u.email from user u, role r, aspects a where r.type = 'student' and u.uid = r.uid and u.uid = a.id";
                }
                
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                echo "<table>
                        <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                        </tr>";
                        
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["uid"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["lname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
              } else {
                  echo "No students with those parameters";
              }
            } 
          }
        
        ?>
    </div>
</body>

</html> 
