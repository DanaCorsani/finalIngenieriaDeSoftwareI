<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <form method="post" action="login.php">        
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>
        <button type="submit">Ingresar</button>
    </form>
    <?php
    if (isset($_SESSION['msj'])) {
        echo $_SESSION['msj'];
        unset($_SESSION['msj']);
    }
    ?>
</body>
</html>