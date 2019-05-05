<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}

if (
    !in_array("admin", $_SESSION["user_role"]) &&
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

?>

<!DOCTYPE html>

<head>
    <title>Stats Page</title>

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
        
        if (in_array("admin", $_SESSION["user_role"]) || in_array("gs", $_SESSION["user_role"])) {
            echo "<h1>Course Statistics</h1>";
            $query = "SELECT c.cid, c.cnum, c.dept, c.title, c.instructor_id, u.fname, u.lname from course c, user u where u.uid = c.instructor_id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<table>
                    <tr>
                        <th>Course ID:</th>
                        <th>Course Number:</th>
                        <th>Course Title</th>
                        <th>Instructor</th>
                        <th>Total Students</th>
                        <th>Average GPA</th>
                    </tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["cnum"] . "</td>";
                    echo "<td>" . $row["dept"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["fname"] . " " . $row["lname"] . "</td>";
                    $c = $row["cid"];
                    $q = "SELECT e.grade, c.credits, s.sid from course c, enrolls e, schedule s where e.sid = s.sid and s.cid = '$c' and c.cid = '$c'";
                    $r = mysqli_query($conn, $q);
                    $gpa = 0.0;
                    $count = 0;
                    
                    while ($rr = mysqli_fetch_assoc($r)) {
                    
                    if ($rr["grade"] !== null) {
                    $count += 1;
                    //echo "<td>" . $rr["grade"] . "</td>";
                    $credits = (int)$rr["credits"];
                    //$credit_hours += $credits;
                    if(strcmp($rr["grade"], "A") == 0){
                        $gpa += 4.0;
                    } elseif(strcmp($rr["grade"], "A-") == 0){
                        $gpa += 3.70;
                    } elseif(strcmp($rr["grade"], "B+") == 0){
                        $gpa += 3.30;
                    } elseif(strcmp($rr["grade"], "B") == 0){
                        $gpa += 3.0;
                    } elseif(strcmp($rr["grade"], "B-") == 0){
                        $gpa += 2.7;
                    } elseif(strcmp($rr["grade"], "C+") == 0){
                        $gpa += 2.3;
                    } elseif(strcmp($rr["grade"], "C") == 0){
                        $gpa += 2.0;
                    } elseif(strcmp($rr["grade"], "C-") == 0){
                        $gpa += 1.7;
                    } elseif(strcmp($rr["grade"], "D+") == 0){
                        $gpa += 1.3;
                    } elseif(strcmp($rr["grade"], "D") == 0){
                        $gpa += 1.0;
                    } elseif(strcmp($rr["grade"], "D-") == 0){
                        $gpa += 0.70;
                    }
                    }
                }
                echo"<td>" . $count . "</td>";
                if($gpa > 0){
                    $gpa /= $count;
                    //$gpa = round($gpa, 2);
                }
                $gpa = number_format($gpa, 2, '.', '');
                echo "<td>" . $gpa . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
        ?>
    </div>
</body>

</html> 
