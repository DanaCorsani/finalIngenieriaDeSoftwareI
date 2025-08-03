<?php
require_once 'clases.php';
echo $_POST['usuario'];
echo $_POST['clave'];
$resultado = Usuario::iniciarSesion($_POST['usuario'], $_POST['clave']);

if ($resultado) {
    session_start();
    $_SESSION['usuario'] = $resultado['email'];
    header("Location: inicio.php");
} else {
    session_start();
    $_SESSION['msj'] = "Usuario o clave incorrectos";
    header("Location: index.php");
}
?>