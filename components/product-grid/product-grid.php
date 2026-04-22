<?php
if (!isset($productos) || !is_array($productos)) {
    echo '<p>No hay productos disponibles</p>';
    return;
}

$mostrar_filtros = isset($mostrar_filtros) ? $mostrar_filtros : true;

$ruta_base_grid = '';
if(strpos($_SERVER['PHP_SELF'], '/men_pages/') !== false || strpos($_SERVER['PHP_SELF'], '/woman-pages/') !== false) {
    if(strpos($_SERVER['PHP_SELF'], '/clothes-pages/') !== false) {
        $ruta_base_grid = '../../../';
    } else {
        $ruta_base_grid = '../../';
    }
} else if(strpos($_SERVER['PHP_SELF'], '/main_page/') !== false) {
    $ruta_base_grid = '../';
} else {
    $ruta_base_grid = '';
}
?>

<link rel="stylesheet" href="<?php echo $ruta_base_grid; ?>components/product-grid/product-grid.css">

<?php if($mostrar_filtros): ?>
    <?php include($ruta_base_grid . 'components/product-filters/product-filters.php'); ?>
<?php endif; ?>

<section class="products-section">
    <div class="products-grid">
        <?php foreach($productos as $producto): ?>
        <div class="product-card" data-color="<?php echo htmlspecialchars($producto['color']); ?>" data-date="<?php echo $producto['fecha_agregado']; ?>">
            <div class="product-image" data-product-id="<?php echo $producto['id_prenda']; ?>">
                <img src="<?php echo $ruta_base_grid; ?>mostrar_imagen.php?id=<?php echo $producto['id_prenda']; ?>" alt="<?php echo htmlspecialchars($producto['nombre_prenda']); ?>">
                <button class="add-btn">+</button>
            </div>
            <div class="product-info">
                <p class="product-name"><?php echo strtoupper(htmlspecialchars($producto['nombre_prenda'])); ?></p>
                <p class="product-price">$<?php echo number_format($producto['precio'], 2); ?></p>
                <?php if($producto['talla']): ?>
                    <p class="product-sizes"><?php echo htmlspecialchars($producto['talla']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<script src="<?php echo $ruta_base_grid; ?>components/product-filters/product-filters.js"></script>
<script src="<?php echo $ruta_base_grid; ?>components/product-grid/product-grid.js"></script>
