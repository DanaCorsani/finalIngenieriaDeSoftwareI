<?php
public function conectar() {
    $host = "localhost";      
    $usuario = "root";         
    $clave = "";          
    $nombre = "ambd";  
    $con = new mysqli($host, $usuario, $clave, $nombre);
    return $con;
}
?>