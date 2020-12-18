<div hidden><?php include '../recursos/conexión.php'; ?></div>
<?php
$idc = (isset($_REQUEST['idc'])) ? $_REQUEST['idc'] : "";
$usercli = (isset($_REQUEST['usercli'])) ? $_REQUEST['usercli'] : "";
$nombcli = (isset($_REQUEST['nombcli'])) ? $_REQUEST['nombcli'] : "";
$direccc = (isset($_REQUEST['direccc'])) ? $_REQUEST['direccc'] : "";
$telecli = (isset($_REQUEST['telecli'])) ? $_REQUEST['telecli'] : "";
$correcli = (isset($_REQUEST['correcli'])) ? $_REQUEST['correcli'] : "";
$fotocli = (isset($_FILES['fotocli']["name"])) ? $_FILES['fotocli']["name"] : "";

$accion = (isset($_REQUEST['accion'])) ? $_REQUEST['accion'] : "";
switch ($accion) {
    case 'Actualizar':

        $sentencia = $conn->prepare("UPDATE cliente SET  User = '" . $usercli . "', Nombres = '" . $nombcli . "', Direccion = '" . $direccc . "', Telefono = '" . $telecli . "', Correo = '" . $correcli . "' WHERE IdCliente= '" . $idc . "'");
        $sentencia->execute();


        $Fecha = new DateTime();
        $nombreArchivo = ($fotocli != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotocli"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotocli"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "vistasE/FotosCli/" . $nombreArchivo);
            $sentencia = $conn->prepare("SELECT Foto FROM cliente WHERE IdCliente = :IdCliente");
            $sentencia->bindParam(':IdCliente', $idc);
            $sentencia->execute();
            $cliente = $sentencia->fetch(PDO::FETCH_LAZY);

            if (isset($cliente["Foto"])) {
                if (file_exists("vistasE/FotosCli/" . $cliente["Foto"])) {
                    if ($cliente["Foto"] != "default.jpg") {
                        unlink("/Volkwik2020/views/vistasE/FotosCli/" . $cliente["Foto"]);
                    }
                }
            }
            $sentencia = $conn->prepare("UPDATE cliente set Foto='" . $nombreArchivo . "'WHERE IdCliente = '" . $idc . "'");
            $sentencia->execute();
        }
        
        header("location: /Volkwik2020/views/");
        break;
}
?>
