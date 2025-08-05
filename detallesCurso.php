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
    <style>
    .detalle-container {
  display: flex;
  justify-content: center;    /* Centra ambos bloques horizontalmente */
  align-items: flex-start;    /* Alinea arriba para que el video y la info partan del mismo tope */
  gap: 40px;                  /* Espacio entre video e info */
  flex-wrap: wrap;            /* En pantallas chicas pasa abajo */
  margin-top: 40px;
}

.video-container iframe {
  width: 100%;
  max-width: 560px;
  height: 315px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
}

.info-container {
  max-width: 500px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  font-family: Arial, sans-serif;
}

.info-container p {
  margin: 0;
}

.documento-link img {
  transition: transform 0.2s ease;
}

.documento-link img:hover {
  transform: scale(1.1);
}

form {
  margin-top: 10px;
}

button {
  padding: 6px 12px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
}

button i {
  margin-right: 5px;
}
</style>
  
</head>
<body>
    <?php
    #region Mostrar 
//Mostrar detalles del curso
if (isset($_GET['curso'])) {
    echo '<div class="detalle-container">';

    // --------------------Video de YouTube---------------------
    $url = $detalles['video'];
    function extraerIDYoutube($url) {
        if (strpos($url, "youtube.com") !== false) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            return $params['v'] ?? null;
        }
        if (strpos($url, "youtu.be/") !== false) {
            return basename(parse_url($url, PHP_URL_PATH));
        }
        return null;
    }
    $id = extraerIDYoutube($url);
    ?>

    <!-- Video a la izquierda -->
    <div class="video-container">
        <?php if ($id): ?>
            <iframe 
                src="https://www.youtube.com/embed/<?php echo htmlspecialchars($id); ?>"
                frameborder="0" allowfullscreen>
            </iframe>
        <?php else: ?>
            <p>URL no válida de YouTube</p>
        <?php endif; ?>
    </div>

    <!-- Contenido a la derecha -->
    <div class="info-container">
        <p><strong>Nombre:</strong> <?php echo $detalles['nombre']; ?></p>
        <p><strong>Área:</strong> <?php echo $detalles['area']; ?></p>
        <p><strong>Descripción:</strong> <?php echo $detalles['cur_desc']; ?></p>

        <!-- Documento de Google -->
        <a class="documento-link"
           href="<?php echo htmlspecialchars($detalles['pdf']); ?>"
           target="_blank"
           title="Ver documento">
            <img src="https://ssl.gstatic.com/docs/doclist/images/icon_11_document_list.png"
                 alt="Google Doc" width="48" height="48">
        </a>

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

        <!-- Botón Modificar -->
        <form action="?modificar" method="post">
            <button title="Modificar" type="submit" name="modificar" value="<?= $_GET['curso'] ?>">
                <i class="fas fa-edit"></i> Modificar
            </button>
        </form>
    </div>

    <?php
    echo '</div>'; // cierre de .detalle-container
}
#endregion

    ?>


    <!-- -------------------------Logica cambio de estado-------------------------------- -->
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
    





    
    
    <!-- -----------------------Formulario para modificar curso------------------------ -->
    <?php
    #region Modificar
    if (isset($_GET["modificar"])){
            $registro= Curso::tomarDatos($_POST["modificar"]);

            if ($registro){
                ?>
                <br>
                <div class="formularios">
                <form method="post" action="?">
                    <h2>Modificacion de Curso</h2>
                    <input type="hidden" name="id" value="<?= $registro["cur_id"] ?>">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" name="nombre" id="nombre" value="<?= $registro["nombre"] ?>" maxlength="30" required> <br><br>
                    <label for="apellido">Area:</label><br>
                    <select name="area" id="area">
                        <option value="cocina" <?= $registro["area"] == 'cocina' ? 'selected' : '' ?>>Cocina</option>
                        <option value="atencion" <?= $registro["area"] == 'atencion' ? 'selected' : '' ?>>Atención al Cliente</option>
                        <option value="limpieza" <?= $registro["area"] == 'limpieza' ? 'selected' : '' ?>>Limpieza</option>
                    </select><br>
                    
                    <label for="url">Video:</label><br>
                    <input type="text" id="url" name="url" value="<?= $registro["video"] ?>" required><br>
                    <label for="documento">Documento: </label><br>
                    <input type="text" id="documento" name="documento" value="<?= $registro["pdf"] ?>" required><br>
                    <label for="email">Descripción:</label><br>
                    <textarea name="desc" id="desc" required><?= $registro["cur_desc"] ?></textarea>
                    <input type="submit" name="modificacion" value="Aceptar" onclick="return confirm('¿Está seguro?');">
                </form>
                <form method="post" action="?">
                    <input type="submit" value="Cancelar" formAction="detallesCurso.php?curso=<?= $registro['cur_id'] ?>">
                </form>
                </div>
                <?php
            }
            else{
                echo "<h2>Ha ocurrido un error</h2>";
            }
        }
        //Si se confirmo la modificacion del Usuario
        if (isset($_POST["modificacion"])){
            $curso = new Curso($_POST['nombre'], $_POST['area'], $_POST['desc'], $_POST['url'], $_POST['documento']);
            $c = $curso->modificar($_POST["id"]);
            
            if ($c==true){
                header("Location: detallesCurso.php?curso=" . $_POST["id"]);
            }
            else{
                echo "<h2>Ocurrio un error</h2>";
            }
        }
    ?>
</body>
</html>