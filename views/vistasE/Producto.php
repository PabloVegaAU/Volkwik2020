<?php
$idp = (isset($_POST['idp'])) ? $_POST['idp'] : "";
$nomp = (isset($_POST['nomp'])) ? $_POST['nomp'] : "";
$prep = (isset($_POST['prep'])) ? $_POST['prep'] : "";
$stockp = (isset($_POST['stockp'])) ? $_POST['stockp'] : "";
$fotop = (isset($_FILES['fotop']["name"])) ? $_FILES['fotop']["name"] : "";
$catp = (isset($_POST['catp'])) ? $_POST['catp'] : "";
$prepp = (isset($_POST['prepp'])) ? $_POST['prepp'] : "";
$epp = (isset($_POST['epp'])) ? $_POST['epp'] : "";
$vpro = (isset($_POST['vpro'])) ? $_POST['vpro'] : "";
$epro = (isset($_POST['epro'])) ? $_POST['epro'] : "";
$spro = (isset($_POST['spro'])) ? $_POST['spro'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

$BAgregar = "";
$BModificar = $BEliminar = $BCancelar = "disabled";
$VModal = false;
?>

<div hidden><?php include '../../recursos/conexión.php'; ?></div>
<?php
switch ($accion) {
    case "Agregar":
        $sentencia = $conn->prepare("INSERT INTO producto(Nombres,Precio,Stock,Foto,Categoria,PrecioP,EnPromo,Ventas,Estado,PromoSema)VALUES (:Nombres,:Precio,:Stock,:Foto,:Categoria,:PrecioP,:EnPromo,:Ventas,:Estado,:PromoSema)");
        $sentencia->bindParam(':Nombres', $nomp);
        $sentencia->bindParam(':Precio', $prep);
        $sentencia->bindParam(':Stock', $stockp);

        $Fecha = new DateTime();
        $nombreArchivo = ($fotop != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotop"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotop"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "FotosPro/" . $nombreArchivo);
        }
        $sentencia->bindParam(':Foto', $nombreArchivo);

        $sentencia->bindParam(':Categoria', $catp);
        $sentencia->bindParam(':PrecioP', $prepp);
        $sentencia->bindParam(':EnPromo', $epp);
        $sentencia->bindParam(':Ventas', $vpro);
        $sentencia->bindParam(':Estado', $epro);
        $sentencia->bindParam(':PromoSema', $spro);
        $sentencia->execute();
        header("location:");
        break;

    case "Actualizar":
        $sentencia = $conn->prepare("UPDATE producto SET Nombres = :Nombres, Precio = :Precio, Stock = :Stock, Categoria = :Categoria, PrecioP = :PrecioP, EnPromo = :EnPromo,Ventas=:Ventas, Estado = :Estado,PromoSema=:PromoSema WHERE IdProducto = :IdProducto");
        $sentencia->bindParam(':Nombres', $nomp);
        $sentencia->bindParam(':Precio', $prep);
        $sentencia->bindParam(':Stock', $stockp);
        $sentencia->bindParam(':Categoria', $catp);
        $sentencia->bindParam(':PrecioP', $prepp);
        $sentencia->bindParam(':EnPromo', $epp);
        $sentencia->bindParam(':Ventas', $vpro);
        $sentencia->bindParam(':Estado', $epro);
        $sentencia->bindParam(':PromoSema', $spro);
        $sentencia->bindParam(':IdProducto', $idp);
        $sentencia->execute();

        $Fecha = new DateTime();
        $nombreArchivo = ($fotop != "") ? $Fecha->getTimestamp() . "_" . $_FILES["fotop"]["name"] : "default.jpg";
        $tmpFoto = $_FILES["fotop"]["tmp_name"];
        if ($tmpFoto != "") {
            move_uploaded_file($tmpFoto, "FotosPro/" . $nombreArchivo);

            $sentencia = $conn->prepare("SELECT Foto FROM producto WHERE IdProducto = :IdProducto");
            $sentencia->bindParam(':IdProducto', $idp);
            $sentencia->execute();
            $producto = $sentencia->fetch(PDO::FETCH_LAZY);

            if (isset($producto["Foto"])) {
                if (file_exists("FotosPro/" . $producto["Foto"])) {
                    if ($producto["Foto"] != "default.jpg") {
                        unlink("FotosPro/" . $producto["Foto"]);
                    }
                }
            }

            $sentencia = $conn->prepare("UPDATE producto set Foto=:Foto WHERE IdProducto = :IdProducto");
            $sentencia->bindParam(':Foto', $nombreArchivo);
            $sentencia->bindParam(':IdProducto', $idp);
            $sentencia->execute();
        }


        header("location:");
        break;
    case "Eliminar":
        $sentencia = $conn->prepare("SELECT Foto FROM producto WHERE IdProducto = :IdProducto");
        $sentencia->bindParam(':IdProducto', $idp);
        $sentencia->execute();
        $producto = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($producto["Foto"])) {
            if (file_exists("FotosPro/" . $producto["Foto"])) {
                if ($producto["Foto"] != "default.jpg") {
                    unlink("FotosPro/" . $producto["Foto"]);
                }
            }
        }

        $sentencia = $conn->prepare("DELETE FROM producto WHERE IdProducto = :IdProducto");
        $sentencia->bindParam(':IdProducto', $idp);
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

