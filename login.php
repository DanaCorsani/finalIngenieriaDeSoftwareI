<?php
require_once 'clases.php';
$resultado = Usuario::iniciarSesion($_POST['usuario'], $_POST['clave']);

if ($resultado) {
    session_start();
    $_SESSION['usuario'] = $resultado['email'];
    $_SESSION['usu_id'] = $resultado['usu_id'];
    header("Location: inicio.php");
} else {
    session_start();
    $_SESSION['msj'] = "Usuario o clave incorrectos";
    header("Location: index.php");
}
?>