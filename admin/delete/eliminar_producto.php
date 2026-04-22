<?php
session_start();
require_once("../../CAD.php");

if(!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] != 1)
{
    header("Location: ../../login_page/login.php");
    exit();
}

$id_prenda = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id_prenda > 0)
{
    $resultado = CAD::eliminarProducto($id_prenda);
    
    if($resultado['success'])
    {
        header("Location: ../dashboard/dashboard.php?mensaje=Producto eliminado correctamente");
    }
    else
    {
        header("Location: ../dashboard/dashboard.php?error=" . urlencode($resultado['message']));
    }
}
else
{
    header("Location: ../dashboard/dashboard.php");
}
exit();
?>
