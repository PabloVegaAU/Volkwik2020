<div hidden><?php include '../recursos/conexión.php'; ?></div>
<?php
session_start();
$dnic = (isset($_POST['dnic'])) ? $_POST['dnic'] : "";
$usercli = (isset($_POST['usercli'])) ? $_POST['usercli'] : "";
$nombcli = (isset($_POST['nombcli'])) ? $_POST['nombcli'] : "";
$direccc = (isset($_POST['direccc'])) ? $_POST['direccc'] : "";
$telecli = (isset($_POST['telecli'])) ? $_POST['telecli'] : "";
$correcli = (isset($_POST['correcli'])) ? $_POST['correcli'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
if ($accion == 'Registrar') {
    $sentencia = $conn->prepare("INSERT INTO cliente(Dni,User,Nombres,Direccion,Telefono,Correo)VALUES (:Dni,:User,:Nombres,:Direccion,:Telefono,:Correo)");
    $sentencia->bindParam(':Dni', $dnic);
    $sentencia->bindParam(':User', $usercli);
    $sentencia->bindParam(':Nombres', $nombcli);
    $sentencia->bindParam(':Direccion', $direccc);
    $sentencia->bindParam(':Telefono', $telecli);
    $sentencia->bindParam(':Correo', $correcli);
    $sentencia->execute();
    header("location: /Volkwik2020/views/");
}
?>
<html>
    <head>
        <title>Registro de cuenta</title>
        <style>
            *{
                padding: 0;
                margin: 0;
            }
            .bodyR{
                margin: 3% 0% 10% 20%;
                width: 60%;
                max-height: 100%;
            }
            .titleR{
                font-size: 50px;
                margin: 0% 0% 5% 30%;
            }
            .textR{
                font-size: 22px;
                margin: 0% 0% 5% 0%;
            }
            .inputR{
                width: 60%;
                height: 6%;
                font-size: 15px;
                margin: 0% 0% 5% 0%;
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
        <div class="bodyR"> 
            <div class="titleR">Registro de cuenta</div>
            <div align="left">
                <form action="" method="POST">
                    <label class="textR">Nombres y apellidos</label><br>
                    <input class="inputR"name="nombcli" id="nombcli" maxlength="25" minlength="8" type="text" placeholder="Nombres completos"required><br>
                    <label class="textR">Domicilio</label><br>
                    <input class="inputR"name="direccc"maxlength="60" minlength="10" type="text" placeholder="Dirección de domicilio"required><br>
                    <label class="textR">Correo electronico</label><br>
                    <input class="inputR"name="correcli"maxlength="40" minlength="11" type="email" placeholder="Correo electornico"required><br>
                    <label class="textR" >N° Telefono/ Celular</label><br>
                    <input class="inputR" id="telecli" name="telecli"  maxlength="9" minlength="7" placeholder="Telefono ó celular"required><br>
                    <label class="textR" >Usuario</label><br>
                    <input class="inputR"name="usercli"maxlength="20" minlength="5" placeholder="Usuario"required><br>
                    <label class="textR">Contraseña</label><br>
                    <input class="inputR" id="dnic" name="dnic"  maxlength="8" minlength="8" type="password" placeholder="Dni"required><br>
                    <input class="inputR" type="submit" name="accion"value="Registrar">
                </form>
            </div>
        </div>
        <br><br><br><br>


    </body>
    <script>
        $(document).ready(function () {
            $('#dnic,#telecli').keyup(function () {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });
        });
    </script>
    <script>
        $('#nombcli').keydown(function (e) {
            if (e.ctrlKey || e.altKey) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                    e.preventDefault();
                }
            }
        });
    </script>

    <footer>
        <?php
        include './extremos/footer.php';
        ?>
    </footer>
</html>
