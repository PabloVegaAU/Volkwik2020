<?php
$idpe = (isset($_POST['idpe'])) ? $_POST['idpe'] : "";
$idc = (isset($_POST['idc'])) ? $_POST['idc'] : "";
$direcc = (isset($_POST['direcc'])) ? $_POST['direcc'] : "";
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : "";
$cdelivery= (isset($_POST['cdelivery'])) ? $_POST['cdelivery'] : "";
$mont = (isset($_POST['mont'])) ? $_POST['mont'] : "";
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

$acciones = "hidden";
$BModificar = $BEliminar = $BCancelar = "disabled";
?>

<div hidden><?php include '../../recursos/conexión.php'; ?></div>
<?php
switch ($accion) {
    case "Actualizar":
        $sentencia = $conn->prepare("UPDATE pedido SET CostoDelivery=:CostoDelivery ,Estado=:Estado  WHERE IdPedido= :IdPedido");
        $sentencia->bindParam(':CostoDelivery', $cdelivery);
        $sentencia->bindParam(':Estado', $estado);
        $sentencia->bindParam(':IdPedido', $idpe);
        $sentencia->execute();
        header("location:");
        break;
    case "Eliminar":
        $sentencia = $conn->prepare("DELETE FROM producto WHERE IdProducto = :IdProducto");
        $sentencia->bindParam(':IdPedido', $idp);
        $sentencia->execute();
        header("location:");

        break;
    case "Cerrar":
        header("location:");
        break;
    case"Elegir":
        $acciones = "";
        $BModificar = $BEliminar = $BCancelar = "";
        break;
    default:
        break;
}

$sentencia = $conn->prepare("SELECT * FROM `pedidosv`");
$sentencia->execute();
$listaPedido = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
        <button type="button" <?php echo $acciones ?> class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
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
                                            <div class="input-group-text">ID Pedido :<?php echo $idpe ?>
                                                <input type="text" name="idpe" id="idpe" value="<?php echo $idpe ?>" class="form-control" hidden>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre del cliente</label>
                                            <input type="text"  value="<?php echo $idc ?>" name="idc" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Dirección del Cliente</label>
                                            <input type="text"  value="<?php echo $direcc ?>" name="direcc" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input type="text" value="<?php echo $fecha ?>" name="fecha" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Costo delivery</label>
                                            <input type="text" value="<?php echo $cdelivery ?>" name="cdelivery" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Monto Total</label>
                                            <input type="text" value="<?php echo $mont ?>" name="mont" class="form-control" readonly>
                                        </div>
                                        <label>Estado</label>
                                        <select class="form-control"  name="estado"id="estado" value="<?php echo $estado ?>" required>
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="En Camino">En Camino</option>
                                            <option value="Entregado">Entregado</option>
                                        </select>
                                    </div>                        
                                </div>                         
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Actualizar"<?php echo $BModificar; ?> name="accion" class="btn btn-success">
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
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Direccion</th>
                                <th>Fecha</th>
                                <th>Costo Delivery</th>
                                <th>Monto Total</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach ($listaPedido as $pedido) { ?>
                                <tr>
                                    <td><a href="./DetallePedido.php?IDP=<?php echo $pedido['IdPedido']; ?>"><?php echo $pedido['IdPedido']; ?></a></td>
                                    <td><?php echo $pedido['Nombres']; ?></td>
                                    <td><?php echo $pedido['Direccion']; ?></td>
                                    <td><?php echo $pedido['Fecha']; ?></td>
                                    <td><?php echo $pedido['CostoDelivery']; ?></td>
                                    <td><?php echo $pedido['MontoTotal']; ?></td>
                                    <td><?php echo $pedido['Estado']; ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="idpe" value="<?php echo $pedido['IdPedido']; ?>">
                                            <input type="hidden" name="idc" value="<?php echo $pedido['Nombres']; ?>">
                                            <input type="hidden" name="direcc" value="<?php echo $pedido['Direccion']; ?>">
                                            <input type="hidden" name="fecha" value="<?php echo $pedido['Fecha']; ?>">
                                            <input type="hidden" name="cdelivery"value="<?php echo $pedido['CostoDelivery']; ?>">
                                            <input type="hidden" name="mont"value="<?php echo $pedido['MontoTotal']; ?>">
                                            <input type="hidden" name="estado"value="<?php echo $pedido['Estado']; ?>">
                                            <input type="submit" value="Elegir" name="accion" data-toggle="modal" data-target="#exampleModal"   class="btn btn-warning" style="max-width: 80px">
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Direccion</th>
                                <th>Fecha</th>
                                <th>Costo Delivery</th>
                                <th>Monto Total</th>
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
                    }});
            });
        </script>
    </body>
</html>
