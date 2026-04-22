<?php
$ruta_base_filters = '';
if(strpos($_SERVER['PHP_SELF'], '/men_pages/') !== false || strpos($_SERVER['PHP_SELF'], '/woman-pages/') !== false) {
    if(strpos($_SERVER['PHP_SELF'], '/clothes-pages/') !== false) {
        $ruta_base_filters = '../../../';
    } else {
        $ruta_base_filters = '../../';
    }
} else if(strpos($_SERVER['PHP_SELF'], '/main_page/') !== false) {
    $ruta_base_filters = '../';
} else if(strpos($_SERVER['PHP_SELF'], '/carrito/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/historial/') !== false ||
          strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
    $ruta_base_filters = '../';
} else {
    $ruta_base_filters = '';
}
?>

<link rel="stylesheet" href="<?php echo $ruta_base_filters; ?>components/product-filters/product-filters.css">

<!-- Filtros de Productos -->
<div class="filters-overlay" id="filtersOverlay"></div>

<button class="filters-toggle-btn" id="filtersToggle">
    <span class="hamburger-icon">☰</span> FILTROS
</button>

<div class="filters-container" id="filtersContainer">
    <button class="filters-close-btn" id="filtersClose">✕</button>
    
    <div class="filter-group">
        <button class="filter-btn" data-filter="talla">
            TALLAS <span class="arrow">🡇</span>
        </button>
        <div class="filter-dropdown" id="tallaDropdown">
            <label><input type="checkbox" name="talla" value="XS"> XS</label>
            <label><input type="checkbox" name="talla" value="S"> S</label>
            <label><input type="checkbox" name="talla" value="M"> M</label>
            <label><input type="checkbox" name="talla" value="L"> L</label>
            <label><input type="checkbox" name="talla" value="XL"> XL</label>
            <label><input type="checkbox" name="talla" value="XXL"> XXL</label>
        </div>
    </div>
    
    <div class="filter-group">
        <button class="filter-btn" data-filter="color">
            COLOR <span class="arrow">🡇</span>
        </button>
        <div class="filter-dropdown" id="colorDropdown">
            <label><input type="checkbox" name="color" value="Negro"> Negro</label>
            <label><input type="checkbox" name="color" value="Blanco"> Blanco</label>
            <label><input type="checkbox" name="color" value="Azul"> Azul</label>
            <label><input type="checkbox" name="color" value="Gris"> Gris</label>
            <label><input type="checkbox" name="color" value="Rojo"> Rojo</label>
            <label><input type="checkbox" name="color" value="Verde"> Verde</label>
            <label><input type="checkbox" name="color" value="Amarillo"> Amarillo</label>
            <label><input type="checkbox" name="color" value="Naranja"> Naranja</label>
            <label><input type="checkbox" name="color" value="Morado"> Morado</label>
            <label><input type="checkbox" name="color" value="Rosa"> Rosa</label>
            <label><input type="checkbox" name="color" value="Marrón"> Marrón</label>
            <label><input type="checkbox" name="color" value="Beige"> Beige</label>
        </div>
    </div>
    
    <div class="filter-group">
        <button class="filter-btn" data-filter="orden">
            ORDENAR POR <span class="arrow">🡇</span>
        </button>
        <div class="filter-dropdown" id="ordenDropdown">
            <label><input type="radio" name="orden" value="reciente" checked> Más reciente</label>
            <label><input type="radio" name="orden" value="precio_asc"> Precio: Menor a Mayor</label>
            <label><input type="radio" name="orden" value="precio_desc"> Precio: Mayor a Menor</label>
            <label><input type="radio" name="orden" value="nombre"> Nombre A-Z</label>
        </div>
    </div>
    
    <div class="filter-group">
        <button class="filter-btn" data-filter="precio">
            PRECIO <span class="arrow">🡇</span>
        </button>
        <div class="filter-dropdown" id="precioDropdown">
            <label><input type="checkbox" name="precio" value="0-1000"> $0 - $1,000</label>
            <label><input type="checkbox" name="precio" value="1000-2000"> $1,000 - $2,000</label>
            <label><input type="checkbox" name="precio" value="2000-3000"> $2,000 - $3,000</label>
            <label><input type="checkbox" name="precio" value="3000-5000"> $3,000 - $5,000</label>
            <label><input type="checkbox" name="precio" value="5000+"> $5,000+</label>
        </div>
    </div>
    
    <button class="clear-filters-btn" id="clearFilters">LIMPIAR FILTROS</button>
</div>
