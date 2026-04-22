<?php

require_once "conexion.php";

class CAD
{
    public $con;

    static public function agregaUsuario($nombre, $email, $password)
    {
        try {
            $con = new Conexion(); //Establecer la conexión a la BD
            
            $checkQuery = $con->conectar()->prepare("SELECT id_usuario FROM usuarios WHERE email = :email");
            $checkQuery->bindParam(':email', $email);
            $checkQuery->execute();
            
            if($checkQuery->fetch())
            {
                return array('success' => false, 'message' => 'El correo ya está registrado');
            }
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $query = $con->conectar()->prepare("INSERT INTO usuarios (nombre, email, password, id_rol) VALUES (:nombre, :email, :password, 2)");
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password_hash);

            if($query->execute())
            {
                return array('success' => true, 'message' => 'Usuario registrado correctamente');
            }
            else
            {
                return array('success' => false, 'message' => 'Error al registrar usuario');
            }
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }

    static public function validarUsuario($email, $password)
    {
        $con = new Conexion(); //Establecer la conexión a la BD
        $query = $con->conectar()->prepare("SELECT * FROM usuarios WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
        
        if($usuario)
        {
            if(password_verify($password, $usuario['password']) || $usuario['password'] === $password)
            {
                return $usuario; 
            }
        }
        
        return false; 
    }

    
    static public function agregarProducto($nombre, $descripcion, $precio, $id_categoria, $talla, $color, $stock, $foto, $estado = 'disponible')
    {
        try {
            $con = new Conexion();
            
            $query = $con->conectar()->prepare("INSERT INTO prendas (nombre_prenda, descripcion, precio, id_categoria, talla, color, stock, foto, estado) 
                                                VALUES (:nombre, :descripcion, :precio, :id_categoria, :talla, :color, :stock, :foto, :estado)");
            
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':descripcion', $descripcion);
            $query->bindParam(':precio', $precio);
            $query->bindParam(':id_categoria', $id_categoria);
            $query->bindParam(':talla', $talla);
            $query->bindParam(':color', $color);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':foto', $foto, PDO::PARAM_LOB);
            $query->bindParam(':estado', $estado);
            
            if($query->execute())
            {
                return array('success' => true, 'message' => 'Producto agregado correctamente');
            }
            else
            {
                return array('success' => false, 'message' => 'Error al agregar producto');
            }
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    
    static public function obtenerProductos($id_categoria = null, $limite = null)
    {
        try {
            $con = new Conexion();
            
            if($id_categoria)
            {
                $sql = "SELECT id_prenda, nombre_prenda, descripcion, precio, id_categoria, talla, color, stock, estado, fecha_agregado 
                        FROM prendas WHERE id_categoria = :id_categoria AND estado = 'disponible'";
                if($limite) {
                    $sql .= " LIMIT :limite";
                }
                
                $query = $con->conectar()->prepare($sql);
                $query->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
                if($limite) {
                    $query->bindParam(':limite', $limite, PDO::PARAM_INT);
                }
            }
            else
            {
                $sql = "SELECT id_prenda, nombre_prenda, descripcion, precio, id_categoria, talla, color, stock, estado, fecha_agregado 
                        FROM prendas WHERE estado = 'disponible'";
                if($limite) {
                    $sql .= " LIMIT :limite";
                }
                
                $query = $con->conectar()->prepare($sql);
                if($limite) {
                    $query->bindParam(':limite', $limite, PDO::PARAM_INT);
                }
            }
            
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            return array();
        }
    }
    
    static public function obtenerImagenProducto($id_prenda)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT foto FROM prendas WHERE id_prenda = :id_prenda");
            $query->bindParam(':id_prenda', $id_prenda, PDO::PARAM_INT);
            $query->execute();
            
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['foto'] : null;
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    
    static public function obtenerProductoPorId($id_prenda)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT * FROM prendas WHERE id_prenda = :id_prenda");
            $query->bindParam(':id_prenda', $id_prenda, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    
    static public function editarProducto($id_prenda, $nombre, $descripcion, $precio, $id_categoria, $talla, $color, $stock, $estado, $foto = null)
    {
        try {
            $con = new Conexion();
            
            if($foto !== null)
            {
                $query = $con->conectar()->prepare("UPDATE prendas SET 
                    nombre_prenda = :nombre, 
                    descripcion = :descripcion, 
                    precio = :precio, 
                    id_categoria = :id_categoria, 
                    talla = :talla, 
                    color = :color, 
                    stock = :stock, 
                    estado = :estado,
                    foto = :foto
                    WHERE id_prenda = :id_prenda");
                $query->bindParam(':foto', $foto, PDO::PARAM_LOB);
            }
            else
            {
                $query = $con->conectar()->prepare("UPDATE prendas SET 
                    nombre_prenda = :nombre, 
                    descripcion = :descripcion, 
                    precio = :precio, 
                    id_categoria = :id_categoria, 
                    talla = :talla, 
                    color = :color, 
                    stock = :stock, 
                    estado = :estado
                    WHERE id_prenda = :id_prenda");
            }
            
            $query->bindParam(':id_prenda', $id_prenda, PDO::PARAM_INT);
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':descripcion', $descripcion);
            $query->bindParam(':precio', $precio);
            $query->bindParam(':id_categoria', $id_categoria);
            $query->bindParam(':talla', $talla);
            $query->bindParam(':color', $color);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':estado', $estado);
            
            if($query->execute())
            {
                return array('success' => true, 'message' => 'Producto actualizado correctamente');
            }
            else
            {
                return array('success' => false, 'message' => 'Error al actualizar producto');
            }
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    
    static public function eliminarProducto($id_prenda)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("DELETE FROM prendas WHERE id_prenda = :id_prenda");
            $query->bindParam(':id_prenda', $id_prenda, PDO::PARAM_INT);
            
            if($query->execute())
            {
                return array('success' => true, 'message' => 'Producto eliminado correctamente');
            }
            else
            {
                return array('success' => false, 'message' => 'Error al eliminar producto');
            }
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    
    
    static public function agregarAlCarrito($id_usuario, $id_prenda, $cantidad, $talla)
    {
        try {
            $con = new Conexion();
            
            $check = $con->conectar()->prepare("SELECT id_carrito, cantidad FROM carrito WHERE id_usuario = :id_usuario AND id_prenda = :id_prenda AND talla = :talla");
            $check->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $check->bindParam(':id_prenda', $id_prenda, PDO::PARAM_INT);
            $check->bindParam(':talla', $talla);
            $check->execute();
            
            if($item = $check->fetch(PDO::FETCH_ASSOC))
            {
                $nueva_cantidad = $item['cantidad'] + $cantidad;
                $update = $con->conectar()->prepare("UPDATE carrito SET cantidad = :cantidad WHERE id_carrito = :id_carrito");
                $update->bindParam(':cantidad', $nueva_cantidad, PDO::PARAM_INT);
                $update->bindParam(':id_carrito', $item['id_carrito'], PDO::PARAM_INT);
                $update->execute();
            }
            else
            {
                $insert = $con->conectar()->prepare("INSERT INTO carrito (id_usuario, id_prenda, cantidad, talla) VALUES (:id_usuario, :id_prenda, :cantidad, :talla)");
                $insert->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $insert->bindParam(':id_prenda', $id_prenda, PDO::PARAM_INT);
                $insert->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $insert->bindParam(':talla', $talla);
                $insert->execute();
            }
            
            return array('success' => true, 'message' => 'Producto agregado al carrito');
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    
    static public function obtenerCarrito($id_usuario)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT c.*, p.nombre_prenda, p.precio, p.stock 
                                                FROM carrito c 
                                                INNER JOIN prendas p ON c.id_prenda = p.id_prenda 
                                                WHERE c.id_usuario = :id_usuario");
            $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            return array();
        }
    }
    
    static public function eliminarDelCarrito($id_carrito)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("DELETE FROM carrito WHERE id_carrito = :id_carrito");
            $query->bindParam(':id_carrito', $id_carrito, PDO::PARAM_INT);
            $query->execute();
            
            return array('success' => true);
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => $e->getMessage());
        }
    }
    
    static public function vaciarCarrito($id_usuario)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("DELETE FROM carrito WHERE id_usuario = :id_usuario");
            $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $query->execute();
            
            return array('success' => true);
        }
        catch(Exception $e)
        {
            return array('success' => false, 'message' => $e->getMessage());
        }
    }
    
