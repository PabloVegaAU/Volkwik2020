
<?php
session_start();
include '../recursos/conexión.php';
$total = 0;
?>

<html>
    <head>

        <title>Carrito Volkwik</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
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
    <center>
        <div style="width: 70%">
            <table id="example" class="table table-hover">
                <thead>
                <th>Producto</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Eliminar</th>
                </thead>
                <tbody>
                    <?php if (isset($_SESSION["Carrito"])) { ?>
                        <?php
                        foreach ($_SESSION["Carrito"] as $indice => $product) {
                            $total += $product["Cantidad"] * $product["Precio"]
                            ?>
                            <tr>
                                <td><?php echo $product["Nombre"]; ?></td>
                                <td><?php echo $product["Categoria"]; ?></td>
                                <td><?php echo $product["Precio"]; ?></td>
                                <td><?php echo $product["Cantidad"]; ?></td>
                                <td>
                                    <form action="Carrito.php" method="POST">
                                        <input  type="hidden"name="id" value="<?php echo $product["ID"]; ?>">
                                        <button class="btn-danger" type="submit" name="button"value="Eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php
                    } else {
                        echo "<script>alert('Carrito Vacio');</script>";
                    }
                    ?>

                </tbody>
                <?php if (isset($_SESSION["Carrito"])) { ?>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td><?php
                            echo number_format((float) $total, 2, '.', '');
                            $usu = $_SESSION['cliente'];
                            $idc = $usu['IdCliente'];
                            $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
                            switch ($accion) {
                                case 'Pedido':
                                    $sentencia = $conn->prepare("INSERT INTO `pedido` ( `IdCliente`, `Fecha`, `MontoTotal`, `Estado`) VALUES ( :ID, current_timestamp(), :Total, 'Pendiente');");
                                    $sentencia->bindParam(":ID", $idc);
                                    $sentencia->bindParam(":Total", $total);
                                    $sentencia->execute();
                                    $idPedido = $conn->lastInsertId();
                                    foreach ($_SESSION["Carrito"] as $indice => $product) {
                                        $sentencia = $conn->prepare("INSERT INTO `detallepedido` ( `IdPedido`, `IdProducto`, `Precio`, `Cantidad`) VALUES ( :IdPedido, :IdProducto, :Precio, :Cantidad);");
                                        $sentencia->bindParam(":IdPedido", $idPedido);
                                        $sentencia->bindParam(":IdProducto", $product["ID"]);
                                        $sentencia->bindParam(":Precio", $product["Precio"]);
                                        $sentencia->bindParam(":Cantidad", $product["Cantidad"]);
                                        $sentencia->execute();
                                    }
                                    unset($_SESSION["Carrito"]);
                                    echo '<meta http-equiv="refresh" content="0" />';
                                    unset($_SESSION['Carrito'][$indice]);
                                    echo "<script>alert('Pedido Realizado');</script>";
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tfoot>
                <th>Producto</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Eliminar</th>
                </tfoot>
            </table>
            <br><br>
            <div style="justify-content: space-between;display: flex">
                <div><a href="Catalogo.php">Volver al catalogo</a></div>
                <div>
                    <?php if (isset($_SESSION['cliente']) && $total > 0) { ?>
                        <form action="" method="POST">
                            <input type="submit" value="Pedido" name="accion" class="btn btn-warning" style="max-width: 80px">
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </center>
    <?php
    $buttonE = (isset($_POST['button'])) ? $_POST['button'] : "";
    $ID = (isset($_POST['id'])) ? $_POST['id'] : "";
    if ($buttonE == "Eliminar") {
        foreach ($_SESSION["Carrito"] as $indice => $product) {
            if ($product['ID'] == $ID) {
                unset($_SESSION['Carrito'][$indice]);
                echo '<script>alert("Producto Eliminado");</script>';
                echo '<meta http-equiv="refresh" content="0" />';
            }
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity = "sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin = "anonymous"></script>
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
                    "sLengthMenu": "Mostrar _MENU_ compras",
                    "sInfo": "Mostrando productos pedidos (_TOTAL_)",
                    "sInfoEmpty": "Mostrando los productos del carrito",
                    "sProcessing": "Cargando productos...",
                    "sEmptyTable": "Tú carrito esta vacio",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ultimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "pageLength": {
                        "_": "Mostrar %d filas",
                        "-1": "Mostrar Todo"
                    }

                }
            });
        });
    </script>
</body>
</html>
