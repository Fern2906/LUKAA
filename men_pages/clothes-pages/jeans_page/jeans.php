<?php
session_start();
require_once "../../../CAD.php";

$mostrar_regresar = true;
$ruta_regresar = "../../main_page/main.html";

$productos = CAD::obtenerProductos(1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <title>Jeans - LUKA</title>
</head>
<body>
    <?php include('../../../components/header/header.php'); ?>
    
    <div class="container">
        <header>
            <h1>JEANS</h1>
        </header>
        
        <?php include('../../../components/product-grid/product-grid.php'); ?>
    </div>

    <?php include('../../../components/footer/footer.php'); ?>
</body>
</html>
