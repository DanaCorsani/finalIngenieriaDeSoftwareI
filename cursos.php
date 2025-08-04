<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <form method="post" action="?altas">
                <h2>Cargar Curso</h2>
                <input type="hidden" name="cargar">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" maxlength="30" required><br>
                <label for="area">Area:</label><br>
                <select name="area" id="area">
                    <option value="cocina">Cocina</option>
                    <option value="atencion">Atención al Cliente</option>
                    <option value="limpieza">Limpieza</option>
                </select>
                <label for="desc">Descripción:</label><br>
                <textarea name="desc" id="desc"></textarea>
                <input type="submit" value="Aceptar">
            </form>
            <?php
            if (isset($_POST["cargar"])) {
            $usuario = new Curso($_POST['nombre'], $_POST['area'], $_POST['desc']);
            $resultado=$usuario->cargar();

            if($resultado==true){
                echo "<h2>Curso cargado correctamente</h2>";
            }
            else{
                echo "<h2>El curso ya existe</h2>";
            }
        }
        }
        
    ?>
</body>
</html>