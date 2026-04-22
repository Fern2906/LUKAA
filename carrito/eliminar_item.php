<?php
session_start();
require_once("../CAD.php");

if(!isset($_SESSION['usuario_id']))
{
    header("Location: ../login_page/login.php");
    exit();
}

$id_carrito = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id_carrito > 0)
{
    CAD::eliminarDelCarrito($id_carrito);
}

header("Location: carrito.php");
exit();
?>
