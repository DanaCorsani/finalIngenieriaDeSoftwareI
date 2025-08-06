<?php
session_start();
include_once "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Cursos</title>
    <link rel="icon" href="favicon.png" type="image/png">
    <style>
        /* --------------ESTILO DEL FORMULARIO DE CARGA----------------- */
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



        /* -----------------ESTILO DE LAS TABLAS----------------- */
        /* Tabla de cursos */   
        table {
            width: 45%;
            max-width: 900px;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        th {
            background-color: #ffeb99;
            color: #333;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        td button {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #666;
            padding: 4px;
        }

        td button:hover {
            color: #333;
        }

        /* Ajuste para que el botón no empuje el texto */
        td:first-child {
            width: 50px;
            text-align: center;
        }


        /* -----------------ESTILO DE LAS OPCIONES (LISTAR, CARGAR Y BUSCAR)----------------- */
        .top-bar {
        display: flex;
        align-items: center;
        justify-content: center;  /* Centra todos los bloques */
        gap: 20px;                 /* Espacio entre cada bloque */
        margin: 20px auto;         /* Centra la barra dentro de la página */
        max-width: 800px;          /* Ancho máximo deseado */
        }

        .top-bar .left,
        .top-bar .center,
        .top-bar .right {
            display: flex;
            align-items: center;
            gap: 8px;                  /* Espacio interno ligero en cada bloque */
        }

        /* Quitamos el empuje al final */
        .top-bar .right {
            margin-left: 0;
        }

        .top-bar button,
        .top-bar input[type="submit"] {
            background-color: #ffcc00;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 0;
        }

        .top-bar button:hover,
        .top-bar input[type="submit"]:hover {
            background-color: #e6b800;
        }

        .top-bar input[type="text"],
        .top-bar select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin: 0;
        }

        .top-bar i {
            pointer-events: none;
        }

        footer{
            grid-area: footer;
            display: flex;
            justify-content: space-between;
            color: #450101;
            font-weight: 900;
            position: fixed;    /*pongo una posicion fija para el texto del footer */
            bottom: 0;          /*setteo que el texto quede bien al final de la pagina, pegado. */
            left: 0;
            right: 0;
            top: 93vh;
            background-color: orangered;
            padding: 0 1rem;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    
    <div class="top-bar">
        <div class="left">
            <a href="?listar"><button>Lista de Cursos</button></a>
        </div>
        <?php
            if($_SESSION['rol_id']==1){
                ?>
            <div class="center">
            <a href="?altas"><button>Cargar Curso</button></a>
            </div>
            <?php
            }else{}
            ?>
        
        <div class="right">
            <form method="get" action="?buscar">
                <input type="text" name="buscar" placeholder="Buscar..." required>
                <select name="opcion">
                    <option value="nombre">Nombre</option>
                    <option value="area">Área</option>
                </select>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>





    <?php
    #region Listar/Buscar
    require 'clases.php';
    // --------------------------------- LISTAR Y BUSCAR CURSOS --------------------------------
if (isset($_GET["listar"]) || isset($_GET["buscar"])) {

    echo "<h2 style=\"text-align:center; margin-top:40px;\">Lista de Cursos</h2>";
    if (isset($_GET["listar"])) {
        $lista = Curso::listar();
    } elseif (isset($_GET["buscar"])) {
        $lista = Curso::buscar($_GET["buscar"], $_GET["opcion"]);
    }

    if ($lista) {
        // ---> Acá comienza el nuevo código de la tabla
        ?>
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Nombre</th>
              <th>Área</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($lista as $curso): ?>
              <tr>
                <td>
                  <!-- Form individual para cada botón -->
                  <form action="detallesCurso.php" method="get">
                    <button type="submit" name="curso" value="<?= $curso['cur_id'] ?>" title="Entrar">
                      <i class="fas fa-eye"></i>
                    </button>
                  </form>
                </td>
                <td><?= htmlspecialchars($curso['nombre']) ?></td>
                <td><?= htmlspecialchars($curso['area']) ?></td>
                <?php   
                if ($_SESSION["rol_id"] == 1){
                    ?>
                    <td><?= htmlspecialchars($curso['estado']) ?></td>    
                    <?php
                } else{
                    $estado = Curso::usuarioHizoCurso($_SESSION["usu_id"], $curso['cur_id']);
                    if ($estado) {
                        $estado = "Completado";
                    } else {
                        $estado = "Pendiente";
                    }
                    ?>
                    <td><?= htmlspecialchars($estado) ?></td>    
                    <?php
                }
                ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php
        // ---> Fin del nuevo código de la tabla
    }
    else {
        echo "<h2 style=\"text-align:center; margin-top:40px;\">No hay resultados</h2>";
    }
}




        //-----------------------------CARGAR CURSO--------------------------------
        #region Cargar
        if (isset($_GET["altas"])){
            ?>
            <form id="formularioCurso" method="post" action="?altas">
                <h2>Cargar Curso</h2>
                <input type="hidden" name="cargar">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" maxlength="30" required><br>
                <label for="area">Area:</label><br>
                <select name="area" id="area">
                    <option value="cocina">Cocina</option>
                    <option value="atencion">Atención al Cliente</option>
                    <option value="limpieza">Limpieza</option>
                </select><br>
                <label for="url">Video:</label><br>
                <input type="text" id="url" name="url" required><br>
                <label for="documento">Documento: </label><br>
                <input type="text" id="documento" name="documento"><br>
                <label for="desc">Descripción:</label><br>
                <textarea name="desc" id="desc"></textarea>
                <input type="submit" value="Aceptar">
            </form>
            <?php
            if (isset($_POST["cargar"])) {
            $curso = new Curso($_POST['nombre'], $_POST['area'], $_POST['desc'], $_POST['url'], $_POST['documento']);
            $resultado=$curso->cargar();

            if($resultado==true){
                echo "<script>alert('Curso cargado correctamente');</script>";
            }
            else{
                echo "<script>alert('No se pudo cargar el curso');</script>";
            }
        }
        }
        
    ?>

<footer class="footer">
        <h3 id="rights">@2025 ISFTyD24</h3>
        <div id="names">
            <h4>Dana Corsani, Alexis Gomez, Julieta Camara, Ramiro Ramos, Leonardo Camacho </h4>
        </div>
    </footer>


    <script>
document.getElementById("formularioCurso").addEventListener("submit", function(event) {
    const urlVideo = document.getElementById("url").value;
    const urlDoc = document.getElementById("documento").value;

    const regexYoutube = /^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[\w-]{11}$/;
    const regexGoogleDoc = /^https?:\/\/docs\.google\.com\/document\/d\/[\w-]+(\/.*)?$/;

    if (!regexYoutube.test(urlVideo)) {
        alert("Por favor ingresá una URL válida de un video de YouTube.");
        event.preventDefault();
        return;
    }

    if (urlDoc.trim() !== "" && !regexGoogleDoc.test(urlDoc)) {
        alert("Por favor ingresá un enlace válido de un documento de Google Docs.");
        event.preventDefault();
        return;
    }
});
</script>

</body>
</html>
