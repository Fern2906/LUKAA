// Sistema de filtros de productos
class ProductFilters {
    constructor() {
        this.filters = {
            talla: [],
            color: [],
            precio: [],
            orden: 'reciente'
        };
        
        this.allProducts = [];
        this.init();
    }
    
    init() {
        this.saveOriginalProducts();
        
        // Event listener para el botón hamburguesa
        const toggleBtn = document.getElementById('filtersToggle');
        const filtersContainer = document.getElementById('filtersContainer');
        const filtersOverlay = document.getElementById('filtersOverlay');
        const closeBtn = document.getElementById('filtersClose');
        
        const closeFilters = () => {
            filtersContainer.classList.remove('show');
            filtersOverlay.classList.remove('show');
            document.body.style.overflow = '';
        };
        
        if (toggleBtn && filtersContainer && filtersOverlay) {
            toggleBtn.addEventListener('click', () => {
                filtersContainer.classList.toggle('show');
                filtersOverlay.classList.toggle('show');
                document.body.style.overflow = filtersContainer.classList.contains('show') ? 'hidden' : '';
            });
            
            // Cerrar al hacer click en el overlay
            filtersOverlay.addEventListener('click', closeFilters);
            
            // Cerrar con el botón X
            if (closeBtn) {
                closeBtn.addEventListener('click', closeFilters);
            }
        }
        
        // Event listeners para botones de filtro
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.toggleDropdown(e));
        });
        
        document.querySelectorAll('.filter-dropdown input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => this.applyFilters());
        });
        
        document.querySelectorAll('.filter-dropdown input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', () => this.applyFilters());
        });
        
        const clearBtn = document.getElementById('clearFilters');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => this.clearFilters());
        }
        
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.filter-group') && window.innerWidth > 1024) {
                this.closeAllDropdowns();
            }
        });
    }
    
    saveOriginalProducts() {
        document.querySelectorAll('.product-card').forEach(card => {
            const productData = {
                element: card,
                id: card.querySelector('.product-image')?.getAttribute('data-product-id'),
                name: card.querySelector('.product-name')?.textContent || '',
                price: parseFloat(card.querySelector('.product-price')?.textContent.replace(/[$,]/g, '') || 0),
                sizes: card.querySelector('.product-sizes')?.textContent || '',
                color: card.getAttribute('data-color') || '',
                date: card.getAttribute('data-date') || new Date().toISOString()
            };
            this.allProducts.push(productData);
        });
    }
    
    toggleDropdown(event) {
        const button = event.currentTarget;
        const filterGroup = button.closest('.filter-group');
        const dropdown = filterGroup.querySelector('.filter-dropdown');
        const isOpen = dropdown.classList.contains('show');
        
        this.closeAllDropdowns();
        
        if (!isOpen) {
            dropdown.classList.add('show');
            button.classList.add('active');
        }
    }
    
    closeAllDropdowns() {
        document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
            dropdown.classList.remove('show');
        });
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
    }
    
    applyFilters() {
        this.filters.talla = this.getCheckedValues('talla');
        this.filters.color = this.getCheckedValues('color');
        this.filters.precio = this.getCheckedValues('precio');
        this.filters.orden = document.querySelector('input[name="orden"]:checked')?.value || 'reciente';
        
        let filteredProducts = [...this.allProducts];
        
        if (this.filters.talla.length > 0) {
            filteredProducts = filteredProducts.filter(product => {
                return this.filters.talla.some(talla => 
                    product.sizes.includes(talla)
                );
            });
        }
        
        if (this.filters.color.length > 0) {
            filteredProducts = filteredProducts.filter(product => {
                return this.filters.color.some(color => 
                    product.color.toLowerCase().includes(color.toLowerCase()) ||
                    product.name.toLowerCase().includes(color.toLowerCase())
                );
            });
        }
        
        if (this.filters.precio.length > 0) {
            filteredProducts = filteredProducts.filter(product => {
                return this.filters.precio.some(range => {
                    return this.isPriceInRange(product.price, range);
                });
            });
        }
        
        filteredProducts = this.sortProducts(filteredProducts, this.filters.orden);
        
        this.displayProducts(filteredProducts);
    }
    
    getCheckedValues(name) {
        const checked = [];
        document.querySelectorAll(`input[name="${name}"]:checked`).forEach(checkbox => {
            checked.push(checkbox.value);
        });
        return checked;
    }
    
    isPriceInRange(price, range) {
        if (range === '5000+') {
            return price >= 5000;
        }
        
        const [min, max] = range.split('-').map(Number);
        return price >= min && price <= max;
    }
    
    sortProducts(products, order) {
        const sorted = [...products];
        
        switch(order) {
            case 'precio_asc':
                sorted.sort((a, b) => a.price - b.price);
                break;
            case 'precio_desc':
                sorted.sort((a, b) => b.price - a.price);
                break;
            case 'nombre':
                sorted.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case 'reciente':
            default:
                sorted.sort((a, b) => new Date(b.date) - new Date(a.date));
                break;
        }
        
        return sorted;
    }
    
    displayProducts(filteredProducts) {
        this.allProducts.forEach(product => {
            product.element.style.display = 'none';
        });
        
        const grid = document.querySelector('.products-grid');
        if (grid) {
            filteredProducts.forEach(product => {
                product.element.style.display = 'block';
                grid.appendChild(product.element);
            });
        }
        
        this.showNoResultsMessage(filteredProducts.length === 0);
    }
    
    showNoResultsMessage(show) {
        let message = document.getElementById('noResultsMessage');
        
        if (show) {
            if (!message) {
                message = document.createElement('div');
                message.id = 'noResultsMessage';
                message.className = 'no-results-message';
                message.textContent = 'No se encontraron productos con los filtros seleccionados.';
                document.querySelector('.products-section').appendChild(message);
            }
            message.style.display = 'block';
        } else {
            if (message) {
                message.style.display = 'none';
            }
        }
    }
    
    clearFilters() {
        // Desmarcar todos los checkboxes
        document.querySelectorAll('.filter-dropdown input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Resetear radio buttons
        const defaultRadio = document.querySelector('input[name="orden"][value="reciente"]');
        if (defaultRadio) {
            defaultRadio.checked = true;
        }
        
        // Resetear filtros
        this.filters = {
            talla: [],
            color: [],
            precio: [],
            orden: 'reciente'
        };
        
        this.displayProducts(this.allProducts);
    }
}

// Inicializar filtros cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    new ProductFilters();
});
