<?php
$idc = (isset($_POST['idc'])) ? $_POST['idc'] : "";
$dnic = (isset($_POST['dnic'])) ? $_POST['dnic'] : "";
$usercli = (isset($_POST['usercli'])) ? $_POST['usercli'] : "";
$nombcli = (isset($_POST['nombcli'])) ? $_POST['nombcli'] : "";
$direccc = (isset($_POST['direccc'])) ? $_POST['direccc'] : "";
$telecli = (isset($_POST['telecli'])) ? $_POST['telecli'] : "";
$correcli = (isset($_POST['correcli'])) ? $_POST['correcli'] : "";
$comprascli = (isset($_POST['comprascli'])) ? $_POST['comprascli'] : "";
$fotocli = (isset($_FILES['fotocli']["name"])) ? $_FILES['fotocli']["name"] : "";
$estacli = (isset($_POST['estacli'])) ? $_POST['estacli'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

$BAgregar = "";
$BModificar = $BEliminar = $BCancelar = "disabled";
$VModal = false;
?>

<div hidden><?php include '../../recursos/conexión.php'; ?></div>
<?php
switch ($accion) {
    case "Agregar":
        $sentencia = $conn->prepare("INSERT INTO cliente(Dni,User,Nombres,Direccion,Telefono,Correo,Compras,Foto,Estado)VALUES (:Dni,:User,:Nombres,:Direccion,:Telefono,:Correo,:Compras,:Foto,:Estado)");
        $sentencia->bindParam(':Dni', $dnic);
        $sentencia->bindParam(':User', $usercli);
        $sentencia->bindParam(':Nombres', $nombcli);
        $sentencia->bindParam(':Direccion', $direccc);
        $sentencia->bindParam(':Telefono', $telecli);
        $sentencia->bindParam(':Correo', $correcli);
        $sentencia->bindParam(':Compras', $comprascli);
        $Fecha = new DateTime();
        $nombreArchivo = ($fotocli != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotocli"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotocli"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "FotosCli/" . $nombreArchivo);
        }
        $sentencia->bindParam(':Foto', $nombreArchivo);
        $sentencia->bindParam(':Estado', $estacli);
        $sentencia->execute();
        header("location:");
        break;

    case "Actualizar":
        $sentencia = $conn->prepare("UPDATE cliente SET Dni = :Dni, User = :User, Nombres = :Nombres, Direccion = :Direccion, Telefono = :Telefono, Correo = :Correo,Compras = :Compras, Estado = :Estado WHERE IdCliente= :IdCliente");
        $sentencia->bindParam(':Dni', $dnic);
        $sentencia->bindParam(':User', $usercli);
        $sentencia->bindParam(':Nombres', $nombcli);
        $sentencia->bindParam(':Direccion', $direccc);
        $sentencia->bindParam(':Telefono', $telecli);
        $sentencia->bindParam(':Correo', $correcli);
        $sentencia->bindParam(':Compras', $comprascli);
        $sentencia->bindParam(':Estado', $estacli);
        $sentencia->bindParam(':IdCliente', $idc);
        $sentencia->execute();

        $Fecha = new DateTime();
        $nombreArchivo = ($fotocli != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotocli"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotocli"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "FotosCli/" . $nombreArchivo);

            $sentencia = $conn->prepare("SELECT Foto FROM cliente WHERE IdCliente = :IdCliente");
            $sentencia->bindParam(':IdCliente', $idc);
            $sentencia->execute();
            $cliente = $sentencia->fetch(PDO::FETCH_LAZY);

            if (isset($cliente["Foto"])) {
                if (file_exists("FotosCli/" . $cliente["Foto"])) {
                    if ($cliente["Foto"] != "default.jpg") {
                        unlink("FotosCli/" . $cliente["Foto"]);
                    }
                }
            }

            $sentencia = $conn->prepare("UPDATE cliente set Foto=:Foto WHERE IdCliente = :IdCliente");
            $sentencia->bindParam(':Foto', $nombreArchivo);
            $sentencia->bindParam(':IdCliente', $idc);
            $sentencia->execute();
        }


        header("location:");
        break;
    case "Eliminar":
        $sentencia = $conn->prepare("SELECT Foto FROM cliente WHERE IdCliente = :IdCliente");
        $sentencia->bindParam(':IdCliente', $idc);
        $sentencia->execute();
        $cliente = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($cliente["Foto"])) {
            if (file_exists("FotosCli/" . $cliente["Foto"])) {
                if ($cliente["Foto"] != "default.jpg") {
                    unlink("FotosCli/" . $cliente["Foto"]);
                }
            }
        }

        $sentencia = $conn->prepare("DELETE FROM cliente WHERE IdCliente = :IdCliente");
        $sentencia->bindParam(':IdCliente', $idc);
        $sentencia->execute();
        header("location:");

        break;
    case "Cerrar":
        header("location:");
        break;
    case"Elegir":
        $VModal = true;
        $BAgregar = "disabled";
        $BModificar = $BEliminar = $BCancelar = "";
        break;
    default:
        break;
}

