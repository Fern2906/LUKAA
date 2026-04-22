<?php
session_start();
require_once("../../CAD.php");

if(!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] != 1)
{
    header("Location: ../../login_page/login.php");
    exit();
}

$mensaje = "";

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
    
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0)
    {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
        $resultado = CAD::agregarProducto($nombre, $descripcion, $precio, $id_categoria, $talla, $color, $stock, $foto, $estado);
        $mensaje = $resultado['message'];
        
        if($resultado['success'])
        {
            header("Location: ../dashboard/dashboard.php?mensaje=" . urlencode($mensaje));
            exit();
        }
    }
    else
    {
        $mensaje = "Error: Debes seleccionar una imagen";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - LUKA</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if($mensaje): ?>
        <script>alert('<?php echo addslashes($mensaje); ?>');</script>
    <?php endif; ?>
    
    <div class="container">
        <a href="../dashboard/dashboard.php" class="back-link">← Volver al Dashboard</a>
        <h1>AGREGAR NUEVO PRODUCTO</h1>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nombre del Producto *</label>
                <input type="text" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion"></textarea>
            </div>
            
            <div class="form-group">
                <label>Precio *</label>
                <input type="number" name="precio" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
                <label>Categoría *</label>
                <select name="id_categoria" required>
                    <option value="">Seleccionar categoría</option>
                    <optgroup label="HOMBRE">
                        <option value="1">Jeans</option>
                        <option value="2">Accesorios</option>
                        <option value="3">Sudaderas</option>
                        <option value="4">Camisas</option>
                    </optgroup>
                    <optgroup label="MUJER">
                        <option value="5">Vestido</option>
                        <option value="6">Accesorios</option>
                        <option value="7">Tops</option>
                        <option value="8">Denim</option>
                    </optgroup>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tallas (separadas por coma)</label>
                <input type="text" name="talla" placeholder="XS, S, M, L, XL">
            </div>
            
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" placeholder="Azul, Negro, Blanco...">
            </div>
            
            <div class="form-group">
                <label>Stock *</label>
                <input type="number" name="stock" min="0" value="0" required>
            </div>
            
            <div class="form-group">
                <label>Estado *</label>
                <select name="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="agotado">Agotado</option>
                    <option value="descontinuado">Descontinuado</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Imagen del Producto *</label>
                <input type="file" name="foto" accept="image/*" required onchange="previewImage(event)">
                <div class="preview" id="preview">
                    <img id="preview-img" src="" alt="Vista previa">
                </div>
            </div>
            
            <button type="submit">AGREGAR PRODUCTO</button>
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
