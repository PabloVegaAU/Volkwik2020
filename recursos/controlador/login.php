<?php

session_start();
session_regenerate_id();
include '../conexión.php';

$User = $_POST['txtuser'];
$Dni = $_POST['txtpass'];

$sentencia = $conn->prepare("SELECT * FROM empleado WHERE User=:User AND Dni =:Dni");
$sentencia2 = $conn->prepare("SELECT * FROM cliente WHERE User=:User AND Dni =:Dni");
$sentencia->bindParam(':User', $User);
$sentencia->bindParam(':Dni', $Dni);
$sentencia2->bindParam(':User', $User);
$sentencia2->bindParam(':Dni', $Dni);
$sentencia->execute();
$sentencia2->execute();
$empleado = $sentencia->fetch(PDO::FETCH_ASSOC);
$cliente = $sentencia2->fetch(PDO::FETCH_ASSOC);

if ($empleado != null) {
    $_SESSION['usuario'] = $empleado;

    header("location: /Volkwik2020/views/vistasE/admin.php");
} elseif ($cliente != null) {
    $_SESSION['cliente'] = $cliente;

    header("location: /Volkwik2020/views/");
} else {
    header("location: /Volkwik2020/views/");
}
