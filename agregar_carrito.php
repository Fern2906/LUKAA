<?php
session_start();
require_once("CAD.php");

if(!isset($_SESSION['usuario_id']))
{
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id_prenda = isset($_POST['id_prenda']) ? intval($_POST['id_prenda']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
    $talla = isset($_POST['talla']) ? $_POST['talla'] : '';
    
    if($id_prenda > 0 && !empty($talla))
    {
        $resultado = CAD::agregarAlCarrito($_SESSION['usuario_id'], $id_prenda, $cantidad, $talla);
        echo json_encode($resultado);
    }
    else
    {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
}
else
{
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
