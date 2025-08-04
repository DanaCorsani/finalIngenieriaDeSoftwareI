<?php
require 'conexion.php';
#region Usuario
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



    public static function buscar($bu,$op){
            try{
                $c=conectar();
                switch ($op){
                    case 'dni':
                    if (is_numeric($bu)){
                        $sql="select * from usuarios where dni=$bu;";
                    }
                    else{
                        echo "<h2>Error. Escriba un DNI valido</h2>";
                        exit();
                    }
                    break;

                    case 'nombre':
                    $sql="select * from usuarios where nombre like '%$bu%';";
                    break;

                    case 'apellido':
                    $sql="select * from usuarios where apellido like '%$bu%';";
                    break;
                    
                    case 'email':
                    $sql="select * from usuarios where email like '%$bu%';";
                    break;

                    default:
                    echo "Error";
                    break;
                }
                $resulset=$c->query($sql);
            
                if ($c->affected_rows>0){
                    while($registro=$resulset->fetch_assoc()){
                        $lista[]=$registro;
                    }
                }
                else{
                    $lista=false;
                }
            }
            catch(Throwable $e){
                $lista=false;
            }
            finally{
                return $lista;
            }
        }


    public static function tomarDatos($id){
        try{
            $c=conectar();
            $sql = "select * from usuarios where usu_id=$id;";
            $resulset = $c->query($sql);

            if($c->affected_rows>0){
                $registro=$resulset->fetch_assoc();
            }
            else{
                $registro=false;
            }
        }
        catch(Throwable $e){
            die("Error: " . $e->getMessage());
            $registro=false;
        }
        finally{
            return $registro;
        }
    }


    public function modificar($id){
        try{
            $c=conectar();
            $sql="update usuarios set nombre='$this->nombre', apellido='$this->apellido', email='$this->email' where usu_id=$id";
            $c->query($sql);
            if ($c->affected_rows>0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Throwable $e){
            return false;
        }
    }



    public static function eliminar($id){
        try{
            $c=conectar();
            $sql="delete from usuarios where usu_id=$id";
            $c->query($sql);

            if ($c->affected_rows>0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Thowable $e){
            return false;
        }
    }
}






#region Curso
class Curso {
    private $nombre;
    private $area;
    private $desc;
    private $video;
    private $documento;

    public function __construct($nombre, $area, $desc, $video, $documento) {
        $this->nombre = $nombre;
        $this->area = $area;
        $this->desc = $desc;
        $this->video = $video;
        $this->documento = $documento;
    }

    public static function listar(){
        try{
            $c=conectar();
            $sql = "select * from cursos;";

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
            $sql="insert into cursos (nombre,area,cur_desc,estado,video,pdf) values ('$this->nombre','$this->area','$this->desc','inactivo','$this->video','$this->documento');";
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



    public static function buscar($bu,$op){
        try{
            $c=conectar();
            switch ($op){
                case 'nombre':
                $sql="select * from cursos where nombre like '%$bu%';";
                break;

                case 'area':
                $sql="select * from cursos where area like '%$bu%';";
                break;

                default:
                echo "Error";
                break;
            }
            $resulset=$c->query($sql);
        
            if ($c->affected_rows>0){
                while($registro=$resulset->fetch_assoc()){
                    $lista[]=$registro;
                }
            }
            else{
                $lista=false;
            }
        }
        catch(Throwable $e){
            $lista=false;
        }
        finally{
            return $lista;
        }
    }

    public static function tomarDatos($id){
        try{
            $c=conectar();
            $sql = "select * from cursos where cur_id=$id;";
            $resulset = $c->query($sql);

            if($c->affected_rows>0){
                $registro=$resulset->fetch_assoc();
            }
            else{
                $registro=false;
            }
        }
        catch(Throwable $e){
            die("Error: " . $e->getMessage());
            $registro=false;
        }
        finally{
            return $registro;
        }
    }

    public static function cambiarEstado($id, $estadoActual) {
        try {
            $c = conectar();
            $nuevoEstado = ($estadoActual === 'activo') ? 'inactivo' : 'activo';
            $sql = "UPDATE cursos SET estado = '$nuevoEstado' WHERE cur_id = $id";
            $c->query($sql);
            return $c->affected_rows > 0;
        } catch (Throwable $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    public function modificar($id){
        try{
            $c=conectar();
            $sql="update cursos set nombre='$this->nombre', area='$this->area', cur_desc='$this->desc', video='$this->video', pdf='$this->documento' where cur_id=$id";
            $c->query($sql);
            if ($c->affected_rows>0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Throwable $e){
            return false;
        }
    }
}
?>