    static public function realizarCompra($id_usuario)
    {
        try {
            $con = new Conexion();
            $pdo = $con->conectar();
            
            $pdo->beginTransaction();
            
            $carrito = self::obtenerCarrito($id_usuario);
            
            if(empty($carrito))
            {
                return array('success' => false, 'message' => 'El carrito está vacío');
            }
            
            $total = 0;
            foreach($carrito as $item)
            {
                $total += $item['precio'] * $item['cantidad'];
            }
            
            $pedido = $pdo->prepare("INSERT INTO pedidos (id_usuario, total) VALUES (:id_usuario, :total)");
            $pedido->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $pedido->bindParam(':total', $total);
            $pedido->execute();
            
            $id_pedido = $pdo->lastInsertId();
            
            foreach($carrito as $item)
            {
                $subtotal = $item['precio'] * $item['cantidad'];
                
                $detalle = $pdo->prepare("INSERT INTO detalle_pedido (id_pedido, id_prenda, cantidad, precio_unitario, talla, subtotal) 
                                         VALUES (:id_pedido, :id_prenda, :cantidad, :precio, :talla, :subtotal)");
                $detalle->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
                $detalle->bindParam(':id_prenda', $item['id_prenda'], PDO::PARAM_INT);
                $detalle->bindParam(':cantidad', $item['cantidad'], PDO::PARAM_INT);
                $detalle->bindParam(':precio', $item['precio']);
                $detalle->bindParam(':talla', $item['talla']);
                $detalle->bindParam(':subtotal', $subtotal);
                $detalle->execute();
                
                $updateStock = $pdo->prepare("UPDATE prendas SET stock = stock - :cantidad WHERE id_prenda = :id_prenda");
                $updateStock->bindParam(':cantidad', $item['cantidad'], PDO::PARAM_INT);
                $updateStock->bindParam(':id_prenda', $item['id_prenda'], PDO::PARAM_INT);
                $updateStock->execute();
            }
            
            $vaciar = $pdo->prepare("DELETE FROM carrito WHERE id_usuario = :id_usuario");
            $vaciar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $vaciar->execute();
            
            $pdo->commit();
            
            return array('success' => true, 'message' => 'Compra realizada exitosamente', 'id_pedido' => $id_pedido);
        }
        catch(Exception $e)
        {
            $pdo->rollBack();
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    
    static public function obtenerHistorialCompras($id_usuario)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT * FROM pedidos WHERE id_usuario = :id_usuario ORDER BY fecha_pedido DESC");
            $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            return array();
        }
    }
    
    static public function obtenerDetallePedido($id_pedido)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT dp.*, p.nombre_prenda 
                                                FROM detalle_pedido dp 
                                                INNER JOIN prendas p ON dp.id_prenda = p.id_prenda 
                                                WHERE dp.id_pedido = :id_pedido");
            $query->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            return array();
        }
    }
    
    static public function contarItemsCarrito($id_usuario)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT SUM(cantidad) as total FROM carrito WHERE id_usuario = :id_usuario");
            $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $query->execute();
            
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ? $result['total'] : 0;
        }
        catch(Exception $e)
        {
            return 0;
        }
    }

}
?>