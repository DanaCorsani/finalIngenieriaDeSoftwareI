<?php
class Usuario {
    private $email;
    private $dni;
    private $nombre;
    private $apellido;
    private $clave;

    public function __construct($email, $dni, $nombre, $apellido, $clave) {
        $this->email = $email;
        $this->clave = $clave;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public static function iniciarSesion($email, $clave) {
        try {
            require_once 'conexion.php';
            $c = conectar();
            $sql = "select * from usuarios where email='$email';";
            $resulset = $c->query($sql);
            if($c->affected_rows>0){
                $registro=$resulset->fetch_assoc();
                if ($registro['clave'] == $clave) {
                    return $registro;
                }
            }
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }
}
?>