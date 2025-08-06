<?php
session_start();
require 'clases.php';
if (isset($_GET['curso'])) {
    $_SESSION['curso'] = $_GET['curso'];
}
$detalles=Curso::tomarDatos($_SESSION['curso']);

if (isset($_POST['cambiarEstado'])){
    Curso::cambiarEstado($_POST['idCurso'], $_POST['estadoActual']);
    header("Location: detallesCurso.php?curso=" . $_POST['idCurso']);
    exit;
}
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

        .video-container {
        /* Opción: que el contenedor tenga siempre un ancho base fijo */
        flex: 0 0 650px;    /* ancho “base” 700px, sin crecer ni encoger */
        max-width: 650px;   /* no podrá superar 700px */
        }

        .video-container iframe {
        width: 100%;            /* ocupa todo el ancho del contenedor */
        aspect-ratio: 16/9;     /* mantiene la proporción */
        height: auto;
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
        .documento-button {
        display: inline-flex;
        /* evita que el flex parent lo estire */
        flex: 0 0 auto;        
        /* garantiza que el ancho dependa del contenido */
        width: 30%; 
        align-items: center;
        gap: 8px;                     /* espacio entre imagen y texto */
        padding: 8px 12px;
        background-color: #FFEB99;    /* azul bootstrap, cambialo si querés */
        color: #333;
        text-decoration: none;
        font-weight: 400;
        border: none;
        border-radius: 4px;
        transition: background-color 0.2s ease;
        }

        .documento-button:hover {
        background-color: #F4E04D;    /* un azul más oscuro al pasar el mouse */
        }

        .documento-button img {
        width: 20px;                  /* lo achicás a 32×32 */
        height: 20px;
        transition: transform 0.2s ease;
        }

        .documento-button img:hover {
        transform: scale(1.1);
        }

        .documento-button span {
        font-size: 1rem;
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
        .mi-encabezado-h2 {
        font-size: 1.75rem;  /* el tamaño que necesites */
        margin: 0;           /* quita márgenes arriba y abajo */
        padding: 0;          /* opcional, si también tuviera padding */
        }



        /* --------------ESTILO DEL FORMULARIO DE MODIFICACION----------------- */
        /* Contenedor del formulario */
        #formularioCurso {
        max-width: 600px;
        margin: 40px auto;            /* Centrado horizontal + margen superior */
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        }

        /* Título */
        #formularioCurso h2 {
        margin-top: 0;
        color: #333;
        text-align: center;
        }

        /* Etiquetas */
        #formularioCurso label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
        color: #555;
        }

        /* Campos de texto y select */
        #formularioCurso input[type="text"],
        #formularioCurso select,
        #formularioCurso textarea {
        width: 100%;
        padding: 8px 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
        resize: vertical;
        }

        /* Textarea específico */
        #formularioCurso textarea {
        height: 100px;
        }

        /* Botón de submit */
        #formularioCurso input[type="submit"] {
        display: block;
        width: 40%;
        max-width: 200px;
        margin: 25px auto 0 auto;   /* Centrado horizontal */
        padding: 10px;
        background-color: #ffcc00;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s ease;
        }

        #formularioCurso input[type="submit"]:hover {
        background-color: #e6b800;
        }
    </style>
  
</head>
<body>
    <?php
    include_once "navbar.php";
    ?>
    
    <?php
    #region Mostrar 
    //---------------------------MOSTRAR EL CONTENIDO DEL CURSO---------------------------
    if (isset($_GET['curso'])) {
        echo '<div class="detalle-container">';

        //Video de YouTube
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
            <h2 class="mi-encabezado-h2"><?php echo $detalles['nombre']; ?></h2>
            <p><?php echo $detalles['cur_desc']; ?></p>

            <!-- Documento de Google -->
            <a class="documento-button"
            href="<?php echo htmlspecialchars($detalles['pdf']); ?>"
            target="_blank"
            title="Ver documento">
            <img
                src="https://ssl.gstatic.com/docs/doclist/images/icon_11_document_list.png"
                alt="Google Doc">
            <span>Ver instrucciones</span>
            </a>

            <!-- Botón para cambiar estado -->
            <?php
            $estado = $detalles['estado'];
            $icono = $estado === 'activo' ? 'fa-eye' : 'fa-eye-slash';
            $texto = ucfirst($estado);
            $clase = $estado === 'activo' ? 'text-success' : 'text-danger';
            ?>

            <?php
            if ($_SESSION['rol'] == 1) {
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
               <?php
            }
            ?>
            

            <?php
            $resultado = Curso::tieneExamen($_GET['curso']);
            if ($resultado==false){
                ?>
                <!-- Botón Crear Examen -->
                <form action="crearExamen.php" method="post">
                    <button title="Crear Examen" type="submit" name="id" value="<?= $_GET['curso'] ?>">
                        <i class="fas fa-file-lines"></i> Crear Examen
                    </button>
                    </form>
                <?php
            } else{
                require_once "clases.php";
                $r = Curso::usuarioRealizoExamen($_SESSION['usu_id'], $_GET['curso']);
                if ($r == false) {
                    ?>
                    <!-- Botón Hacer Examen -->
                    <form action="examen.php" method="post">
                    <button title="Realizar Examen" type="submit" name="id" value="<?= $_GET['curso'] ?>">
                        <i class="fas fa-file-lines"></i> Realizar Examen
                    </button>
                    </form>
                <?php
                } else {
                    ?>
                    <!-- Botón Ver Examen -->
                    <form action="verExamen.php" method="post">
                        <button title="Ver Examen" type="submit" name="id" value="<?= $_GET['curso'] ?>">
                            <i class="fas fa-file-lines"></i> Ver Examen
                        </button>
                    </form>
                    <?php
                }
                ?>
                <?php
            }
            ?>

            

            
        </div>

        <?php
        echo '</div>'; // cierre de .detalle-container
    }

    #region Estado
    //-------------------------Logica cambio de estado--------------------------------
    ?>
    <script>
        function confirmarCambioEstado(estado) {
            if (estado === 'activo') {
                return confirm("¿Estás seguro de que querés cambiar el estado a INACTIVO?");
            } else {
                return confirm("¿Estás seguro de que querés cambiar el estado a ACTIVO?");
            }
        }
    </script>
    



    
    
    <!-- -----------------------MODIFICAR CURSO------------------------ -->
    <?php
    #region Modificar
    if (isset($_GET["modificar"])){
            $registro= Curso::tomarDatos($_POST["modificar"]);

            if ($registro){
                ?>
                <br>
                <div class="formularios">
                <form id="formularioCurso" method="post" action="?">
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
        //Si se confirmo la modificacion del Curso
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
