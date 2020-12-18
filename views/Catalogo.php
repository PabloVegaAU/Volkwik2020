<div hidden>
    <?php
    session_start();
    include '../recursos/conexión.php';

    $sentencia = $conn->prepare("SELECT * FROM `producto`");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    ?>
</div>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
        <link rel="stylesheet" href="estilos/catalogo.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title>Catalogo Volkwik</title>
        <style>
            *{
                margin: 0;
                padding: 0;
            }
            .boxC{
                display: flex;
                padding-left: 5%;
            }
            .boxC .listaC{
                padding: 18px 28px 0px 12px;
                border-width: 2px 0px 2px 2px;
                border-radius: 12px 0% 0% 12px;
            }

            .boxC .listaC li{
                list-style: none;
                padding-top: 10px;
            }

            .boxC .listaC a{
                color: #777777;
                text-decoration: none;
                font-size: 17px;
            }
            .boxC .listaC a:hover{
                color: red;
                cursor: pointer;
            }
            .boxP{
                border-width: 2px;
                display: flex;
                padding: 20px;
                width: 90%;
            }
            .Productos {
                width: 22%;
                height: 400px;
                max-height: 400px;
                max-width: 20%;
                min-height: 400px;
                min-width: 20%;
                padding: 20px;
            }

            .Productos .card {
                border-radius: 25px;
                border: 1px solid aqua;
                /*box-shadow: -8px 8px 1px rgba(0, 0, 0, 0.1);*/
            }

            .Productos .card-head {
                position: static;
                height: 252px;
                background: #00cccc;
                /* Old browsers */
                background: -moz-linear-gradient(-45deg, #00cccc 8%, #000000 83%);
                /* FF3.6-15 */
                background: -webkit-linear-gradient(-45deg, #00cccc 8%, #000000 83%);
                /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(135deg, #00cccc 8%, #000000 83%);
                /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#00cccc', endColorstr='#000000', GradientType=1);
                /* IE6-9 fallback on horizontal gradient */
                border-radius: 25px 25px 0 0;
            }
            .Productos .card-head h2{padding-top: 10px;font-size: 14px;width: 100%;max-height:30px}
            .Productos .card-logo {
                border-radius: 50%;
                height: 40px;
                width: 40px;
                max-width: 40px;
                max-height: 40px;
                min-width: 40px;
                min-height: 40px;
                margin: 10px 8px 20px 10px;
            }

            .Productos .product-img {
                position: static;
                margin: 0px 0px 10px 20px;
                width: 80%;
                height: 70%;
            }


            .Productos .card-body {
                height: 100px;
                background: #fff;
                border-radius: 0 0 25px 25px;
            }

            .Productos .badge {
                position: static;
                font-size: 14px;
                font-weight: 300;
                color: #fff;
                background: #11e95b;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                height: 24px;
            }
            .Productos .stock {
                position: static;
                font-size: 15px;
                font-weight: 300;
                color: #fff;
                background: black;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                height: 16px;
            }

            .Productos .pricesN{
                display: flex;
                justify-content: space-between;
                padding: 40px 25px 0px 25px;
                align-items: center;
            }

            .Productos .product-priceN {
                background: #11e95b;
                padding: 7px 8px;
                text-align: center;
                font-size: 20px;
                color: #000;
                border-radius: 4px;
                margin-top: -13px;
                margin-left: -5px;
            }

            .Productos .product-priceP {
                height: 12px;

                background: #00cccc;
                padding: 7px 8px;
                text-align: center;
                font-size: 15px;
                color: #000;
                border-radius:4px;
                margin-top: -13px;
                margin-left: -5px;
            }

            .Productos .pricesT{
                display: flex;
                justify-content: space-between;
                padding: 0px 50px 0px 50px;

            }

            @media screen and (max-width: 1550px){
                .boxP{
                    flex-wrap: wrap;
                }
            }
        </style>

        <script>
            $(document).ready(function () {
                $("[estado='No Habilitado'],[enPromo='Si']").hide();
                $("#Todo").click(function () {
                    $("[data-id='Smart Watch']").show();
                    $("[data-id='Audifonos']").show();
                    $("[data-id='Microfono']").show();
                    $("[enPromo='Si']").hide();
                });
                $("#Audifono").click(function () {
                    $("[data-id='Smart Watch']").hide();
                    $("[data-id='Audifonos']").show();
                    $("[data-id='Microfono']").hide();
                    $("[enPromo='Si']").hide();
                });
                $("#SmartW").click(function () {
                    $("[data-id='Smart Watch']").show();
                    $("[data-id='Audifonos']").hide();
                    $("[data-id='Microfono']").hide();
                    $("[enPromo='Si']").hide();
                });
                $("#Microfono").click(function () {
                    $("[data-id='Smart Watch']").hide();
                    $("[data-id='Audifonos']").hide();
                    $("[data-id='Microfono']").show();
                    $("[enPromo='Si']").hide();
                });
            });
        </script>
    </head>

    <?php
    if (isset($_SESSION['usuario'])) {
        include './extremos/headerAdmin.php';
    } elseif (isset($_SESSION['cliente'])) {
        include './extremos/headercli.php';
    } else {
        include './extremos/header.php';
    }
    ?>

    <body>
        <br>

        <br>
        <div class="boxC">
            <div class="listaC"><br><br>
                <li><a id="Todo">Todos</a></li>
                <li><a id="Audifono">Audifonos</a></li>
                <li><a id="SmartW">Smart Watchs</a></li>
                <li><a id="Microfono">Microfonos</a></li>
            </div>
            <div class="boxP" id="Catalogo">
                <?php foreach ($listaProductos as $producto) { ?>

                    <div class="Productos" estado="<?php echo $producto['Estado']; ?>"enpromo="<?php echo $producto['EnPromo']; ?>" data-id="<?php echo $producto['Categoria']; ?>" >
                        <div class="card">
                            <div class="card-head">
                                <div style="display: flex;"><img src="estilos/icons/volkwik.jpg" alt="logo" class="card-logo">
                                    <h2><?php echo $producto['Nombres']; ?></h2>                                
                                </div>
                                <img class="product-img" src="vistasE/FotosPro/<?php echo $producto['Foto']; ?>" width="100" height="100" alt="<?php echo $producto['Nombres']; ?>"/>
                            </div>
                            <div class="card-body">
                                <span class="stock">
                                    Stock: <?php echo $producto['Stock']; ?>
                                </span>

                                <div class="pricesN" >
                                    <span class="product-priceP">
                                        S/. <b> <?php echo $producto['Precio']; ?></b>
                                    </span>
                                </div>
                                <div class="pricesT">
                                    <span class="pac">Precio</span>
                                </div>
                            </div>
                            <form action="Catalogo.php" method="POST" align="center">
                                <input type="hidden" name="idp" value="<?php echo $producto['IdProducto']; ?>">
                                <input type="hidden" name="nomp" value="<?php echo $producto['Nombres']; ?>">
                                <input type="hidden" name="catp" value="<?php echo $producto['Categoria']; ?>">
                                <input type="hidden" name="epp"value="<?php echo $producto['EnPromo']; ?>">
                                <input type="hidden" name="prepp"value="<?php echo $producto['PrecioP']; ?>">
                                <input type="hidden" name="prep" value="<?php echo $producto['Precio']; ?>">
                                <input type="submit"  class="badge" name="Agregar" value="Agregar al carrito">
                                <input type="number" style="width: 40px" min="1" max="<?php echo $producto['Stock']; ?>" name="cant" value="0"pattern="^[0-9]+" onKeyPress='if (this.value.length == 2)
                                            return false;' />
                            </form>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div>

        <br>
        <?php
        $idp = (isset($_POST['idp'])) ? $_POST['idp'] : "";
        $nomp = (isset($_POST['nomp'])) ? $_POST['nomp'] : "";
        $prep = (isset($_POST['prep'])) ? $_POST['prep'] : "";
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
        <br>
    </body>
    <?php include './extremos/burbujar.php'; ?>
    <footer>
        <?php include './extremos/footer.php'; ?> 
    </footer>
</html>
