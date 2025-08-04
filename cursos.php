<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Cursos</title>
</head>
<body>
    <a href=?listar><button>Lista de Cursos</button></a>
    <a href=?altas><button>Cargar Curso</button></a>   
    <form method="get" action="?buscar">
        <input type="text" name="buscar" required>
        <select name="opcion">
            <option value="nombre">Nombre</option>
            <option value="area">Area</option>
        </select>
        <input type=submit value=Buscar>
    </form>





    <?php
    require 'clases.php';
    //-----------------------------LISTAR Y BUSCAR CURSOS--------------------------------
    #region Listar/Buscar
    if (isset($_GET["listar"]) || isset($_GET["buscar"])){

        if (isset($_GET["listar"])){
            $lista=Curso::listar();
        } elseif (isset($_GET["buscar"])){
            $lista=Curso::buscar($_GET["buscar"], $_GET["opcion"]);
        }

            if ($lista){
                ?>
                <table>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Area</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                    <form action="detallesCurso.php">
                    <?php
                    foreach($lista as $curso){
                        ?>
                        <tr>
                            <td><button title="Entrar" type="submit" name="curso" value="<?= $curso["cur_id"] ?>"><i class="fas fa-eye"></i></button></td>
                            <td><?= $curso["nombre"] ?></td>
                            <td><?= $curso["area"] ?></td>
                            <td><?= $curso["estado"] ?></td>
                        </tr>
                        <?php
                    }
                    ?>   
                </form></table>
                <?php
            }
            else{
                echo "<h2>No hay resultados</h2>";
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
                echo "<h2>Curso cargado correctamente</h2>";
            }
            else{
                echo "<h2>El curso ya existe</h2>";
            }
        }
        }
        
    ?>



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