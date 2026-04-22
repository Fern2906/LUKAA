// Product Grid Component - Click Handler
console.log('Product Grid Component cargado');

document.addEventListener('DOMContentLoaded', function() {
    console.log('Product Grid - DOM listo');
    
    const productsGrid = document.querySelector('.products-grid');
    
    if (!productsGrid) {
        console.log('No se encontró .products-grid');
        return;
    }
    
    console.log('Product Grid encontrado, configurando eventos');
    
    // Determinar ruta base
    const currentPath = window.location.pathname;
    let rutaBase = '';
    
    if (currentPath.includes('/men_pages/') || currentPath.includes('/woman-pages/')) {
        if (currentPath.includes('/clothes-pages/')) {
            rutaBase = '../../../';
        } else {
            rutaBase = '../../';
        }
    } else if (currentPath.includes('/main_page/')) {
        rutaBase = '../';
    } else {
        rutaBase = '';
    }
    
    // Usar delegación de eventos para manejar clicks en productos
    productsGrid.addEventListener('click', function(e) {
        const productImage = e.target.closest('.product-image');
        
        if (!productImage) {
            return;
        }
        
        // Si el click fue en el botón +
        if (e.target.classList.contains('add-btn')) {
            const productId = productImage.getAttribute('data-product-id');
            if (productId) {
                e.preventDefault();
                e.stopPropagation();
                window.location.href = rutaBase + 'producto-detalle.php?id=' + productId;
            }
            return;
        }
        
        // Click en la imagen
        const productId = productImage.getAttribute('data-product-id');
        
        if (productId) {
            window.location.href = rutaBase + 'producto-detalle.php?id=' + productId;
        }
    });
    
    console.log('Product Grid - Event listeners configurados');
});
