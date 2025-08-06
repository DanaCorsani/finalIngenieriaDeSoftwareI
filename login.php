<?php
require_once 'clases.php';
$resultado = Usuario::iniciarSesion($_POST['usuario'], $_POST['clave']);

if ($resultado) {
    session_start();
    $_SESSION['usuario'] = $resultado['email'];
    $_SESSION['usu_id'] = $resultado['usu_id'];
    $_SESSION['rol_id'] = $resultado['rol_id'];
    $_SESSION['nombre'] = $resultado['nombre'];
    $_SESSION['apellido'] = $resultado['apellido'];
    $_SESSION['dni'] = $resultado['dni'];
    $_SESSION['sucursal'] = $resultado['sucursal'];
    header("Location: inicio.php");
} else {
    session_start();
    $_SESSION['msj'] = "Usuario o clave incorrectos, o usuario inactivo.";
    header("Location: index.php");
}
?>