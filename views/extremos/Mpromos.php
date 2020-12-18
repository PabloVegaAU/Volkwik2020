<!DOCTYPE html>
<?php
include '../recursos/conexión.php';
$sentencia = $conn->prepare("SELECT * FROM producto where EnPromo='Si' AND Estado='Habilitado'  ORDER BY ventas DESC LIMIT 3");
$sentencia->execute();
$listaPromo = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
        <style>
            .flexing{display: flex;justify-content: space-between; width: 70%}
            .Spromos {
                width: 250px;
                height: 400px;
            }

            .Spromos .card {
                border-radius: 25px;
                box-shadow: -8px 8px 1px rgba(0, 0, 0, 0.2);
            }

            .Spromos .card-head {
                position: static;
                height: 252px;
                background: #00cccc;
                /* Old browsers */
                background: -moz-linear-gradient(-45deg, #00cccc 8%, #c82930 83%);
                /* FF3.6-15 */
                background: -webkit-linear-gradient(-45deg, #00cccc 8%, #c82930 83%);
                /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(135deg, #00cccc 8%, #c82930 83%);
                /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#00cccc', endColorstr='#c82930', GradientType=1);
                /* IE6-9 fallback on horizontal gradient */
                border-radius: 25px 25px 0 0;
            }
            .Spromos .card-head h2{padding-top: 24px;font-size: 20px;width: 100%}
            .Spromos .card-logo {
                border-radius: 50%;
                width: 45px;
                margin: 15px;
            }

            .Spromos .product-img {
                position: static;
                left: 0;
                margin-top: -1px;
                width: 180px;
                height: 170px;
            }


            .Spromos .card-body {
                height: 100px;
                background: #fff;
                border-radius: 0 0 25px 25px;
            }

            .Spromos .badge {
                position: static;
                font-size: 15px;
                font-weight: 300;
                color: #fff;
                background: #cc0000;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                margin-left: -6px;
                height: 16px;
            }
            .Spromos .Wow {
                position: static;
                font-size: 15px;
                font-weight: 300;
                color: #fff;
                background: #11e95b;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                margin-left: -6px;

            }


            .Spromos .pricesN{
                display: flex;
                justify-content: space-between;
                margin: 20px 25px 0px 25px;
                align-items: center;
            }

            .Spromos .product-priceN {
                background: #11e95b;
                padding: 7px 8px;
                text-align: center;
                font-size: 20px;
                color: #000;
                border-radius: 4px;
                margin-top: -13px;
                margin-left: -5px;
            }

            .Spromos .product-priceP {
                height: 12px;
                text-decoration: line-through;
                background: #00cccc;
                padding: 7px 8px;
                text-align: center;
                font-size: 15px;
                color: #000;
                border-radius:4px;
                margin-top: -13px;
                margin-left: -5px;
            }

            .Spromos .pricesT{
                display: flex;
                justify-content: space-between;
                padding: 0px 50px 0px 50px;

            }
            .stock {
                position: static;
                font-size: 16px;
                font-weight: 300;
                color: #fff;
                background: black;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                height: 16px;
            }
        </style>
    </head>
    <body>
    <center>
        <h1> PROMOCIONES MÁS PEDIDAS</h1><br><br>
        <div class="flexing">
            <?php foreach ($listaPromo as $producto) { ?>
                <div class="Spromos">
                    <div class="card">
                        <div class="card-head">
                            <div style="display: flex;">
                                <img src="estilos/icons/volkwik.jpg" alt="logo" class="card-logo">
                                <h2><?php echo $producto['Nombres']; ?></h2>
                                <span class="badge">
                                    BEST
                                </span>
                            </div>
                            <td><img class="product-img" src="vistasE/FotosPro/<?php echo $producto['Foto']; ?>" width="100" height="100" alt="<?php echo $producto['Nombres']; ?>"/>
                        </div>
                        <div class="card-body">
                            <span class="stock">
                                Stock: <?php echo $producto['Stock']; ?>
                            </span>
                            <div class="pricesN">
                                <span class="product-priceN">
                                    S/. <b> <?php echo $producto['PrecioP']; ?></b>
                                </span>
                                <span class="product-priceP">
                                    S/. <b> <?php echo $producto['Precio']; ?></b>
                                </span>
                            </div>
                            <div class="pricesT">
                                <span class="pac">ahora</span>
                                <span class="pan">antes</span>
                            </div>
                        </div>
                        <form action="" method="POST" align="center">
                            <input type="hidden" name="idp" value="<?php echo $producto['IdProducto']; ?>">
                            <input type="hidden" name="nomp" value="<?php echo $producto['Nombres']; ?>">
                            <input type="hidden" name="catp" value="<?php echo $producto['Categoria']; ?>">
                            <input type="hidden" name="epp"value="<?php echo $producto['EnPromo']; ?>">
                            <input type="hidden" name="prepp"value="<?php echo $producto['PrecioP']; ?>">
                            <input type="hidden" name="prep" value="<?php echo $producto['Precio']; ?>">
                            <input type="submit"  class="Wow" name="Agregar" value="Agregar al carrito">
                            <input type="number" style="width: 40px;font-size: 15px" min="1" name="cant" value="0"pattern="^[0-9]+" onKeyPress='if (this.value.length == 2)
                                            return false;' />
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </center>
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

        echo '<meta http-equiv="refresh" content="0" />';
    }
    ?>
</body>
</html>
