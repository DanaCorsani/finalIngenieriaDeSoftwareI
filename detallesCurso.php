<?php
session_start();
require 'clases.php';
if (isset($_GET['curso'])) {
    $_SESSION['curso'] = $_GET['curso'];
}
$detalles=Curso::tomarDatos($_SESSION['curso']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title><?= $detalles['nombre'] ?></title>
</head>
<body>
    <?php
    //Mostrar detalles del curso
    echo "Nombre: ".$detalles['nombre'] . "<br>";
    echo "Area: ".$detalles['area'] . "<br>";
    echo "Estado: ".$detalles['estado'] . "<br>";
    echo "Descripción".$detalles['cur_desc'] . "<br>";



    // Video de YouTube
    $url = $detalles['video'];
    // Función para extraer el ID del video de YouTube
    function extraerIDYoutube($url) {
        // Si es formato youtube.com/watch?v=...
        if (strpos($url, "youtube.com") !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            return $params['v'] ?? null;
        }
        // Si es formato youtu.be/...
        if (strpos($url, "youtu.be/") !== false) {
            return basename(parse_url($url, PHP_URL_PATH));
        }
        return null;
    }
    $id = extraerIDYoutube($url);
    ?>

    <!-- Mostrar el video -->
    <?php if ($id): ?>
    <iframe width="560" height="315"
            src="https://www.youtube.com/embed/<?php echo htmlspecialchars($id); ?>"
            frameborder="0" allowfullscreen>
    </iframe>
    <?php else: ?>
    <p>URL no válida de YouTube</p>
    <?php endif; ?>
  
    <!-- Documento de Google -->
    <a href="<?php echo htmlspecialchars($detalles['pdf']); ?>"
    target="_blank"
    title="Ver documento"
    style="display: inline-block; text-decoration: none;">
    <img src="https://ssl.gstatic.com/docs/doclist/images/icon_11_document_list.png"
        alt="Google Doc" width="48" height="48">
    </a>

    <!-- Acciones -->
    <form action="?">
        <button title="Modificar" type="submit" name="modificar" value="<?= $_SESSION['curso'] ?>"><i class="fas fa-edit"></i></button>
        <button title="Eliminar" type="submit" name="eliminar" value="<?= $_SESSION['curso'] ?>"><i class="fas fa-trash-alt"></i></button>
    </form>
    <br><br><br>


    <!-- Formulario para modificar curso -->
    <?php
    if (isset($_GET["modificar"])){
            $registro= Usuario::tomarDatos($_GET["modificar"]);

            if ($registro){
                ?>
                <br>
                <div class="formularios">
                <form method="post" action="?">
                    <h2>Modificacion de Usuario</h2>
                    <input type="hidden" name="modificacion">
                    <input type="hidden" name="id" value="<?= $registro["usu_id"] ?>">
                    <input type="hidden" name="nombreViejo" value="<?= $registro["nombre"] ?>">
                    <input type="hidden" name="apellidoViejo" value="<?= $registro["apellido"] ?>">
                    <input type="hidden" name="emailViejo" value="<?= $registro["email"] ?>">
                    <input type="hidden" name="" value="<?= $registro["email"] ?>">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" name="nombre" id="nombre" value="<?= $registro["nombre"] ?>" maxlength="30" required> <br><br>
                    <label for="apellido">Apellido:</label><br>
                    <input type="text" name="apellido" id="apellido" value="<?= $registro["apellido"] ?>" maxlength="30" required> <br><br>
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email" value="<?= $registro["email"] ?>" maxlength="30" required> <br><br>
                    <input type="submit" value="Aceptar">
                </form>
                </div>
                <?php
            }
            else{
                echo "<h2>Ha ocurrido un error</h2>";
            }
        }
        //Formulario para la confirmacion de modificacion de Usuario
        if (isset($_POST["modificacion"])){
            echo "<h2>Esta a punto de modificar al usuario<br>";
            echo "Nombre: ".$_POST["nombreViejo"].", Apellido: ".$_POST["apellidoViejo"].", Email: ".$_POST["emailViejo"]."<br><br>";
            echo "Por Nombre: ".$_POST["nombre"].", Apellido: ".$_POST["apellido"].", Usuario: ".$_POST["email"]."<br>";
            echo "<br>¿Esta seguro?";
            ?>
            <form method=post>
                <input type="hidden" name="id" value="<?= $_POST["id"] ?>">
                <input type="hidden" name="nombre" value="<?= $_POST["nombre"] ?>">
                <input type="hidden" name="apellido" value="<?= $_POST["apellido"] ?>">
                <input type="hidden" name="email" value="<?= $_POST["email"] ?>">
                <input type="submit" name="confirmarModificacion" value="Aceptar">
                <input type="submit" name="cancelarModificacion" value="Cancelar">
            </form>
            <?php
        }
        //Si se confirmo la modificacion del Usuario
        if (isset($_POST["confirmarModificacion"])){
            $usuario = new Usuario($_POST['nombre'], $_POST['apellido'], $_POST['email'], null, null, null);
            $c = $usuario->modificar($_POST["id"]);
            
            if ($c==true){
                echo "<h2>El Usuario ha sido modificado con exito</h2>";
            }
            else{
                echo "<h2>Ese mail ya se encuentra registrado</h2>";
            }
        }

        //Si se cancelo la modificacion del Usuario
        if (isset($_POST["cancelarModificacion"])){
            echo "<br><br><h2>No se modifico el Usuario</h2>";
        }





        //-----------------------------ELIMINAR USUARIOS--------------------------------
        #region Eliminar
        if (isset($_GET["eliminar"])){
            $registro = Usuario::tomarDatos($_GET["eliminar"]);

            if ($registro){
                //Formulario para la confirmacion de eliminacion del usuario
                echo "<h2>Esta a punto de eliminar al usuario<br>";
                echo "Nombre: ".$registro["nombre"].", Apellido: ".$registro["apellido"].", Email: ".$registro["email"].", DNI: ".$registro["email"]."<br>";
                echo "<br>¿Esta seguro?";
                ?>
                <form method=post action=?>
                    <input type="hidden" name="id" value="<?= $registro["usu_id"] ?>">
                    <input type="submit" name="confirmarEliminar" value="Si">
                    <input type="submit" name="cancelarEliminar" value="No">
                </form>
                <?php
            }
            else{
                echo "<h2>Ha ocurrido un error</h2>";
            }
        }
        //Si se confirmo la eliminacion del usuario
        if (isset($_POST["confirmarEliminar"])){
            $c = Usuario::eliminar($_POST["id"]);

            if ($c==true){
                echo "<h2>El usuario ha sido eliminado</h2>";
            }
            else{
                echo "<h2>No se pudo eliminar al usuario</h2>";
            }
        }
        //Si se cancelo la eliminacion del usuario
        if (isset($_POST["cancelarEliminar"])){
            echo "<br><br><br><h2>No se ha eliminado al Usuario</h2>";
        }
    ?>













<!-- Botón para cambiar estado -->
<?php
$estado = $detalles['estado'];
$icono = $estado === 'activo' ? 'fa-eye' : 'fa-eye-slash';
$texto = ucfirst($estado);
$clase = $estado === 'activo' ? 'text-success' : 'text-danger';
?>

<form method="POST" action="?" onsubmit="return confirmarCambioEstado('<?php echo $estado; ?>')">
    <input type="hidden" name="cambiarEstado">
    <input type="hidden" name="idCurso" value="<?php echo $_SESSION['curso']; ?>">
    <input type="hidden" name="estadoActual" value="<?php echo $estado; ?>">
    
    <button type="submit" class="btn btn-outline-secondary">
        <i class="fas <?php echo $icono; ?>"></i>
        <span class="<?php echo $clase; ?>">
            <?php echo $texto; ?>
        </span>
    </button>
</form>

<script>
function confirmarCambioEstado(estado) {
    if (estado === 'activo') {
        return confirm("¿Estás seguro de que querés cambiar el estado a INACTIVO?");
    } else {
        return confirm("¿Estás seguro de que querés cambiar el estado a ACTIVO?");
    }
}
</script>

<?php
    if (isset($_POST['cambiarEstado'])){
        Curso::cambiarEstado($_POST['idCurso'], $_POST['estadoActual']);
        header("Location: detallesCurso.php?curso=" . $_POST['idCurso']);
        exit;
    }
?>




</body>
</html>