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
    private $estado;

    public function __construct($nombre, $apellido, $email, $dni, $clave, $rol, $estado) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->dni = $dni;
        $this->clave = $clave;
        $this->rol = $rol;
        $this->estado = $estado;
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
            $sql="insert into usuarios (nombre,apellido,email,dni,clave,rol_id,estado) values ('$this->nombre','$this->apellido','$this->email',$this->dni,'$this->clave',$this->rol,'activo');";

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


    public static function cambiarEstado($id, $estadoActual) {
        try {
            $c = conectar();
            $nuevoEstado = ($estadoActual === 'activo') ? 'inactivo' : 'activo';
            $sql = "UPDATE usuarios SET estado = '$nuevoEstado' WHERE usu_id = $id";
            $c->query($sql);
            return $c->affected_rows > 0;
        } catch (Throwable $e) {
            die("Error: " . $e->getMessage());
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

            # (v) Si el usuario no es administrador, solo podrá ver los cursos activos
            if($_SESSION['rol_id']==1){
            $sql = "select * from cursos;";
            }else{
            $sql = "select * from cursos WHERE estado = 'activo';";
            }

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



    public static function tieneExamen($cur_id) {
    $mysqli = conectar();

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $sql = "SELECT COUNT(*) AS total FROM preguntas WHERE cur_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $cur_id);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();

    $stmt->close();
    $mysqli->close();

    return $total > 0; // true si hay preguntas, false si no
    }




    public static function agregarExamen($cur_id, $post) {
    $con = conectar();

    for ($i = 1; $i <= 3; $i++) {
        // 1. Insertar la pregunta
        $texto_preg = $post["pregunta_$i"];
        $stmt = $con->prepare("INSERT INTO preguntas (cur_id, texto) VALUES (?, ?)");
        $stmt->execute([$cur_id, $texto_preg]);

        // 2. Obtener el ID de la pregunta recién insertada
        $preg_id = $con->insert_id;

        // 3. Insertar sus 4 opciones
        $correcta = $post["correcta_$i"]; // Ej: "2" significa opción 2 es la correcta
        for ($j = 1; $j <= 4; $j++) {
            $texto_opcion = $post["opcion_{$i}_{$j}"];
            $es_correcta = ($j == $correcta) ? 1 : 0;

            $stmtOpt = $con->prepare("INSERT INTO opciones (preg_id, texto, es_correcta) VALUES (?, ?, ?)");
            $stmtOpt->execute([$preg_id, $texto_opcion, $es_correcta]);
        }
    }

    return true;
    }




    public static function obtenerPreguntas($cur_id) {
    $mysqli = conectar();

    $preguntas = [];

    $sqlPreguntas = "SELECT preg_id, texto FROM preguntas WHERE cur_id = ?";
    $stmtPreg = $mysqli->prepare($sqlPreguntas);
    $stmtPreg->bind_param("i", $cur_id);
    $stmtPreg->execute();
    $resultPreg = $stmtPreg->get_result();

    while ($rowPreg = $resultPreg->fetch_assoc()) {
        $pregunta = [
            'id' => $rowPreg['preg_id'],
            'enunciado' => $rowPreg['texto'],
            'opciones' => []
        ];

        $sqlOpciones = "SELECT opt_id, texto FROM opciones WHERE preg_id = ?";
        $stmtOpt = $mysqli->prepare($sqlOpciones);
        $stmtOpt->bind_param("i", $rowPreg['preg_id']);
        $stmtOpt->execute();
        $resultOpt = $stmtOpt->get_result();

        $letra = 'a';
        while ($rowOpt = $resultOpt->fetch_assoc()) {
            $pregunta['opciones'][$letra] = $rowOpt['texto'];
            $letra++;
        }

        $preguntas[] = $pregunta;
    }

    $stmtPreg->close();
    $mysqli->close();

    return $preguntas;
    }






    public static function corregirExamen($usu_id, $cur_id, $respuestasUsuario) {
    $mysqli = conectar();
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $totalPreguntas = 0;
    $respuestasCorrectas = 0;

    foreach ($respuestasUsuario as $preg_id => $letraSeleccionada) {
        // Obtener la opción elegida (según orden alfabético)
        $sql = "SELECT opt_id, es_correcta FROM (
                    SELECT opt_id, es_correcta, 
                           ROW_NUMBER() OVER (PARTITION BY preg_id ORDER BY opt_id) AS rn
                    FROM opciones 
                    WHERE preg_id = ?
                ) AS ordenadas
                WHERE rn = ?";

        $stmt = $mysqli->prepare($sql);
        $pos = ord(strtolower($letraSeleccionada)) - ord('a') + 1;
        $stmt->bind_param("ii", $preg_id, $pos);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            $opt_id = $fila['opt_id'];
            $es_correcta = $fila['es_correcta'];

            // Insertar la respuesta
            $stmtInsert = $mysqli->prepare("INSERT INTO respuestas (usu_id, preg_id, opt_id) VALUES (?, ?, ?)");
            $stmtInsert->bind_param("iii", $usu_id, $preg_id, $opt_id);
            $stmtInsert->execute();
            $stmtInsert->close();

            // Contar si es correcta
            if ($es_correcta) {
                $respuestasCorrectas++;
            }

            $totalPreguntas++;
        }

        $stmt->close();
    }

    // Calcular nota sobre 10
    $nota = ($totalPreguntas > 0) ? round(($respuestasCorrectas / $totalPreguntas) * 10, 2) : 0;

    // Actualizar estado y nota en usuarios_cursos
    $stmtCurso = $mysqli->prepare("UPDATE usuarios_cursos SET estado = 'completo', nota = ? WHERE usu_id = ? AND cur_id = ?");
    $stmtCurso->bind_param("dii", $nota, $usu_id, $cur_id);
    $stmtCurso->execute();
    $stmtCurso->close();

    $mysqli->close();

    return $nota;
    }




    public static function usuarioRealizoExamen($usu_id, $cur_id) {
    $mysqli = conectar();
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Ver si existe alguna respuesta del usuario para preguntas de ese curso
    $sql = "SELECT 1
            FROM respuestas r
            INNER JOIN preguntas p ON r.preg_id = p.preg_id
            WHERE r.usu_id = ? AND p.cur_id = ?
            LIMIT 1";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $usu_id, $cur_id);
    $stmt->execute();
    $stmt->store_result();

    $yaRealizo = $stmt->num_rows > 0;

    $stmt->close();
    $mysqli->close();

    return $yaRealizo;
    }




    public static function obtenerRespuestasUsuario($usu_id, $cur_id) {
    $mysqli = conectar();
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $sql = "
        SELECT 
            p.texto AS pregunta,
            ou.texto AS opcion_usuario,
            oc.texto AS opcion_correcta,
            CASE WHEN ou.opt_id = oc.opt_id THEN 1 ELSE 0 END AS es_correcta
        FROM respuestas r
        INNER JOIN preguntas p ON r.preg_id = p.preg_id
        INNER JOIN opciones ou ON r.opt_id = ou.opt_id
        INNER JOIN opciones oc ON p.preg_id = oc.preg_id AND oc.es_correcta = 1
        WHERE r.usu_id = ? AND p.cur_id = ?
        ORDER BY p.preg_id
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $usu_id, $cur_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $respuestas = [];
    while ($fila = $result->fetch_assoc()) {
        $respuestas[] = [
            'pregunta' => $fila['pregunta'],
            'respuesta_usuario' => $fila['opcion_usuario'],
            'respuesta_correcta' => $fila['opcion_correcta'],
            'es_correcta' => (bool) $fila['es_correcta']
        ];
    }

    $stmt->close();
    $mysqli->close();

    return $respuestas;
    }

}
?>