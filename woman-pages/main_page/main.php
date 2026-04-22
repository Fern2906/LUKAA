<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <title>LUKA - Mujeres</title>
</head>
<body>
    <?php include('../../components/header/header.php'); ?>
    <div class="main-container">
        <div class="header-container">
            <img src="images/image-header.png" alt="Imagen de encabezado">
            <a href="../clothes-pages/dresses_page/dresses.php">VESTIDOS</a>
        </div>
            
        <div class="categories-container">
            <div>
                <img src="images/img1.png" alt="Accesorios">
                <a href="../clothes-pages/accesories_page/accesories.php">ACCESORIOS</a>
            </div>
            <div>
                <img src="images/img2.png" alt="Tops">
                <a href="../clothes-pages/tops_page/tops.php">TOPS</a>
            </div>
            <div>
                <img src="images/img3.png" alt="Denim">
                <a href="../clothes-pages/denim_page/denim.php">DENIM</a>
            </div>
        </div>
    </div>

    <?php include('../../components/footer/footer.php'); ?>
</body>
</html>
