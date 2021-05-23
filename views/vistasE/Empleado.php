<?php
$ide = (isset($_POST['ide'])) ? $_POST['ide'] : "";
$dnie = (isset($_POST['dnie'])) ? $_POST['dnie'] : "";
$nombrese = (isset($_POST['nombrese'])) ? $_POST['nombrese'] : "";
$usere = (isset($_POST['usere'])) ? $_POST['usere'] : "";
$tele = (isset($_POST['tele'])) ? $_POST['tele'] : "";
$corree = (isset($_POST['corree'])) ? $_POST['corree'] : "";
$fotoe = (isset($_FILES['fotoe']["name"])) ? $_FILES['fotoe']["name"] : "";
$este = (isset($_POST['este'])) ? $_POST['este'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$BAgregar = "";
$BModificar = $BEliminar = $BCancelar = "disabled";
$VModal = false;
?>
<div hidden><?php include '../../recursos/conexión.php'; ?></div>
<?php
switch ($accion) {
    case "Agregar":
        $sentencia = $conn->prepare("INSERT INTO empleado(Dni,Nombres,User,Telefono,Correo,Foto,Estado)VALUES (:Dni,:Nombres,:User,:Telefono,:Correo,:Foto,:Estado)");
        $sentencia->bindParam(':Dni', $dnie);
        $sentencia->bindParam(':Nombres', $nombrese);
        $sentencia->bindParam(':User', $usere);
        $sentencia->bindParam(':Telefono', $tele);
        $sentencia->bindParam(':Correo', $corree);

        $Fecha = new DateTime();
        $nombreArchivo = ($fotoe != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotoe"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotoe"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "FotosEmp/" . $nombreArchivo);
        }
        $sentencia->bindParam(':Foto', $nombreArchivo);

        $sentencia->bindParam(':Estado', $este);
        $sentencia->execute();
        header("location:");
        break;

    case "Actualizar":
        $sentencia = $conn->prepare("UPDATE empleado SET Dni=:Dni, Nombres = :Nombres, User = :User, Telefono = :Telefono, Correo = :Correo, Estado = :Estado WHERE IdEmpleado= :IdEmpleado");
        $sentencia->bindParam(':Dni', $dnie);
        $sentencia->bindParam(':Nombres', $nombrese);
        $sentencia->bindParam(':User', $usere);
        $sentencia->bindParam(':Telefono', $tele);
        $sentencia->bindParam(':Correo', $corree);
        $sentencia->bindParam(':Estado', $este);
        $sentencia->bindParam(':IdEmpleado', $ide);
        $sentencia->execute();

        $Fecha = new DateTime();
        $nombreArchivo = ($fotoe != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotoe"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotoe"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "FotosEmp/" . $nombreArchivo);

            $sentencia = $conn->prepare("SELECT Foto FROM empleado WHERE IdEmpleado = :IdEmpleado");
            $sentencia->bindParam(':IdEmpleado', $ide);
            $sentencia->execute();
            $empleadoA = $sentencia->fetch(PDO::FETCH_LAZY);

            if (isset($empleadoA["Foto"])) {
                if (file_exists("FotosEmp/" . $empleadoA["Foto"])) {
                    unlink("FotosEmp/" . $empleadoA["Foto"]);
                }
            }

            $sentencia = $conn->prepare("UPDATE empleado set Foto=:Foto WHERE IdEmpleado = :IdEmpleado");
            $sentencia->bindParam(':Foto', $nombreArchivo);
            $sentencia->bindParam(':IdEmpleado', $ide);
            $sentencia->execute();
        }

        break;
    case "Eliminar":
        $sentencia = $conn->prepare("SELECT Foto FROM empleado WHERE IdEmpleado = :IdEmpleado");
        $sentencia->bindParam(':IdEmpleado', $ide);
        $sentencia->execute();
        $producto = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($producto["Foto"])) {
            if (file_exists("FotosEmp/" . $producto["Foto"])) {
                unlink("FotosEmp/" . $producto["Foto"]);
            }
        }

        $sentencia = $conn->prepare("DELETE FROM empleado WHERE IdEmpleado = :IdEmpleado");
        $sentencia->bindParam(':IdEmpleado', $ide);
        $sentencia->execute();

        break;
    case"Elegir":
        $VModal = true;
        $BAgregar = "disabled";
        $BModificar = $BEliminar = $BCancelar = "";
        break;
    default:
        break;
}

