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
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $c->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resulset = $stmt->get_result();

            if($resulset->num_rows > 0){
                $registro=$resulset->fetch_assoc();
                if ($registro['clave'] == $clave) {
                    return $registro;
                }
            }
            return false;
        } catch (Throwable $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>