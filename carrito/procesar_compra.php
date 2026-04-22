<?php
session_start();
require_once("../CAD.php");

if(!isset($_SESSION['usuario_id']))
{
    header("Location: ../login_page/login.php");
    exit();
}

$resultado = CAD::realizarCompra($_SESSION['usuario_id']);

if($resultado['success'])
{
    header("Location: ../historial/historial.php?mensaje=Compra realizada exitosamente");
}
else
{
    header("Location: carrito.php?error=" . urlencode($resultado['message']));
}
exit();
?>
