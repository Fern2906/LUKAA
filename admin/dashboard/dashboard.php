<?php
session_start();
require_once("../../CAD.php");

// Verificar que sea administrador
if(!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] != 1)
{
    header("Location: ../../login_page/login.php");
    exit();
}

$productos = CAD::obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LUKA</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <h1>Administración</h1>
        <div class="user-info">
            <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
            <a href="../../logout.php" class="btn btn-logout">Cerrar Sesión</a>
        </div>
    </div>
    
    <div class="container">
        <?php if(isset($_GET['mensaje'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['mensaje']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        
        <div class="actions">
            <a href="../add/agregar_producto.php" class="btn">+ Agregar Producto</a>
            <a href="../../main_page/index.php" class="btn">Ver Tienda</a>
        </div>
        
        <h2 style="margin-bottom: 20px;">Productos (<?php echo count($productos); ?>)</h2>
        
        <?php if(count($productos) > 0): ?>
            <div class="products-grid">
                <?php foreach($productos as $producto): ?>
                    <div class="product-card">
                        <img src="../../mostrar_imagen.php?id=<?php echo $producto['id_prenda']; ?>" alt="<?php echo htmlspecialchars($producto['nombre_prenda']); ?>">
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($producto['nombre_prenda']); ?></h3>
                            <div class="price">$<?php echo number_format($producto['precio'], 2); ?></div>
                            <div class="stock">Stock: <?php echo $producto['stock']; ?> | Estado: <?php echo $producto['estado']; ?></div>
                        </div>
                        <div class="product-actions">
                            <a href="../edit/editar_producto.php?id=<?php echo $producto['id_prenda']; ?>" class="btn-edit">EDITAR</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-products">
                <h3>No hay productos registrados</h3>
                <p>Comienza agregando tu primer producto</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
