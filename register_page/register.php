<?php
session_start();
require_once("../CAD.php");

$error = "";
$success = "";

// Verificar si el formulario fue enviado
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validaciones
    if(empty($nombre) || empty($email) || empty($password))
    {
        $error = "Todos los campos son obligatorios";
    }
    elseif($password !== $confirm_password)
    {
        $error = "Las contraseñas no coinciden";
    }
    elseif(strlen($password) < 6)
    {
        $error = "La contraseña debe tener al menos 6 caracteres";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = "El correo electrónico no es válido";
    }
    else
    {
        // Registrar usuario
        $resultado = CAD::agregaUsuario($nombre, $email, $password);
        
        if($resultado['success'])
        {
            $success = $resultado['message'];
            // Opcional: redirigir al login después de 2 segundos
            header("refresh:2;url=../login_page/login.php");
        }
        else
        {
            $error = $resultado['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <title>Registro - LUKA</title>
</head>
<body>
    <?php if($error): ?>
        <script>
            window.onload = function() {
                alert('<?php echo addslashes($error); ?>');
            }
        </script>
    <?php endif; ?>
    
    <?php if($success): ?>
        <script>
            window.onload = function() {
                alert('<?php echo addslashes($success); ?>\n\nRedirigiendo al login...');
            }
        </script>
    <?php endif; ?>
    
    <div class="main-container">
        <div class="left-side">
            <img src="images/luka-logo.png" class="luka-logo">
        </div>
        <div class="right-side">
            <img src="images/registro-tittle.png" class="tittle">
            <div>
                <form method="POST" action="">
                    <p>NOMBRE</p>
                    <input type="text" name="nombre" placeholder="" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
                    <p>CORREO</p>
                    <input type="email" name="email" placeholder="" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    <p>CONTRASEÑA</p>
                    <input type="password" name="password" placeholder="" required>
                    <p>CONFIRMAR CONTRASEÑA</p>
                    <input type="password" name="confirm_password" placeholder="" required>
                    <button type="submit">REGISTRARSE</button>
                </form>
                <p>YA TIENES UNA CUENTA? <a href="../login_page/login.php">LOGIN</a></p>
            </div>
        </div>
    </div>
</body>  