<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LUKA - Tienda de Ropa</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <script src="script.js"></script>
    </head>
    <body>     
        <?php include('../components/header/header.php'); ?>
        <div>
            <div class="selecction">
                <div class="selecction_img">
                    <img src="imagenes/main_pag/wm.png" alt="Mujeres">
                    <a href="../woman-pages/main_page/main.php">MUJER</a>
                </div>
                <div class="selecction_img">
                    <img src="imagenes/main_pag/mn.png" alt="Hombres">
                    <a href="../men_pages/main_page/main.php">HOMBRE</a>
                </div>
            </div>
        </div>
        
        <?php include('../components/footer/footer.php'); ?>
    </body>
</html>