$sentencia = $conn->prepare("SELECT * FROM `producto`");
$sentencia->execute();
$listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
                                        <input type="text" name="idp" id="idp" value="<?php echo $idp ?>" class="form-control" hidden>
                                        <div class="form-group">
                                            <label>Producto</label>
                                            <input type="text" name="nomp"id="nomp" value="<?php echo $nomp ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Precio</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-text">S/. </div>
                                                <input type="text"name="prep"id="prep" value="<?php echo $prep ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Stock</label>
                                            <input type="text" name="stockp"id="stockp" value="<?php echo $stockp ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Foto</label>
                                            <input type="file" accept="image/*" name="fotop"id="fotop" value="<?php echo $fotop ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label>Categoria</label>
                                            <select class="form-control"  name="catp"id="catp" value="<?php echo $catp ?>" required>
                                                <?php if ($catp == "Audifonos") { ?>
                                                    <option value="<?php echo $catp ?>"><?php echo $catp ?></option>
                                                    <option value="Smart Watch">Smart Watch</option>
                                                    <option value="Microfono">Microfono</option>
                                                <?php } elseif ($catp == "Smart Watch") { ?>
                                                    <option value="<?php echo $catp ?>"><?php echo $catp ?></option>
                                                    <option value="Audifonos">Audifonos</option>
                                                    <option value="Microfono">Microfono</option>
                                                <?php } elseif ($catp == "Microfono") { ?>
                                                    <option value="<?php echo $catp ?>"><?php echo $catp ?></option>
                                                    <option value="Audifonos">Audifonos</option>
                                                    <option value="Smart Watch">Smart Watch</option>
                                                <?php } else { ?>
                                                    <option value="Audifonos">Audifonos</option>
                                                    <option value="Smart Watch">Smart Watch</option>   
                                                    <option value="Microfono">Microfono</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Precio Promo</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-text">S/. </div>
                                                <input type="text" name="prepp"id="prepp" value="<?php echo $prepp ?>"class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>En Promo</label>
                                            <select class="form-control"  name="epp"id="epp" value="<?php echo $epp ?>" required>
                                                <?php if ($epp == "Si") { ?>
                                                    <option value="<?php echo $epp ?>"><?php echo $epp ?></option>
                                                    <option value="No">No</option>
                                                <?php } elseif ($epp == "No") { ?>
                                                    <option value="<?php echo $epp ?>"><?php echo $epp ?></option>
                                                    <option value="Si">Si</option>
                                                <?php } else { ?>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pedidos</label>
                                            <input type="text" name="vpro"id="vpro" value="<?php echo $vpro ?>" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control"  name="epro"id="epro" value="<?php echo $epro ?>" required>
                                                <?php if ($epro == "Habilitado") { ?>
                                                    <option value="<?php echo $epro ?>"><?php echo $epro ?></option>
                                                    <option value="No Habilitado">No Habilitado</option>
                                                <?php } elseif ($epro == "No Habilitado") { ?>
                                                    <option value="<?php echo $epro ?>"><?php echo $epro ?></option>
                                                    <option value="Habilitado">Habilitado</option>
                                                <?php } else { ?>
                                                    <option value="Habilitado">Habilitado</option>
                                                    <option value="No Habilitado">No Habilitado</option>
                                                <?php } ?>
                                            </select>
                                        </div>       
                                        <div class="form-group">
                                            <label>Promo Semanal</label>
                                            <select class="form-control"  name="spro"id="spro" value="<?php echo $spro ?>" required>
                                                <?php if ($spro == "Semanal") { ?>
                                                    <option value="<?php echo $spro ?>"><?php echo $spro ?></option>
                                                    <option value="No Semanal">No Semanal</option>
                                                <?php } elseif ($spro == "No Semanal") { ?>
                                                    <option value="<?php echo $spro ?>"><?php echo $spro ?></option>
                                                    <option value="Semanal">Semanal</option>
                                                <?php } else { ?>
                                                    <option value="Semanal">Semanal</option>
                                                    <option value="No Semanal">No Semanal</option>
                                                <?php } ?>
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example" class="table table-hover">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Nombres</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Foto</th>
                                    <th>Categoria</th>
                                    <th>Precio Promo</th>
                                    <th>Estado Promo</th>
                                    <th>Pedidos</th>
                                    <th>ESTADO</th>
                                    <th>Promo Semanal</th> 
                                    <th></th>                                   
                                </tr>
                            </thead>
                            <tbody> 
                                <?php foreach ($listaProductos as $producto) { ?>
                                    <tr>
                                        <td hidden><?php echo $producto['IdProducto']; ?></td>                                      
                                        <td><?php echo $producto['Nombres']; ?></td>
                                        <td><?php echo $producto['Precio']; ?></td>
                                        <td><?php echo $producto['Stock']; ?></td>
                                        <td><img class="img-thumbnail" src="FotosPro/<?php echo $producto['Foto']; ?>" width="100" height="100" alt="<?php echo $producto['Nombres']; ?>"/></td>
                                        <td><?php echo $producto['Categoria']; ?></td>
                                        <td><?php echo $producto['PrecioP']; ?></td>
                                        <td><?php echo $producto['EnPromo']; ?></td>
                                        <td><?php echo $producto['Ventas']; ?></td>
                                        <td><?php echo $producto['Estado']; ?></td>           
                                        <td><?php echo $producto['PromoSema']; ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="idp" value="<?php echo $producto['IdProducto']; ?>">
                                                <input type="hidden" name="nomp" value="<?php echo $producto['Nombres']; ?>">
                                                <input type="hidden" name="prep" value="<?php echo $producto['Precio']; ?>">
                                                <input type="hidden" name="stockp"value="<?php echo $producto['Stock']; ?>">
                                                <input type="hidden" name="fotop"value="<?php echo $producto['Foto']; ?>">
                                                <input type="hidden" name="catp"value="<?php echo $producto['Categoria']; ?>">
                                                <input type="hidden" name="prepp"value="<?php echo $producto['PrecioP']; ?>">
                                                <input type="hidden" name="epp"value="<?php echo $producto['EnPromo']; ?>">
                                                <input type="hidden" name="vpro"value="<?php echo $producto['Ventas']; ?>">
                                                <input type="hidden" name="epro"value="<?php echo $producto['Estado']; ?>">
                                                <input type="hidden" name="spro"value="<?php echo $producto['PromoSema']; ?>">
                                                <input type="submit" value="Elegir" name="accion" class="btn btn-warning" style="max-width: 80px">
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Nombres</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Foto</th>
                                    <th>Categoria</th>
                                    <th>Precio Promo</th>
                                    <th>Estado Promo</th>
                                    <th>Pedidos</th>
                                    <th>ESTADO</th>    
                                    <th>Promo Semanal</th> 
                                    <th></th>                                
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
            $('#prepp,#prep').on('input', function () {
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/,/g, '.');
            });
        </script>
    </body>
</html>

