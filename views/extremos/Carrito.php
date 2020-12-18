<?php
session_start();
?>

<html>
    <head>
        <title>title</title>
    </head>
    <header>
        <?php
        if (isset($_SESSION['usuario'])) {
            include './headerAdmin.php';
        } elseif (isset($_SESSION['cliente'])) {
            include './headercli.php';
        } else {
            include './header.php';
        }
        ?>
    </header>
    <body>

    </body>
</html>
