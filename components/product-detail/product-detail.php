<?php
if (!isset($producto) || !$producto) {
    echo '<p>Producto no encontrado</p>';
    return;
}
$ruta_base_detail = '';
if(strpos($_SERVER['PHP_SELF'], '/men_pages/') !== false || strpos($_SERVER['PHP_SELF'], '/woman-pages/') !== false) {
    if(strpos($_SERVER['PHP_SELF'], '/clothes-pages/') !== false) {
        $ruta_base_detail = '../../../';
    } else {
        $ruta_base_detail = '../../';
    }
} else if(strpos($_SERVER['PHP_SELF'], '/main_page/') !== false) {
    $ruta_base_detail = '../';
} else if(strpos($_SERVER['PHP_SELF'], '/carrito/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/historial/') !== false ||
          strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
    $ruta_base_detail = '../';
} else {
    $ruta_base_detail = '';
}
?>

<link rel="stylesheet" href="<?php echo $ruta_base_detail; ?>components/product-detail/product-detail.css">

<div class="product-detail-container">
    <div class="product-image-section">
        <img src="<?php echo $ruta_base_detail; ?>mostrar_imagen.php?id=<?php echo $producto['id_prenda']; ?>" 
             alt="<?php echo htmlspecialchars($producto['nombre_prenda']); ?>">
    </div>

    <div class="product-info-section">

        <h1 class="product-title"><?php echo strtoupper(htmlspecialchars($producto['nombre_prenda'])); ?></h1>
        
        <div class="product-price">$<?php echo number_format($producto['precio'], 2); ?></div>
        
        <p class="product-description">
            <?php echo htmlspecialchars($producto['descripcion']) ?: 'Producto de alta calidad. Diseño moderno y cómodo, perfecto para cualquier ocasión.'; ?>
        </p>

        <div class="product-details">
            <?php if($producto['color']): ?>
                <p><strong>Color:</strong> <?php echo htmlspecialchars($producto['color']); ?></p>
            <?php endif; ?>
        </div>

        <?php if(isset($_SESSION['usuario_id'])): ?>
            <div class="sizes-section">
                <label>Selecciona tu talla:</label>
                <div class="sizes">
                    <button class="size-btn" data-size="XS">XS</button>
                    <button class="size-btn" data-size="S">S</button>
                    <button class="size-btn" data-size="M">M</button>
                    <button class="size-btn" data-size="L">L</button>
                    <button class="size-btn" data-size="XL">XL</button>
                </div>
            </div>

            

            <div class="stock-info">
                <?php if($producto['stock'] > 0): ?>
                    <button class="add-to-cart-btn" id="addToCartBtn" data-product-id="<?php echo $producto['id_prenda']; ?>">
                        Agregar al Carrito
                    </button>
                <?php else: ?>
                    ⚠ Producto agotado
                <?php endif; ?>
            </div>
        <?php else: ?>
            <a href="<?php echo $ruta_base_detail; ?>login_page/login.php" class="add-to-cart-btn">
                Inicia sesión para comprar
            </a>
        <?php endif; ?>
    </div>
</div>

<script src="<?php echo $ruta_base_detail; ?>components/product-detail/product-detail.js"></script>