$sentencia = $conn->prepare("SELECT * FROM `cliente`");
$sentencia->execute();
$listaCliente = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
    </head>
    <body style="max-width: 100%"> 
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            ACCIONES
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Acciones Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="text" name="idc" id="idc" value="<?php echo $idc ?>" class="form-control" hidden>
                                        <div class="form-group">
                                            <label>DNI</label>
                                            <input type="text" name="dnic" maxlength="8" id="dnic" value="<?php echo $dnic ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" name="usercli" id="usercli" value="<?php echo $usercli ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input type="text" name="nombcli"id="nombcli" value="<?php echo $nombcli ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" name="direccc"id="direccc" value="<?php echo $direccc ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" name="telecli"id="telecli"  maxlength="9"value="<?php echo $telecli ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Correo</label>
                                            <input type="email" name="correcli" maxlength="50"id="correcli" value="<?php echo $correcli ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>N° de Compras</label>
                                            <input type="text" name="comprascli"id="comprascli" value="<?php echo $comprascli ?>"class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Foto</label>
                                            <input type="file" accept="image/*" name="fotocli"id="fotocli" value="<?php echo $fotocli ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control"  name="estacli"id="estacli" value="<?php echo $estacli ?>" required>
                                                <option value="Habilitado">Habilitado</option>
                                                <option value="No Habilitado">No Habilitado</option>
                                            </select>
                                        </div>                        
                                    </div>                         
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Agregar"<?php echo $BAgregar; ?> name="accion" class="btn btn-primary">
                            <input type="submit" value="Actualizar"<?php echo $BModificar; ?> name="accion" class="btn btn-success">
                            <input type="submit" value="Eliminar"<?php echo $BEliminar; ?> name="accion" class="btn btn-danger">
                        </div>
                    </form>
                    <form action="" method="POST" style="padding: 0px;margin: 0px">
                        <button type="submit" value="Cerrar" name="accion" class="btn btn-secondary" style="width: 100%">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="d-flex">
            
                <div class="card">
                    <div class="card-body">
                        <table id="example" class="table table-hover">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Dni</th>
                                    <th>Usuario</th>
                                    <th>Nombres</th>
                                    <th>Direcciónn</th>
                                    <th>Telefono</th>
                                    <th>Correo Electronico</th>
                                    <th>N° Pedidos</th>
                                    <th>Foto</th>      
                                    <th>Estado</th> 
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($listaCliente as $cliente) { ?>
                                    <tr>
                                        <td hidden><?php echo $cliente['IdCliente']; ?></td>                                      
                                        <td><?php echo $cliente['Dni']; ?></td>
                                        <td><?php echo $cliente['User']; ?></td>
                                        <td><?php echo $cliente['Nombres']; ?></td>
                                        <td><?php echo $cliente['Direccion']; ?></td>
                                        <td><?php echo $cliente['Telefono']; ?></td>
                                        <td><?php echo $cliente['Correo']; ?></td>
                                        <td><?php echo $cliente['Compras']; ?></td>
                                        <td><img class="img-thumbnail" src="FotosCli/<?php echo $cliente['Foto']; ?>" width="100" height="100" alt="<?php echo $cliente['Nombres']; ?>"/></td>
                                        <td><?php echo $cliente['Estado']; ?></td>                                        
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="idc" value="<?php echo $cliente['IdCliente']; ?>">
                                                <input type="hidden" name="dnic" value="<?php echo $cliente['Dni']; ?>">
                                                <input type="hidden" name="usercli" value="<?php echo $cliente['User']; ?>">
                                                <input type="hidden" name="nombcli"value="<?php echo $cliente['Nombres']; ?>">
                                                <input type="hidden" name="direccc"value="<?php echo $cliente['Direccion']; ?>">
                                                <input type="hidden" name="telecli"value="<?php echo $cliente['Telefono']; ?>">
                                                <input type="hidden" name="correcli"value="<?php echo $cliente['Correo']; ?>">
                                                <input type="hidden" name="comprascli"value="<?php echo $cliente['Compras']; ?>">
                                                <input type="hidden" name="fotocli"value="<?php echo $cliente['Foto']; ?>">
                                                <input type="hidden" name="estacli"value="<?php echo $cliente['Estado']; ?>">
                                                <input type="submit" value="Elegir" name="accion" class="btn btn-warning" style="max-width: 80px">
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Dni</th>
                                    <th>Usuario</th>
                                    <th>Nombres</th>
                                    <th>Direcciónn</th>
                                    <th>Telefono</th>
                                    <th>Correo Electronico</th>
                                    <th>N° Pedidos</th>
                                    <th>Foto</th>      
                                    <th>Estado</th> 
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#example').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    }
                });
            });
            $('#telecli,#comprascli,#dnic').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        </script>
    </body>
</html>

