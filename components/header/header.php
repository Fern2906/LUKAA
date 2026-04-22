<?php
if(!isset($_SESSION)) {
    session_start();
}

$usuario_logueado = isset($_SESSION['usuario_id']);
$es_admin = isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] == 1;
$items_carrito = 0;

if($usuario_logueado && !$es_admin) {
    if(!class_exists('CAD')) {
        require_once(__DIR__ . '/../../CAD.php');
    }
    $items_carrito = CAD::contarItemsCarrito($_SESSION['usuario_id']);
}

$ruta_base = '';
if(strpos($_SERVER['PHP_SELF'], '/men_pages/') !== false || strpos($_SERVER['PHP_SELF'], '/woman-pages/') !== false) {
    if(strpos($_SERVER['PHP_SELF'], '/clothes-pages/') !== false) {
        $ruta_base = '../../../';
    } else {
        $ruta_base = '../../';
    }
} else if(strpos($_SERVER['PHP_SELF'], '/main_page/') !== false) {
    $ruta_base = '../';
} else if(strpos($_SERVER['PHP_SELF'], '/carrito/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/historial/') !== false ||
          strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
    $ruta_base = '../';
} else {
    $ruta_base = '';
}

$es_pagina_principal = (strpos($_SERVER['PHP_SELF'], '/index.php') !== false);
$es_carrito_o_historial = (strpos($_SERVER['PHP_SELF'], '/carrito/') !== false || 
                           strpos($_SERVER['PHP_SELF'], '/historial/') !== false);
$es_main_page = (strpos($_SERVER['PHP_SELF'], '/main_page/') !== false && 
                 strpos($_SERVER['PHP_SELF'], '/index.php') !== false);

$mostrar_boton_home = $es_carrito_o_historial;
$mostrar_boton_regresar = !$es_pagina_principal && !$es_carrito_o_historial && !$es_main_page;
?>

<link rel="stylesheet" href="<?php echo $ruta_base; ?>components/header/header.css">

<div class="top-header">
    <div class="top-header-left">
        <?php if($usuario_logueado): ?>
            <span class="user-name">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="top-header-right">
        <?php if($mostrar_boton_home): ?>
            <a href="<?php echo $ruta_base; ?>main_page/index.php" class="header-btn home-btn" title="Inicio">INICIO</a>
        <?php elseif($mostrar_boton_regresar): ?>
            <button onclick="window.history.back()" class="header-btn back-btn" title="Regresar">←</button>
        <?php endif; ?>
        <?php if($usuario_logueado && !$es_admin): ?>
            <a href="<?php echo $ruta_base; ?>carrito/carrito.php" class="cart-btn">
                CARRITO
                <?php if($items_carrito > 0): ?>
                    <span class="cart-count"><?php echo $items_carrito; ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo $ruta_base; ?>historial/historial.php" class="header-btn">MIS COMPRAS</a>
            <a href="<?php echo $ruta_base; ?>logout.php" class="header-btn">CERRAR SESIÓN</a>
        <?php elseif(!$usuario_logueado): ?>
            <a href="<?php echo $ruta_base; ?>login_page/login.php" class="header-btn">INICIAR SESIÓN</a>
        <?php endif; ?>
    </div>
</div>
