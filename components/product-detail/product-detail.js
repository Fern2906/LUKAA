// Product Detail Component JavaScript

(function() {
    'use strict';
    
    // Esperar a que el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // Selección de tallas
        const sizeButtons = document.querySelectorAll('.size-btn');
        sizeButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                sizeButtons.forEach(function(b) {
                    b.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // Agregar al carrito
        const addToCartBtn = document.getElementById('addToCartBtn');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', handleAddToCart);
        }
    }
    
    function handleAddToCart() {
        const selectedSize = document.querySelector('.size-btn.selected');
        
        if (!selectedSize) {
            alert('Por favor selecciona una talla');
            return;
        }
        
        const productId = this.getAttribute('data-product-id');
        
        if (!productId) {
            alert('Error: No se encontró el ID del producto');
            return;
        }
        
        const formData = new FormData();
        formData.append('id_prenda', productId);
        formData.append('cantidad', 1);
        formData.append('talla', selectedSize.dataset.size);
        
        // Determinar ruta base
        const currentPath = window.location.pathname;
        let rutaBase = '';
        
        if (currentPath.includes('/men_pages/') || currentPath.includes('/woman-pages/')) {
            rutaBase = '../../../';
        } else if (currentPath.includes('/main_page/')) {
            rutaBase = '../';
        } else {
            rutaBase = '';
        }
        
        fetch(rutaBase + 'agregar_carrito.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                alert('Producto agregado al carrito');
                window.location.href = rutaBase + 'carrito/carrito.php';
            } else {
                alert(data.message || 'Error al agregar al carrito');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            alert('Error al agregar al carrito');
        });
    }
})();
