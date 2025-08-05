<?php
session_start();
// Continuo la sesión iniciada
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include_once "navbar.php";
    ?>
    <h1>Mi PERFIL</h1>

    <h3>Hola <?=$_SESSION['usuario']; ?></h3>
</body>
</html>