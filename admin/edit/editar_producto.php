<?php
session_start();
require_once("../../CAD.php");

if(!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] != 1)
{
    header("Location: ../../login_page/login.php");
    exit();
}

$mensaje = "";
$id_prenda = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id_prenda == 0)
{
    header("Location: ../dashboard/dashboard.php");
    exit();
}

$producto = CAD::obtenerProductoPorId($id_prenda);

if(!$producto)
{
    header("Location: ../dashboard/dashboard.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $id_categoria = intval($_POST['id_categoria']);
    $talla = trim($_POST['talla']);
    $color = trim($_POST['color']);
    $stock = intval($_POST['stock']);
    $estado = $_POST['estado'];
    
    $foto = null;
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0)
    {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
    }
    
    $resultado = CAD::editarProducto($id_prenda, $nombre, $descripcion, $precio, $id_categoria, $talla, $color, $stock, $estado, $foto);
    $mensaje = $resultado['message'];
    
    if($resultado['success'])
    {
        $producto = CAD::obtenerProductoPorId($id_prenda);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - LUKA</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if($mensaje): ?>
        <script>alert('<?php echo addslashes($mensaje); ?>');</script>
    <?php endif; ?>
    
    <div class="container">
        <h1>EDITAR PRODUCTO</h1>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nombre del Producto *</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre_prenda']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Precio *</label>
                <input type="number" name="precio" step="0.01" min="0" value="<?php echo $producto['precio']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Categoría *</label>
                <select name="id_categoria" required>
                    <option value="">Seleccionar categoría</option>
                    <optgroup label="HOMBRE">
                        <option value="1" <?php echo $producto['id_categoria'] == 1 ? 'selected' : ''; ?>>Jeans</option>
                        <option value="2" <?php echo $producto['id_categoria'] == 2 ? 'selected' : ''; ?>>Accesorios</option>
                        <option value="3" <?php echo $producto['id_categoria'] == 3 ? 'selected' : ''; ?>>Sudaderas</option>
                        <option value="4" <?php echo $producto['id_categoria'] == 4 ? 'selected' : ''; ?>>Camisas</option>
                    </optgroup>
                    <optgroup label="MUJER">
                        <option value="5" <?php echo $producto['id_categoria'] == 5 ? 'selected' : ''; ?>>Vestido</option>
                        <option value="6" <?php echo $producto['id_categoria'] == 6 ? 'selected' : ''; ?>>Accesorios</option>
                        <option value="7" <?php echo $producto['id_categoria'] == 7 ? 'selected' : ''; ?>>Tops</option>
                        <option value="8" <?php echo $producto['id_categoria'] == 8 ? 'selected' : ''; ?>>Denim</option>
                    </optgroup>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tallas</label>
                <input type="text" name="talla" value="<?php echo htmlspecialchars($producto['talla']); ?>" placeholder="XS, S, M, L, XL">
            </div>
            
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" value="<?php echo htmlspecialchars($producto['color']); ?>">
            </div>
            
            <div class="form-group">
                <label>Stock *</label>
                <input type="number" name="stock" min="0" value="<?php echo $producto['stock']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Estado *</label>
                <select name="estado" required>
                    <option value="disponible" <?php echo $producto['estado'] == 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                    <option value="agotado" <?php echo $producto['estado'] == 'agotado' ? 'selected' : ''; ?>>Agotado</option>
                    <option value="descontinuado" <?php echo $producto['estado'] == 'descontinuado' ? 'selected' : ''; ?>>Descontinuado</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Imagen Actual</label>
                <img src="../../mostrar_imagen.php?id=<?php echo $producto['id_prenda']; ?>" alt="Imagen actual" class="current-image">
            </div>
            
            <div class="form-group">
                <label>Nueva Imagen (opcional)</label>
                <input type="file" name="foto" accept="image/*" onchange="previewImage(event)">
                <div class="preview" id="preview">
                    <img id="preview-img" src="" alt="Vista previa">
                </div>
            </div>
            
            <div class="buttons">
                <a href="../dashboard/dashboard.php" class="btn btn-back">← VOLVER</a>
                <button type="submit">GUARDAR CAMBIOS</button>
                <a href="../delete/eliminar_producto.php?id=<?php echo $producto['id_prenda']; ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar este producto?')">ELIMINAR</a>
            </div>
        </form>
    </div>
    
    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const previewImg = document.getElementById('preview-img');
            const file = event.target.files[0];
            
            if(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
