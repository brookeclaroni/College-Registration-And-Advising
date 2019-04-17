<div class="navbar">
    <a href="index.php">Home</a>
    <?php
    if (empty($_SESSION["user_id"])) {
        echo ("<a href=\"login.php\">Login</a>");
    } else {
        if (in_array("student", $_SESSION["user_role"])) {
            echo ("<a href=\"courses.php\">Courses</a>");
            echo ("<a href=\"transcript.php\">Transcript</a>");
            echo ("<a href=\"gradeCourses.php\">Grades</a>");
        }
        if (in_array("alumni", $_SESSION["user_role"])) {
            echo ("<a href=\"courses.php\">Courses</a>");
            echo ("<a href=\"transcript.php\">Transcript</a>");
        }
        if (in_array("instructor", $_SESSION["user_role"])) {
            echo ("<a href=\"courses.php\">Courses</a>");
            echo ("<a href=\"gradeCourses.php\">Grades</a>");
        }
        if (in_array("advisor", $_SESSION["user_role"])) {
            echo ("<a href=\"manageAdvisees.php\">Manage Advisees</a>");
        }
        if (in_array("admin", $_SESSION["user_role"]) || in_array("gs", $_SESSION["user_role"]) || in_array("instructor", $_SESSION["user_role"])) {
            echo ("<a href=\"manage.php\">Manage</a>");
        }
        echo ("<a href=\"info.php\">Info</a>");
    }
    ?>
</div> 
