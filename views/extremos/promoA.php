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
                border: solid 5px;
                height: 100%;
                max-height: 180px;}
            .SuperPromo{
                margin-right: 30%;
                font-size: 20px;
            }
            .SuperBoton{
                padding: 0px 20px 0px 20px;
                font-size: 20px;
                background: rgb(116,251,238);
                background: -moz-linear-gradient(90deg, rgba(116,251,238,1) 0%, rgba(84,252,252,1) 27%, rgba(35,225,241,1) 67%, rgba(9,131,143,1) 92%, rgba(9,9,9,1) 99%);
                background: -webkit-linear-gradient(90deg, rgba(116,251,238,1) 0%, rgba(84,252,252,1) 27%, rgba(35,225,241,1) 67%, rgba(9,131,143,1) 92%, rgba(9,9,9,1) 99%);
                background: linear-gradient(90deg, rgba(116,251,238,1) 0%, rgba(84,252,252,1) 27%, rgba(35,225,241,1) 67%, rgba(9,131,143,1) 92%, rgba(9,9,9,1) 99%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#74fbee",endColorstr="#090909",GradientType=1);
            }
        </style>
    </head>

    <div class="promoA">
        <?php
        if ($listaPromo != null) {
            echo '        <!-- Trigger/Open The Modal -->
        <button id="promoA" class="boton">Promo semanal</button>';
        }
        ?>


        <!-- The Modal -->
        <div id="modalS" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&larr;</span><h1 >Promo semanal</h1>
                <div class="contentP" style="background: none">
                    <?php foreach ($listaPromo as $producto) { ?>
                        <div style="display: flex">
                            <div style="max-width: 50%;padding: 10px">
                                <div style="background: white;color: black"><?php echo $producto['Nombres']; ?></div>
                                <br>
                                <div class="product-priceN" >
                                    <b class="SuperPromo" style="background: white;">S/. <?php echo $producto['PrecioP']; ?></b>
                                    <b style="background: white;">S/. <s><?php echo $producto['Precio']; ?></s></b>
                                </div>
                            </div>
                            <div style="margin: 10px 0px 0px 28px">
                                <div><img src="vistasE/FotosPro/<?php echo $producto['Foto']; ?>" width="120" height="120" alt="<?php echo $producto['Nombres']; ?>"/></div>
                            </div>
                        </div>   
                    <?php } ?>
                    <div style="margin-top: 10px">                        
                        <form action="" method="POST" align="center">
                            <input type="hidden" name="idp" value="<?php echo $producto['IdProducto']; ?>">
                            <input type="hidden" name="nomp" value="<?php echo $producto['Nombres']; ?>">
                            <input type="hidden" name="catp" value="<?php echo $producto['Categoria']; ?>">
                            <input type="hidden" name="epp"value="<?php echo $producto['EnPromo']; ?>">
                            <input type="hidden" name="prepp"value="<?php echo $producto['PrecioP']; ?>">
                            <input type="hidden" name="prep" value="<?php echo $producto['Precio']; ?>">
                            <input type="submit"  class="SuperBoton" name="Agregar" value="Agregar al carrito">
                            <input type="number" style="font-size: 18px;border: solid 5px rgb(116,251,238);" min="1" max="<?php echo $producto['Stock']; ?>" name="cant" value="0"pattern="^[0-9]+" onKeyPress='if (this.value.length == 2)
                                        return false;' />
                        </form>
                    </div>   
                </div>  
            </div>

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

            <?php
            $idp = (isset($_POST['idp'])) ? $_POST['idp'] : "";
            $nomp = (isset($_POST['nomp'])) ? $_POST['nomp'] : "";
            $prep = (isset($_POST['prep'])) ? $_POST['prepp'] : "";
            $cant = (isset($_POST['cant'])) ? $_POST['cant'] : "";
            $catp = (isset($_POST['catp'])) ? $_POST['catp'] : "";

            $accion = (isset($_REQUEST['Agregar'])) ? $_REQUEST['Agregar'] : "";

            if ($accion == "Agregar al carrito") {
                if (!isset($_SESSION['Carrito'])) {
                    $product = array(
                        'ID' => $idp,
                        'Nombre' => $nomp,
                        'Categoria' => $catp,
                        'Precio' => $prep,
                        'Cantidad' => $cant
                    );
                    $_SESSION['Carrito'][0] = $product;
                    echo "<script>alert('Producto " . $nomp . " agregado');</script>";
                } else {
                    $IdProducto = array_column($_SESSION['Carrito'], 'ID');
                    if (in_array($idp, $IdProducto)) {
                        echo "<script>alert('Producto " . $nomp . " ya fue agregado');</script>";
                    } else {
                        $numProd = count($_SESSION['Carrito']);
                        $product = array(
                            'ID' => $idp,
                            'Nombre' => $nomp,
                            'Categoria' => $catp,
                            'Precio' => $prep,
                            'Cantidad' => $cant
                        );
                        $_SESSION['Carrito'][$numProd] = $product;
                        echo "<script>alert('Producto " . $nomp . " agregado');</script>";
                    }
                }
                $numProd = count($_SESSION['Carrito']);
            }
            ?>
        </div>
</html>