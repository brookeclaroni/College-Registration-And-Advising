<div class="navbar">
    <a href="index.php">Home</a>
    <?php
    if (empty($_SESSION["user_id"])) {
        echo ("<a href=\"login.php\">Login</a>");
    } else {
        if (in_array("student", $_SESSION["user_role"])) {
            echo ("<a href=\"transcript.php\">Transcript</a>");
            if(!in_array("instructor", $_SESSION["user_role"])){
              echo ("<a href=\"gradeCourses.php\">Grades</a>");
              echo ("<a href=\"courses.php\">Courses</a>");
            }
            echo ("<a href=\"form1.php\">Form 1</a>");
            echo ("<a href=\"applyToGraduate.php\">Apply to Graduate</a>");
            
            $degquery = "SELECT * FROM aspects WHERE id =".$_SESSION['user_id']."";
            $degresult = mysqli_query($conn, $degquery);
            if (mysqli_num_rows($degresult) > 0){
		          while ($row = mysqli_fetch_assoc($degresult)) {
		            if ($row['degreeType'] == "PhD")
                {
                    echo ("<a href=\"thesis.php\">Thesis</a>");
                }
              }
	          }
        }
        
        
        if (in_array("registrar", $_SESSION["user_role"])) {
            echo ("<a href=\"editschedule.php\">Schedules</a>");
        }
        
        if (in_array("alumni", $_SESSION["user_role"])) {
            echo ("<a href=\"transcript.php\">Transcript</a>");
        }
        if (in_array("instructor", $_SESSION["user_role"])) {
            echo ("<a href=\"courses.php\">Courses</a>");
            echo ("<a href=\"gradeCourses.php\">Grades</a>");
        }
        if (in_array("advisor", $_SESSION["user_role"])) {
            echo ("<a href=\"manageAdvisees.php\">Manage Advisees</a>");
            echo ("<a href=\"approveRegForms.php\">Approve Forms</a>");
        }
        if (in_array("admin", $_SESSION["user_role"]) || in_array("gs", $_SESSION["user_role"]) || in_array("instructor", $_SESSION["user_role"]) || in_array("registrar", $_SESSION["user_role"])) {
            echo ("<a href=\"manage.php\">Manage</a>");
        }
        
        if (in_array("gs", $_SESSION["user_role"]))
        {
            echo ("<a href=\"search.php\">Search</a>");
            echo ("<a href=\"manageAdvising.php\">Advising</a>");
	    echo ("<a href=\"thesisStatus.php\">Theses</a>");
            echo ("<a href=\"clearedToGrad.php\">Graduation</a>");
        }
        echo ("<a href=\"info.php\">Info</a>");
        echo ("<a href=\"logout.php\">Log Out</a>");
    }
    ?>
</div> 
