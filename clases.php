<?php
require 'conexion.php';
class Usuario {
    private $nombre;
    private $apellido;
    private $email;
    private $dni;
    private $clave;
    private $rol;

    public function __construct($nombre, $apellido, $email, $dni, $clave, $rol) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->dni = $dni;
        $this->clave = $clave;
        $this->rol = $rol;
    }

    public static function iniciarSesion($email, $clave) {
        try {
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




    public static function listar(){
        try{
            $c=conectar();
            $sql = "select * from usuarios;";

            $resulset = $c->query($sql);

            if($resulset->num_rows > 0){
                while($registro=$resulset->fetch_assoc()){
                    $lista[] = $registro;
                }
            }
            else{
                $lista=false;
            }
        }
        catch(Throwable $e){
            die("Error: " . $e->getMessage());
            $lista=false;
        }
        finally{
            return $lista;
        }
    }


    public function cargar(){
        try{
            $c=conectar();
            // Verificar si ya existe un usuario con ese email o DNI
            $sql = "SELECT * FROM usuarios WHERE email = '$this->email' OR dni = $this->dni";
            $resulset = $c->query($sql);
            if($resulset->num_rows > 0){
                return false;
            }

            // Si no existe, proceder a insertar el nuevo usuario
            $sql="insert into usuarios (nombre,apellido,email,dni,clave,rol_id) values ('$this->nombre','$this->apellido','$this->email',$this->dni,'$this->clave',$this->rol);";

            $c->query($sql);

            if ($c->affected_rows>0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Throwable $e){
            die("Error: " . $e->getMessage());
            return false;
        }
    }
}
?>