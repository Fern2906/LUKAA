<?php
// Componente de footer reutilizable
// Uso: include('../components/footer/footer.php');

// Determinar ruta base según ubicación del archivo
$ruta_base_footer = '';
if(strpos($_SERVER['PHP_SELF'], '/men_pages/') !== false || strpos($_SERVER['PHP_SELF'], '/woman-pages/') !== false) {
    if(strpos($_SERVER['PHP_SELF'], '/clothes-pages/') !== false) {
        $ruta_base_footer = '../../../';
    } else {
        $ruta_base_footer = '../../';
    }
} else if(strpos($_SERVER['PHP_SELF'], '/main_page/') !== false) {
    $ruta_base_footer = '../';
} else if(strpos($_SERVER['PHP_SELF'], '/carrito/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/historial/') !== false ||
          strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
    $ruta_base_footer = '../';
} else {
    $ruta_base_footer = '';
}
?>

<link rel="stylesheet" href="<?php echo $ruta_base_footer; ?>components/footer/footer.css">

<!-- Footer Component -->
<footer>
    <div class="footer-content">
        <div class="footer-left">
            <div class="footer-section">
                <button class="footer-toggle">SERVICIO AL CLIENTE +</button>
            </div>
            <div class="footer-section">
                <button class="footer-toggle">MARCA +</button>
            </div>
            <div class="footer-section">
                <button class="footer-toggle">DESCUENTOS +</button>
            </div>
            <div class="footer-section">
                <button class="footer-toggle">TERMINOS Y CONDICIONES +</button>
            </div>
        </div>
        <div class="footer-right">
            <h3>SUSCRIBETE!</h3>
            <input type="email" placeholder="CORREO ELECTRONICO" class="email-input">
        </div>
    </div>
</footer>
