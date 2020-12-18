<div hidden><?php include '../recursos/conexión.php'; ?></div>

<?php
session_start();
$sentencia = $conn->prepare("SELECT * FROM `producto`");
$sentencia->execute();
$listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>


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
                padding-left: 2%;

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
            .Productos .card-head h2{padding-top:9px;font-size: 16px;width: 100%}
            .Productos .card-logo {
                border-radius: 50%;
                height: 40px;
                width: 40px;
                max-width: 40px;
                max-height: 40px;
                min-width: 40px;
                min-height: 40px;
                margin: 15px;;
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
                font-size: 16px;
                font-weight: 300;
                color: white;
                background: red;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                height: 24px;
            }
            .Productos .promo {
                position: static;
                font-size: 16px;
                font-weight: 300;
                color: black;
                padding: 2px 5px;
                border-radius: 4px;
                top: -2px;
                height: 24px;
                background: rgb(243,249,124);
                background: -moz-linear-gradient(90deg, rgba(243,249,124,1) 21%, rgba(243,255,0,1) 48%, rgba(221,214,16,1) 76%, rgba(184,157,25,1) 95%);
                background: -webkit-linear-gradient(90deg, rgba(243,249,124,1) 21%, rgba(243,255,0,1) 48%, rgba(221,214,16,1) 76%, rgba(184,157,25,1) 95%);
                background: linear-gradient(90deg, rgba(243,249,124,1) 21%, rgba(243,255,0,1) 48%, rgba(221,214,16,1) 76%, rgba(184,157,25,1) 95%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#f3f97c",endColorstr="#b89d19",GradientType=1);
            }
            .Productos .stock {
                position: static;
                font-size: 14.3px;
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
    </head>
    <header>
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
        <br>
        <div class="boxC">
            <div class="listaC"><br><br>
                <li><a id="Todo">Todos</a></li>
                <li><a id="Audifono">Audifonos</a></li>
                <li><a id="SmartW">Smarts Watchs</a></li>
                <li><a id="Microfono">Microfonos</a></li>
            </div>
            <div class="boxP" id="Catalogo">
                <?php foreach ($listaProductos as $producto) { ?>
                    <input type="hidden" name="catp" value="<?php echo $producto['Categoria']; ?>">
                    <div class="Productos" estado="<?php echo $producto['Estado']; ?>"enpromo="<?php echo $producto['EnPromo']; ?>" data-id="<?php echo $producto['Categoria']; ?>" >
                        <div class="card">
                            <div class="card-head">
                                <div style="display: flex;"><img src="estilos/icons/volkwik.jpg" alt="logo" class="card-logo">
                                    <input type="hidden" name="nomp" value="<?php echo $producto['Nombres']; ?>">
                                    <h2><?php echo $producto['Nombres']; ?></h2>
                                    <span class="promo">
                                        PROMO
                                    </span>
                                </div>
                                <img class="product-img" src="vistasE/FotosPro/<?php echo $producto['Foto']; ?>" width="100" height="100" alt="<?php echo $producto['Nombres']; ?>"/>
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
                            <form action="Promo.php" method="POST" align="center">
                                <input type="hidden" name="idp" value="<?php echo $producto['IdProducto']; ?>">
                                <input type="hidden" name="nomp" value="<?php echo $producto['Nombres']; ?>">
                                <input type="hidden" name="catp" value="<?php echo $producto['Categoria']; ?>">
                                <input type="hidden" name="prepp"value="<?php echo $producto['PrecioP']; ?>">
                                <input type="submit"  class="badge" name="Agregar" value="Agregar al carrito">
                                <input type="number" style="width: 40px" min="1" name="cant" value="0"pattern="^[0-9]+" onKeyPress='if (this.value.length == 2)
                                            return false;' />
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("[estado='No Habilitado'],[enPromo='No']").hide();
            $("#Todo").click(function () {
                $("[data-id='Smart Watch']").show();
                $("[data-id='Audifonos']").show();
                $("[data-id='Microfono']").show();
                $("[enPromo='No']").hide();
            });
            $("#Audifono").click(function () {
                $("[data-id='Smart Watch']").hide();
                $("[data-id='Microfono']").hide();
                $("[data-id='Audifonos']").show();
                $("[enPromo='No']").hide();
            });
            $("#SmartW").click(function () {
                $("[data-id='Smart Watch']").show();
                $("[data-id='Microfono']").hide();
                $("[data-id='Audifonos']").hide();
                $("[enPromo='No']").hide();
            });
            $("#Microfono").click(function () {
                $("[data-id='Smart Watch']").hide();
                $("[data-id='Audifonos']").hide();
                $("[data-id='Microfono']").show();
                $("[enPromo='No']").hide();
            });
        });
    </script>
    <br>
    <?php
    $idp = (isset($_POST['idp'])) ? $_POST['idp'] : "";
    $nomp = (isset($_POST['nomp'])) ? $_POST['nomp'] : "";
    $prep = (isset($_POST['prepp'])) ? $_POST['prepp'] : "";
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
            $_SESSION['Carrito'][] = $product;
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
        }
        $numProd = count($_SESSION['Carrito']);
        echo "<script>alert('Producto " . $nomp . " agregado');</script>";
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
