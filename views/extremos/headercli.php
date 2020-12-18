<?php
include '../recursos/conexión.php';
$usu = $_SESSION['cliente'];
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
if ($accion == 'Salir') {
    session_destroy();
    echo '<meta http-equiv="refresh" content="0" />';
};
$sentencia = $conn->prepare("SELECT * FROM `cliente` where IdCliente=:IdCliente");
$sentencia->bindParam(':IdCliente', $usu['IdCliente']);
$sentencia->execute();
$Cliente = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Refresh" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
        <link rel="stylesheet" href="estilos/hem.css">
        <link rel="stylesheet" href="estilos/promoAB.css">
        <link rel="stylesheet" href="estilos/login.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>
        <script src="js/login.js"></script>
    </head>
    <style>
        .headerC .right {
            margin-right: 340px;
        }
        .headerC #loginBox {
            position: absolute;
            margin-top: 5px;
            margin-left: -125px;
            display:none;
            z-index:29;
        }
        .tag{
            width:120%;
            height: 100%;
            background: #00cccc;
            background: -moz-linear-gradient(-45deg, #00cccc 8%, #000000 83%);
            background: -webkit-linear-gradient(-45deg, #00cccc 8%, #000000 83%);
            background: linear-gradient(135deg, #00cccc 8%, #000000 83%);
            filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#00cccc', endColorstr='#000000', GradientType=1);
            // border-radius: 25px 25px 0 0;
        }
        .tagb{
            outline: none;
            width:100%;
            background: linear-gradient(135deg, #00cccc 8%, #000000 83%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        }
    </style>
    <div class="headerC">
        <header>
            <div class="menu">
                <nav>
                    <div class="logo" >
                        <a href="../views"><img class="img" src="estilos/icons/volkwik.jpg"></a>
                        <h1><a href="../views">Volk<b>wik</b></a></h1>
                    </div>
                    <ul>
                        <li><a href="/Volkwik2020/views/Promo.php" class="menu-selected">Promociones</a></li>
                        <li><a href="/Volkwik2020/views/Catalogo.php" class="menu-selected">Catalogo</a></li>
                        <li><input class="buscador right menu-selected " placeholder="Buscador" hidden></li>
                        <li><label class="buscador right menu-selected "></label></li>
                        <li>
                            <a href="Carrito.php"style="display: flex;justify-content: space-between" class="menu-selected">
                                <img class="imgI" src="estilos/icons/carrito.png">
                                <label style="padding: 10px 0px 0px 0px">
                                    <?php
                                    echo (empty($_SESSION['Carrito'])) ? 0 : count($_SESSION['Carrito'])
                                    ?>
                                </label>
                            </a>
                        </li>
                        <li>
                            <div id="bar">
                                <div id="container">
                                    <!-- Login Starts Here -->
                                    <div id="loginContainer">
                                        <a href="#" id="loginButton">  <button style="border: none;outline: none;font-size: 15px">
                                                <?php
                                                foreach ($Cliente as $cliente) {
                                                    echo $cliente['Nombres'];?>
                                                </button></a>
                                            <div style="clear:both"></div>
                                            <div id="loginBox">                
                                                <form action="" method="POST">
                                                    <fieldset class="tag">
                                                        <fieldset>
                                                            <img class="img-thumbnail" src="vistasE/FotosCli/<?php echo $cliente['Foto']; ?>" width="100" height="100" alt="<?php echo $usu['Nombres']; ?>"/>
                                                            <br><a class="dropdown-item" style="font-size: 20px" href="./Perfil.php" >Mi Perfil</a><br>
                                                            <a class="dropdown-item" style="font-size: 16px"><?php echo $cliente['User']; ?></a><br>
                                                            <a class="dropdown-item" style="font-size: 16px"><?php echo $cliente['Correo']; ?></a>
                                                        <?php } ?><br><br>
                                                        <div class="dropdown-divider">
                                                            <button type="submit" class="tagb" value="Salir" name="accion">Salir</button>
                                                        </div>
                                                    </fieldset>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Login Ends Here -->
                                </div>
                            </div>
                        </li>

                    </ul>
                </nav>
            </div>
        </header>
    </div>
</html>