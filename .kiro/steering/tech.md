# Technology Stack

## Backend

- **Language**: PHP (procedural and OOP)
- **Database**: MySQL
- **Database Access**: PDO (PHP Data Objects)
- **Server**: Assumed LAMP/WAMP/XAMPP stack (Apache, MySQL, PHP)

## Frontend

- **HTML5**: Semantic markup
- **CSS3**: Custom stylesheets (no framework)
- **JavaScript**: Vanilla JS (no frameworks)
- **Font**: Google Fonts - Montserrat

## Database Configuration

- Host: `localhost`
- Database: `usuarios`
- User: `root`
- Password: (empty)
- Charset: `utf8`

## Project Setup

This is a traditional PHP web application without a build system. To run:

1. Install XAMPP/WAMP/MAMP or similar PHP development environment
2. Place project in web server document root (e.g., `htdocs`)
3. Import database schema (if available)
4. Access via `http://localhost/[project-folder]`

## Common Development Tasks

- **Start server**: Start Apache and MySQL from XAMPP/WAMP control panel
- **Database access**: phpMyAdmin at `http://localhost/phpmyadmin`
- **Testing**: Manual browser testing (no automated test framework)
- **Debugging**: PHP error logs and browser console

## Dependencies

- No package manager (npm/composer) in use
- External dependencies loaded via CDN (Google Fonts)