$sentencia = $conn->prepare("SELECT * FROM `empleado`");
$sentencia->execute();
$listaEmpleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
    <head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
    </head>
    <body>        

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            ACCIONES
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Acciones Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group" hidden>
                                            <div class="input-group-text">ID Empleado :<?php echo $ide ?>
                                                <input type="text" name="ide" id="ide" value="<?php echo $ide ?>" class="form-control" hidden>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Dni</label>
                                            <input type="text"  value="<?php echo $dnie ?>" name="dnie" id="dnie" minlength="8" maxlength="9"class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input type="text" value="<?php echo $nombrese ?>" name="nombrese" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" value="<?php echo $usere ?>" name="usere" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" value="<?php echo $tele ?>" name="tele" id="tele" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Correo Electronico</label>
                                            <input type="text" value="<?php echo $corree ?>" name="corree" class="form-control"required>
                                        </div>
                                        <div class="form-group">
                                            <label>Foto</label>
                                            <input type="file" accept="image/*" value="<?php echo $fotoe ?>" name="fotoe" class="form-control">
                                        </div>
                                        <label>Estado</label>
                                        <select class="form-control"  name="este"id="epro" value="<?php echo $este ?>" required>
                                            <option value="Habilitado">Habilitado</option>
                                            <option value="No Habilitado">No Habilitado</option>
                                        </select>
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
        <br><br>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table table-hover">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>DNI</th>
                                <th>NOMBRES</th>
                                <th>USER</th>
                                <th>TELEFONO</th>
                                <th>CORREO</th>
                                <th>FOTO</th>
                                <th>ESTADO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach ($listaEmpleados as $empleado) { ?>
                                <tr>
                                    <td hidden><?php echo $empleado['IdEmpleado']; ?></td>
                                    <td><?php echo $empleado['Dni']; ?></td>
                                    <td><?php echo $empleado['Nombres']; ?></td>
                                    <td><?php echo $empleado['User']; ?></td>
                                    <td><?php echo $empleado['Telefono']; ?></td>
                                    <td><?php echo $empleado['Correo']; ?></td>
                                    <td><img class="img-thumbnail" src="FotosEmp/<?php echo $empleado['Foto']; ?>" width="100" height="100" alt="<?php echo $empleado['Nombres']; ?>"/></td>
                                    <td><?php echo $empleado['Estado']; ?></td>

                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="ide" value="<?php echo $empleado['IdEmpleado']; ?>">
                                            <input type="hidden" name="dnie" value="<?php echo $empleado['Dni']; ?>">
                                            <input type="hidden" name="nombrese" value="<?php echo $empleado['Nombres']; ?>">
                                            <input type="hidden" name="usere"value="<?php echo $empleado['User']; ?>">
                                            <input type="hidden" name="tele"value="<?php echo $empleado['Telefono']; ?>">
                                            <input type="hidden" name="corree"value="<?php echo $empleado['Correo']; ?>">
                                            <input type="hidden" name="ncomp"value="<?php echo $empleado['Compras']; ?>">
                                            <input type="hidden" name="fotoe"value="<?php echo $empleado['Foto']; ?>">
                                            <input type="hidden" name="este"value="<?php echo $empleado['Estado']; ?>">
                                            <input type="submit" value="Elegir" name="accion" data-toggle="modal" data-target="#exampleModal"   class="btn btn-warning" style="max-width: 80px">
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th hidden>ID</th>
                                <th>DNI</th>
                                <th>NOMBRES</th>
                                <th>USER</th>
                                <th>TELEFONO</th>
                                <th>CORREO</th>
                                <th>FOTO</th>
                                <th>ESTADO</th>
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
                    }});
            });
            $('#dnie,#tele').on('input', function () {
                this.value = this.value.replace(/[^0-9.]/g, '').replace();
            });
        </script>
    </body>
</html>
