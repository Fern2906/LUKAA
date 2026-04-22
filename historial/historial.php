<?php
session_start();
require_once("../CAD.php");

if(!isset($_SESSION['usuario_id']))
{
    header("Location: ../login_page/login.php");
    exit();
}

$pedidos = CAD::obtenerHistorialCompras($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras - LUKA</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('../components/header/header.php'); ?>
    
    <div class="container">
        <h1>MIS COMPRAS</h1>
        
        <?php if(isset($_GET['mensaje'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['mensaje']); ?></div>
        <?php endif; ?>
        
        <?php if(empty($pedidos)): ?>
            <div class="empty-history">
                <p>Aún no has realizado ninguna compra</p>
                <a href="../main_page/index.php" class="btn">IR A COMPRAR</a>
            </div>
        <?php else: ?>
            <div class="orders-list">
                <?php foreach($pedidos as $pedido): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <h3>Pedido #<?php echo $pedido['id_pedido']; ?></h3>
                                <p class="order-date"><?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></p>
                            </div>
                            <div class="order-total">
                                <span>Total:</span>
                                <span class="price">$<?php echo number_format($pedido['total'], 2); ?></span>
                            </div>
                        </div>
                        
                        <div class="order-details">
                            <?php
                            $detalles = CAD::obtenerDetallePedido($pedido['id_pedido']);
                            foreach($detalles as $detalle):
                            ?>
                                <div class="detail-item">
                                    <img src="../mostrar_imagen.php?id=<?php echo $detalle['id_prenda']; ?>" alt="<?php echo htmlspecialchars($detalle['nombre_prenda']); ?>">
                                    <div class="detail-info">
                                        <h4><?php echo htmlspecialchars($detalle['nombre_prenda']); ?></h4>
                                        <p>Talla: <?php echo htmlspecialchars($detalle['talla']); ?></p>
                                        <p>Cantidad: <?php echo $detalle['cantidad']; ?></p>
                                        <p>Precio: $<?php echo number_format($detalle['precio_unitario'], 2); ?></p>
                                    </div>
                                    <div class="detail-subtotal">
                                        $<?php echo number_format($detalle['subtotal'], 2); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
