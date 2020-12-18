<!DOCTYPE html>
<?php
include '../recursos/conexión.php';
$sentencia = $conn->prepare("SELECT * FROM producto where EnPromo='Si' AND Estado='Habilitado'  ORDER BY ventas DESC LIMIT 1");
$sentencia->execute();
$listaPromo = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
        <link rel="stylesheet" href="../estilos/promosAB.css">    
    </head>

    <div class="promoA">

        <!-- Trigger/Open The Modal -->
        <div class="botonB"><button id="promoB"><img src="./estilos/icons/promoB.jpg" alt="alt"/></button></div>

        <!-- The Modal -->
        <div id="modalB" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="closeB">&larr;</span><h1 >Promoción de Bienvenida</h1>
                <div class="contentP">
                    <?php foreach ($listaPromo as $producto) { ?>
                        <img class="product-img" src="vistasE/FotosPro/<?php echo $producto['Foto']; ?>" width="100" height="100" alt="<?php echo $producto['Nombres']; ?>"/>

                        <div class="pricesN">
                            <span class="product-priceN">
                                S/. <b> <?php echo $producto['PrecioP']; ?></b>
                            </span>
                            <span class="product-priceP">
                                S/. <b> <?php echo $producto['Precio']; ?></b>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
        <script>
            // Get the modal
            var modalB = document.getElementById("modalB");

            // Get the button that opens the modal
            var btnB = document.getElementById("promoB");

            // Get the <span> element that closes the modal
            var spanB = document.getElementsByClassName("closeB")[0];

            // When the user clicks the button, open the modal 
            btnB.onclick = function () {
                modalB.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            spanB.onclick = function () {
                modalB.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modalB) {

                }
            }
        </script>

    </div>
</html>