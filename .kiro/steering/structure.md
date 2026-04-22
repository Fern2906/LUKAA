# Project Structure

## Root Level Files

- `conexion.php` - Database connection class (PDO wrapper)
- `CAD.php` - Data Access Layer (CAD = Capa de Acceso a Datos)
- `logout.php` - User logout handler
- `config.php` - Configuration file (note: typo in filename `config,php`)

## Directory Organization

### `/login_page/`
User authentication interface
- `login.php` - Login form and authentication logic
- `styles.css` - Login page styles
- `script.js` - Login page JavaScript
- `/images/` - Login-specific images (background, logo)

### `/register_page/`
User registration interface
- `register.html` - Registration form
- `styles.css` - Registration page styles
- `script.js` - Registration page JavaScript
- `/images/` - Registration-specific images

### `/main_page/`
Landing page with gender selection
- `index.html` - Main entry point
- `styles.css` - Landing page styles
- `script.js` - Landing page JavaScript
- `/imagenes/main_pag/` - Gender selection images (men/women)

### `/men_pages/`
Men's section of the store

#### `/men_pages/main_page/`
Men's category overview
- `main.html` - Men's landing page
- `styles.css`, `script.js`
- `/images/` - Category preview images

#### `/men_pages/clothes-pages/`
Individual product categories:
- `/jeans_page/` - Jeans products
- `/shirts_page/` - Shirts products
- `/sweaters_page/` - Sweaters products
- `/accesories_page/` - Accessories products

Each category contains:
- `[category].html` - Product listing page
- `styles.css` - Category-specific styles
- `script.js` - Product interaction logic
- `/images/` - Product images (J1-J12 for main products, N1-N4 for new launches)

### `/woman-pages/`
Women's section (mirrors men's structure)

#### `/woman-pages/main_page/`
Women's category overview

#### `/woman-pages/clothes-pages/`
Individual product categories:
- `/denim_page/`
- `/dresses_page/`
- `/tops_page/`
- `/accesories_page/`

## Naming Conventions

- **Folders**: lowercase with hyphens or underscores (`men_pages`, `clothes-pages`)
- **HTML files**: lowercase with hyphens (`jeans-.html`, `register.html`)
- **PHP files**: camelCase or PascalCase (`CAD.php`, `conexion.php`)
- **Images**: Uppercase letters + numbers (`J1.png`, `N1.png`)
- **CSS classes**: kebab-case (`login-container`, `footer-toggle`)

## Common Patterns

- Each page section has its own folder with HTML, CSS, JS, and images
- Product images follow naming: J1-J12 (regular products), N1-N4 (new launches)
- Footer is duplicated across pages (not componentized)
- Relative paths used for navigation between sections
