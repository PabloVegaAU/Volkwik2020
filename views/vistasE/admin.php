<?php
session_start();
$usu = $_SESSION['usuario'];
if ($_SESSION['usuario'] == null) {
    header("location: http://localhost/Volkwik2020/views/");
};
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
if ($accion == 'Salir') {
    header("location: http://localhost/Volkwik2020/views/");
    session_destroy();
};
include '../../recursos/conexión.php';
$sentencia = $conn->prepare("SELECT * FROM `empleado` where IdEmpleado=:IdEmpleado");
$sentencia->bindParam(':IdEmpleado', $usu['IdEmpleado']);
$sentencia->execute();
$Empleado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Mantenimiento</title>
        <style>
            *{padding: 0;
              margin: 0;}
            </style>
        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-light bg-info">           
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a style="margin-left: 10px; border: none" class="btn btn-outline-light"  href="../index.php">Volkwik</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left: 10px; border: none" class="btn btn-outline-light" href="Producto.php" target="myFrame">Producto</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left: 10px; border: none" class="btn btn-outline-light" href="Empleado.php" target="myFrame">Empleado</a>
                    </li>
                    <li  class="nav-item">
                        <a style="margin-left: 10px; border: none" class="btn btn-outline-light" href="Clientes.php" target="myFrame">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left: 10px; border: none" class="btn btn-outline-light" href="Pedidos.php" target="myFrame">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left: 10px; border: none" class="btn btn-outline-light" href="DetallePedido.php" target="myFrame">Detalle Pedido</a>
                    </li>

                </ul>                
            </div>
            <div class="dropdown">
                <button style="border: none" class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    foreach ($Empleado as $lempleado) {
                        echo $lempleado['Nombres'];
                        ?>
                    </button>
                    <div class="dropdown-menu text-center" style="margin-left:-8px">
                        <br>
                        <img class="img-thumbnail" src="FotosEmp/<?php echo $lempleado['Foto']; ?>" width="100" height="100" alt="<?php echo $lempleado['Nombres']; ?>"/>
                        <br>
                        <label class="dropdown-item" ><?php echo $lempleado['User']; ?></label>
                        <label class="dropdown-item" ><?php echo $lempleado['Telefono']; ?></label>
                        <label class="dropdown-item" ><?php echo $lempleado['Correo']; ?></label>
                        <?php } ?>
                    <form action="" method="post">
                        <input type="submit" value="Salir" name="accion" class="dropdown-item" >
                    </form>
                </div>
            </div>
        </nav>
        <div class="embed-responsives m-4" style="height: 530px;">
            <iframe class="embed-responsive-item" name="myFrame"  style="height: 100%; width: 100%; border:navy"></iframe>
        </div>   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
