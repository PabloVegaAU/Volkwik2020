<!DOCTYPE html>
<?php
?>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
        <link rel="stylesheet" href="estilos/header.css">
        <link rel="stylesheet" href="estilos/promoAB.css">
        <link rel="stylesheet" href="estilos/login.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>
        <script src="js/login.js"></script>
    </head>
    <style>
        .headerC #loginBox {
            position: absolute;
            margin-top: 0px;
            margin-left: -200px;
            display:none;
            z-index:29;
        }
    </style>
    <div class="headerC">
        <header>
            <div class="menu">
                <nav>
                    <div class="logo" >
                        <a href="/Volkwik2020/views/"><img class="img" src="estilos/icons/volkwik.jpg"></a>
                        <h1><a href="/Volkwik2020/views/">Volk<b>wik</b></a></h1>
                    </div>
                    <ul>
                        <li><a href="../views/Promo.php" class="menu-selected">Promociones</a></li>
                        <li><a href="../views/Catalogo.php" class="menu-selected">Catalogo</a></li>
                       <!-- <li><input class="buscador right menu-selected " placeholder="Buscador" hidden></li>-->
                        <li><label class="buscador right menu-selected "></label></li>
                        <li>
                            <a href="Carrito.php"style="display: flex;justify-content: space-between" class="menu-selected">
                                <img class="imgI" src="estilos/icons/carrito.png">
                                <label style="padding: 10px 0px 0px 0px">
                                    <?php
                                    echo (empty($_SESSION['Carrito']))?0:count($_SESSION['Carrito']);
                                    ?>
                                </label>
                            </a>
                        </li>

                        <li><div id="bar">
                                <div id="container">
                                    <!-- Login Starts Here -->
                                    <div id="loginContainer">
                                        <a href="#" class="menu-selected" id="loginButton"><img class="imgI" src="estilos/icons/login.png"></a>
                                        <div style="clear:both"></div>
                                        <div id="loginBox">                
                                            <form id="loginForm" action="../recursos/controlador/login.php" method="post">
                                                <fieldset id="body">
                                                    <fieldset>
                                                        <label for="email">Usuario</label>
                                                        <input type="text" name="txtuser" id="txtuser" placeholder="Usuario" required/>
                                                    </fieldset>
                                                    <fieldset>
                                                        <label for="password">Contraseña</label>
                                                        <input type="password" name="txtpass" id="txtpass" placeholder="Contraseña" required/>
                                                    </fieldset>
                                                    <input type="submit" value="Ingresar" name="login" />
                                                </fieldset>
                                                <span><a href="./Registro.php">&iquest;No tienes cuenta?</a></span>
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

