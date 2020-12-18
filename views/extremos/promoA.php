<!DOCTYPE html>
<?php
include '../recursos/conexión.php';
$sentencia = $conn->prepare("SELECT * FROM producto where  PromoSema='Semanal' AND Estado='Habilitado'  ORDER BY ventas DESC LIMIT 1");
$sentencia->execute();
$listaPromo = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
        <link rel="stylesheet" href="../estilos/promosAB.css">    
        <style>
            .promoA .modal-content {
                background-color: transparent;}
            .promoA .contentP {
                display: flex;
                border: solid 5px;
                height: 100%;
                max-height: 150px;}
            </style>
        </head>

        <div class="promoA">

        <!-- Trigger/Open The Modal -->
        <button id="promoA" class="boton">Promo semanal</button>

        <!-- The Modal -->
        <div id="modalS" class="modal">
            <?php foreach ($listaPromo as $producto) { ?>
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&larr;</span><h1 >Promo semanal</h1>
                    <div class="contentP" style="background: none"><br><br>
                        <div style="max-width: 50%;padding: 10px">
                            <div style="background: white;color: black;border:solid yellow"><?php echo $producto['Nombres']; ?></div>
                            <br><br>
                            <div class="pricesN">
                                <div class="product-priceN" style="background: white;">
                                    <b style="padding-right: 30%">S/. <?php echo $producto['PrecioP']; ?></b>
                                    <b>S/. <?php echo $producto['Precio']; ?></b>
                                </div>
                            </div>
                        </div>
                        <div style="margin: 10px 0px 0px 28px">
                            <div><img src="vistasE/FotosPro/<?php echo $producto['Foto']; ?>" width="120" height="120" alt="<?php echo $producto['Nombres']; ?>"/></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <script>
                // Get the modal
                var modal = document.getElementById("modalS");

                // Get the button that opens the modal
                var btn = document.getElementById("promoA");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function () {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {

                    }
                }
            </script>

        </div>
</html>