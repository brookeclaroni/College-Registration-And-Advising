<form action="<?php print $PHP_SELF?>" enctype="multipart/form-data" method="post">
   Last Name:<br /> <input type="text" name="name" value="" /><br />
   Homework:<br /> <input type="file" name="homework" value="" /><br />
   <p><input type="submit" name="submit" value="Submit Notes" /></p>
</form>

<?php
   define ("FILEREPOSITORY","./");

   if (isset($_FILES['homework'])) {

      if (is_uploaded_file($_FILES['homework']['tmp_name'])) {

         if ($_FILES['homework']['type'] != "application/pdf") {
            echo "<p>Homework must be uploaded in PDF format.</p>";
         } else {
            $today = date("m-d-Y");
            if (! is_dir(FILEREPOSITORY.$today)) {
               mkdir(FILEREPOSITORY.$today);
            }
            $name = $_POST['name'];
            $result = move_uploaded_file($_FILES['homework']['tmp_name'], FILEREPOSITORY.$today."/"."$name.pdf");

            if ($result == 1) 
               echo "<p>File successfully uploaded.</p>";
            else 
               echo "<p>There was a problem uploading the homework.</p>";
         }
      }
   }
?>
