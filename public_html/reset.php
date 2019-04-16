<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
}
$uid = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<head>
    <title>Reset</title>

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
        chdir('/home/ead/sp19DBp2-harmonandbrooke');
        $command = "mysql --user=harmonandbrooke --password=DBteam18! " . "-h 127.0.0.1 -D harmonandbrooke < ./";
        $output = shell_exec($command . '/schema.sql');
        header("Location: index.php");
        ?>
    </div>
</body>

</html> 