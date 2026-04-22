<?php
require_once "CAD.php";

if(isset($_GET['id']))
{
    $id_prenda = intval($_GET['id']);
    $imagen = CAD::obtenerImagenProducto($id_prenda);
    
    if($imagen)
    {
        header("Content-Type: image/jpeg");
        echo $imagen;
    }
    else
    {
        header("Content-Type: image/png");
        $img = imagecreate(300, 400);
        $bg = imagecolorallocate($img, 240, 240, 240);
        $text_color = imagecolorallocate($img, 100, 100, 100);
        imagestring($img, 5, 80, 190, 'Sin imagen', $text_color);
        imagepng($img);
        imagedestroy($img);
    }
}
?>
