<?php
session_start();
require_once("../CAD.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $usuario = CAD::validarUsuario($email, $password);
    
    if($usuario)
    {
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_rol'] = $usuario['id_rol'];
        
        if($usuario['id_rol'] == 1)
        {
            header("Location: ../admin/dashboard/dashboard.php");
        }
        else
        {
            header("Location: ../main_page/index.php");
        }
        exit();
    }
    else
    {
        $error = "Correo o contraseña incorrectos";
    }
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Login - LUKA</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body>
        <?php if ($error): ?>
            <script>
                window.onload = function() {
                    alert('<?php echo addslashes($error); ?>');
                }
            </script>
        <?php endif; ?>
        
        <div>
            <div class="login_container">
                <div class="login_box">
                    <img src="images/login.png" class="login-title">
                    <div>
                        <form method="POST" action="">
                            <span>CORREO</span>
                            <input type="email" name="email" placeholder="USUARIO" required>
                            <span>CONTRASEÑA</span>
                            <input type="password" name="password" placeholder="CONTRASEÑA" required>
                            <button type="submit">INGRESAR</button>
                        </form>
                    </div>
                    <a href="../register_page/register.php">REGISTRAR</a>
                </div>
                <img src="images/luka-logo.png" class="luka-logo">
            </div>
        </div>
    </body>
</html>