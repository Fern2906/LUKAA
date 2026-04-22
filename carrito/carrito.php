<?php
session_start();
require_once("../CAD.php");

if(!isset($_SESSION['usuario_id']))
{
    header("Location: ../login_page/login.php");
    exit();
}

$carrito = CAD::obtenerCarrito($_SESSION['usuario_id']);
$total = 0;

foreach($carrito as $item)
{
    $total += $item['precio'] * $item['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - LUKA</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('../components/header/header.php'); ?>
    
    <div class="container">
        <h1>MI CARRITO</h1>
        
        <?php if(empty($carrito)): ?>
            <div class="empty-cart">
                <p>Tu carrito está vacío</p>
                <a href="../main_page/index.php" class="btn">IR A COMPRAR</a>
            </div>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach($carrito as $item): ?>
                    <div class="cart-item">
                        <img src="../mostrar_imagen.php?id=<?php echo $item['id_prenda']; ?>" alt="<?php echo htmlspecialchars($item['nombre_prenda']); ?>">
                        <div class="item-info">
                            <h3><?php echo htmlspecialchars($item['nombre_prenda']); ?></h3>
                            <p>Talla: <?php echo htmlspecialchars($item['talla']); ?></p>
                            <p>Precio: $<?php echo number_format($item['precio'], 2); ?></p>
                            <p>Cantidad: <?php echo $item['cantidad']; ?></p>
                            <p class="subtotal">Subtotal: $<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></p>
                        </div>
                        <div class="item-actions">
                            <a href="eliminar_item.php?id=<?php echo $item['id_carrito']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar este producto?')">ELIMINAR</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h2>RESUMEN</h2>
                <div class="summary-row">
                    <span>Total de productos:</span>
                    <span><?php echo count($carrito); ?></span>
                </div>
                <div class="summary-row total">
                    <span>TOTAL:</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <a href="procesar_compra.php" class="btn-checkout">REALIZAR COMPRA</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
