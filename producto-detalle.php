<?php
session_start();
require_once "CAD.php";

if(!isset($_GET['id'])) {
    header("Location: main_page/index.php");
    exit();
}

$id_producto = intval($_GET['id']);
$producto = CAD::obtenerProductoPorId($id_producto);

if(!$producto) {
    header("Location: main_page/index.php");
    exit();
}

$mostrar_regresar = true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre_prenda']); ?> - LUKA</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
    <?php include('components/header/header.php'); ?>
    <?php include('components/product-detail/product-detail.php'); ?>
    <?php include('components/footer/footer.php'); ?>
</body>
</html>
