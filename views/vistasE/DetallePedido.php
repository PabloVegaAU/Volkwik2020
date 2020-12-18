<?php
$idDp = (isset($_POST['idDp'])) ? $_POST['idDp'] : "";
$idPe = (isset($_POST['idPe'])) ? $_POST['idPe'] : "";
$idPro = (isset($_POST['idPro'])) ? $_POST['idPro'] : "";
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : "";
$cant = (isset($_POST['cant'])) ? $_POST['cant'] : "";
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$BAgregar = "";
$BModificar = $BEliminar = $BCancelar = "disabled";
?>
<div hidden><?php include '../../recursos/conexión.php'; ?></div>
<?php
switch ($accion) {
    case "Agregar":
        $sentencia = $conn->prepare("INSERT INTO `detallepedido` (`IdPedido`, `IdProducto`, `Precio`, `Cantidad`, `Descargado`) VALUES (:IdPedido, :IdProducto, :Precio, :Cantidad, :Descargado)");
        $sentencia->bindParam(':IdDP', $idDp);
        $sentencia->bindParam(':IdPedido', $idPe);
        $sentencia->bindParam(':IdProducto', $idPro);
        $sentencia->bindParam(':Precio', $precio);
        $sentencia->bindParam(':Cantidad', $cant);
        $sentencia->bindParam(':Descargado', $estado);
        $sentencia->execute();
        header("location:");
        break;
    case "Editar":
        echo 'Elegir';

        break;

    case "Actualizar":
        $sentencia = $conn->prepare("UPDATE empleado SET Dni=:Dni, Nombres = :Nombres, User = :User, Telefono = :Telefono, Correo = :Correo, Estado = :Estado WHERE IdEmpleado= :IdEmpleado");
        $sentencia->bindParam(':IdPedido', $idPe);
        $sentencia->bindParam(':IdProducto', $idPro);
        $sentencia->bindParam(':Precio', $precio);
        $sentencia->bindParam(':Cantidad', $cant);
        $sentencia->bindParam(':Descargado', $estado);
        $sentencia->bindParam(':IdDP', $idDp);
        $sentencia->execute();
        echo 'Actualizar';
        break;
    case "Eliminar":
        $sentencia = $conn->prepare("SELECT Foto FROM empleado WHERE IdEmpleado = :IdEmpleado");
        $sentencia->bindParam(':IdEmpleado', $ide);
        $sentencia->execute();
        echo 'Eliminar';
        break;
    case"Elegir":
        $BAgregar = "disabled";
        $BModificar = $BEliminar = $BCancelar = "";
        break;
    default:
        break;
}
$sentencia = $conn->prepare("SELECT * FROM `dpedidosv`;");
$sentencia->execute();
$listaDPedido = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
    <body>        

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" hidden>
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
                                            <div class="input-group-text">ID Pedido :<?php echo $idDp ?>
                                                <input type="text" name="idDp" id="idDp" value="<?php echo $idDp ?>" class="form-control" hidden>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>ID Pedido</label>
                                            <input type="text"  value="<?php echo $idPe ?>" name="idPe" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>ID Producto</label>
                                            <input type="text" value="<?php echo $idPro ?>" name="idPro" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Precio Unitario</label>
                                            <input type="text" value="<?php echo $precio ?>" name="precio" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Cantidad</label>
                                            <input type="text" value="<?php echo $cant ?>" name="cant" class="form-control" readonly>
                                        </div>
                                    </div>                        
                                </div>                         
                            </div>
                        </div>
                        <div class="modal-footer">
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
                                <th class="text-primary">ID Pedido</th>
                                <th>Nombre Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                            foreach ($listaDPedido as $dpedido) {
                                ?>
                                <tr>
                                    <td hidden><?php echo $dpedido['IdDP']; ?></td>
                                    <td class="text-danger"><?php echo $dpedido['IdPedido']; ?></td>
                                    <td><?php echo $dpedido['Nombres']; ?></td>
                                    <td><?php echo $dpedido['Precio']; ?></td>
                                    <td><?php echo $dpedido['Cantidad']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th hidden>ID</th>
                                <th class="text-primary">ID Pedido</th>
                                <th>Nombre Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>                  
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
                    "search": {
                        "search": "<?php
                            if (isset($_REQUEST['IDP'])) {
                                echo $_REQUEST['IDP'];
                            };
                            ?>"
                    },
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    }
                });
            });
        </script>
    </body>
</html>
