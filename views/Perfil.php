<div hidden><?php include '../recursos/conexión.php'; ?></div>
<?php
session_start();

if (!isset($_SESSION['cliente'])) {
    header("location: /Volkwik2020/views/");
}
?>
<html>
    <head>
        <title>Mi Perfil Volkwik</title>
        <meta charset="UTF-8" http-equiv="Refresh">
        <style >
            .bodyF{
                width: 60%;
                border: solid black 1px;
                position: static;
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
            }
            .bodyF input{
                background: rgb(196,213,218);
                background: -moz-linear-gradient(90deg, rgba(196,213,218,1) 18%, rgba(101,232,237,1) 70%);
                background: -webkit-linear-gradient(90deg, rgba(196,213,218,1) 18%, rgba(101,232,237,1) 70%);
                background: linear-gradient(90deg, rgba(196,213,218,1) 18%, rgba(101,232,237,1) 70%);
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#c4d5da",endColorstr="#65e8ed",GradientType=1);
                font-size: 15px;
            }
            .bodyF input:hover{
                cursor: pointer;
            }
        </style>
    </head>
    <header>
        <?php
        if (isset($_SESSION['usuario'])) {
            include './extremos/headerAdmin.php';
            $usu = $_SESSION['usuario'];
        } elseif (isset($_SESSION['cliente'])) {
            include './extremos/headercli.php';
            $usu = $_SESSION['cliente'];
        } else {
            include './extremos/header.php';
        }
        ?>
    </header>
    <body>
        <br>
        <form action="EditPerfil.php" method="POST" enctype="multipart/form-data">
            <div align="center">
                <div class="bodyF">
                    <h1>Mi Perfil</h1>
                    <?php foreach ($Cliente as $cliente) { ?>
                        <div style="justify-content: space-between;display: flex;">
                            <div style="padding-left: 10%" align="left">
                                <h1>Mis Datos</h1>
                                <div hidden>Mi ID:<br> <input name = "idc" id = "idc" value = "<?php echo $cliente['IdCliente'] ?>" hidden></div><br>
                                Mi Usuario:<br> <input name = "usercli" id = "usercli" value = "<?php echo $cliente['User'] ?>"><br>
                                Mi Nombre:<br> <input name = "nombcli" id = "nombcli" value = "<?php echo $cliente['Nombres'] ?>"><br>
                                Mi Dni/ Password:<br> <input value = "<?php echo $cliente['Dni'] ?>" disabled><br>
                                Mi Dirección:<br> <input name = "direccc" id = "direccc" value = "<?php echo $cliente['Direccion'] ?>" ><br>
                                Mi Telefono/ Celular:<br> <input name = "telecli"id = "telecli" value = "<?php echo $cliente['Telefono'] ?>"><br>
                                Mi Correo:<br> <input name = "correcli" type="email" id = "correcli" value = "<?php echo $cliente['Correo'] ?>"><br>
                                Cantidad de Compras:<br> <input value = "<?php echo $cliente['Compras'] ?>" disabled>
                            </div>
                            <div style = "padding-right: 10%">
                                <br><br><br>
                                <img class = "img-thumbnail" src = "vistasE/FotosCli/<?php echo $cliente['Foto']; ?>" width = "300" height = "340" alt = "<?php echo $cliente['Nombres']; ?>"/><br>
                                <input type = "file" accept = "image/*" name = "fotocli"id = "fotocli" value = "<?php echo $fotocli ?>" class = "form-control" >
                            </div>
                        </div>
                        <?php } ?>
                    <<br><br>
                    <input type = "submit"value = "Actualizar" name = "accion">
                </div>
            </div>
        </form>
    </body>
</html>
