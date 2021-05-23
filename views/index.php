<!DOCTYPE html>
<?php session_start();
?>
<html>
    <head>
        <meta charset="UTF-8" http-equiv="Refresh">
        <title>Tienda Volkwik</title>
                <link rel = "icon" href =  
"./estilos/icons/volkwik.jpg" 
        type = "image/*"> 
        <style>
            *{padding: 0;
              margin: 0;}
        </style>
    </head>
    <header>

        <?php //include './extremos/promoB.php'; ?>
        <?php
        if (isset($_SESSION['usuario'])) {
            include './extremos/headerAdmin.php';
        } elseif (isset($_SESSION['cliente'])) {
            include './extremos/headercli.php';
        } else {
            include './extremos/header.php';
        }
        ?>

    </header>
    <body>
        <br><br>


        <?php include './extremos/promoA.php'; ?>
        <br><br><br>
        <?php
        include './extremos/carrusel.php';
        ?><br><br><br>
        <?php include './extremos/Mpromos.php'; ?>
        <?php include './extremos/burbujar.php'; ?>
        <br><br><br>
    </body>
    <footer>
        <?php
        include './extremos/footer.php';
        ?>
    </footer>
</html>
