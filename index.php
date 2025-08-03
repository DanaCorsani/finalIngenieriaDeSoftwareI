<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostaza Academy</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header>
        <h1>Academia Mostaza</h1>
    </header>
    <main>
        <form method="post" action="login.php">        
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>
        <button type="submit">Ingresar</button>
        </form>
    </main>
    <aside></aside>
    <footer></footer>
    
    <?php
    if (isset($_SESSION['msj'])) {
        echo "<p>" . $_SESSION['msj'] . "</p>";
        unset($_SESSION['msj']);
    }
    ?>
</body>
</html>