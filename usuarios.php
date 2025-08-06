<?php
    require 'clases.php';
    //Si se confirmo la modificacion del Usuario
    if (isset($_POST["modificacion"])){
        $usuario = new Usuario($_POST['nombre'], $_POST['apellido'], $_POST['email'], null, null, null, null);
        $c = $usuario->modificar($_POST["id"]);
        
        if ($c==true){
            // Preparás el mensaje
            $msg = addslashes("¡Usuario modificado correctamente!");
            // En lugar de header, imprimís un script
            echo <<<HTML
            <script>
            alert("$msg");
            // Cuando el usuario cierra el alert, se ejecuta esto:
            window.location.href = "usuarios.php?listar";
            </script>
            HTML;
            exit;
        }
        else{
            ?>
            <script>
            alert("No se pudo modificar al usuario.");
            </script>
            <?php
        }
    }

    //Si se confirmo el cambio de estado del Usuario
        if (isset($_GET["estado"])){
            $registro = Usuario::tomarDatos($_GET["estado"]);
            Usuario::cambiarEstado($registro['usu_id'], $registro['estado']);
            header("Location: usuarios.php?listar");
            exit;
        }

    if (isset($_GET["desempenio"])){
        header("Location: desempenio.php?usu_id=".$_GET["desempenio"]);
        exit;
    }
?>
<?php
# (v) continuo sesion
session_start();
# (v) cerrar sesion
if(isset($_POST["cerrar"])){
    session_unset();
    session_destroy();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Usuarios</title>
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
        #formularioCurso input[type="email"],
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
            width: 60%;
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

       footer {
  grid-area: footer;
  display: flex;
  justify-content: space-between;
  color: sandybrown;
  font-weight: 900;
  position: fixed;         /* 👈 Cambio importante */
  bottom: 0;
  left: 0;
  right: 0;
  background-color: darkred;
  font-family: Arial, sans-serif;
  padding: 0 1rem;
  z-index: 1000;           /* 👈 Asegura que quede por encima de otros elementos si es necesario */
}
    </style>
</head>
<body>
    <?php
    #region HTML/PHP
    include_once "navbar.php";
    ?>
    
    <br>
    <div class="top-bar">
        <div class="left">
            <a href="?listar"><button>Lista de Usuarios</button></a>
        </div>
        <div class="center">
            <a href="?altas"><button>Cargar Usuario</button></a>
        </div>
        <div class="right">
            <form method="get" action="?buscar">
                <input type="text" name="buscar" placeholder="Buscar..." required>
                <select name="opcion">
                    <option value="nombre">Nombre</option>
                    <<option value="apellido">Apellido</option>
                <option value="email">Email</option>
                <option value="dni">DNI</option>
                </select>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div><br>





    <?php

    //-----------------------------LISTAR Y BUSCAR USUARIOS--------------------------------
    #region Listar/Buscar
    if (isset($_GET["listar"]) || isset($_GET["buscar"])){
        echo "<h2 style='text-align:center;'>Lista de Usuarios</h2>";
        if (isset($_GET["listar"])){
            $lista=Usuario::listar();
        } elseif (isset($_GET["buscar"])){
            $lista=Usuario::buscar($_GET["buscar"], $_GET["opcion"]);
        }

            if ($lista){
                ?>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>DNI</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                    <form>
                    <?php
                    foreach($lista as $usuario){
                        ?>
                        <tr>
                            <td><?= $usuario["nombre"] ?></td>
                            <td><?= $usuario["apellido"] ?></td>
                            <td><?= $usuario["email"] ?></td>
                            <td><?= $usuario["dni"] ?></td>
                            <td><?= $usuario["estado"] ?></td>
                            <td>
                                <button title="Ver Desempeño" type="submit" name="desempenio" value="<?= $usuario["usu_id"] ?>"><i class="fas fa-eye"></i></button>
                                <button title="Modificar" type="submit" name="modificar" value="<?= $usuario["usu_id"] ?>"><i class="fas fa-edit"></i></button>
                                <button title="Cambiar Estado" type="submit" name="estado" value="<?= $usuario["usu_id"] ?>" onclick="return confirmarCambioEstado('<?php echo $usuario['estado']; ?>')"><i class="fas fa-sync-alt"></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>   
                </form>
            </table>
                <?php
            }
            else{
                echo "<h2>No hay resultados</h2>";
            }
        }



        //-----------------------------CARGAR USUARIOS--------------------------------
        #region Cargar
        if (isset($_GET["altas"])){
            ?>
            <form id="formularioCurso" method="post" action="?altas">
                <h2>Cargar Usuario</h2>
                <input type="hidden" name="cargar">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" maxlength="30" required><br>
                <label for="apellido">Apellido:</label><br>
                <input type="text" id="apellido" name="apellido" maxlength="30" required><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" maxlength="30" required><br>
                <label for="dni">DNI:</label><br>
                <input type="text" id="dni" name="dni" maxlength="8" minleght="8" min="1" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required><br>
                <label for="clave">Contraseña:</label><br>
                <input type="text" id="clave" name="clave" minleght="5" maxlength="30" required><br>
                <label for="rol">Rol:</label><br>
                <select name="rol" id="rol">
                    <option value="2">Usuario</option>
                    <option value="1">Administrador</option>
                </select><br>
                <input type="submit" value="Aceptar">
            </form>
            <?php
            if (isset($_POST["cargar"])) {
            $usuario = new Usuario($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['dni'], $_POST['clave'], $_POST['rol'], $_POST['activo']);
            $resultado=$usuario->cargar();

            if($resultado==true){
                echo "<script>alert('Usuario cargado correctamente');</script>";
            }
            else{
                echo "<script>alert('Ese DNI o Email ya se encuentra cargado');</script>";
            }
        }
        }

        //-----------------------------MODIFICAR USUARIOS--------------------------------
        #region Modificar
        if (isset($_GET["modificar"])){
            $registro= Usuario::tomarDatos($_GET["modificar"]);

            if ($registro){
                ?>
                <br>
                <!-- Formulario de modificacion de Usuario -->
                <div class="formularios">
                <form id="formularioCurso" method="post" action="?">
                    <h2>Modificacion de Usuario</h2>
                    <input type="hidden" name="modificacion">
                    <input type="hidden" name="id" value="<?= $registro["usu_id"] ?>">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" name="nombre" id="nombre" value="<?= $registro["nombre"] ?>" maxlength="30" required> <br><br>
                    <label for="apellido">Apellido:</label><br>
                    <input type="text" name="apellido" id="apellido" value="<?= $registro["apellido"] ?>" maxlength="30" required> <br><br>
                    <label for="email">Email:</label><br>
                    <input type="email" name="email" id="email" value="<?= $registro["email"] ?>" maxlength="30" required> <br><br>
                    <input type="submit" name="modificacion" value="Aceptar" onclick="return confirm('¿Está seguro?');">
                </form>
                </div>
                <?php
            }
            else{
                echo "<h2>Ha ocurrido un error</h2>";
            }
        }

        



        #region Estado
        //-----------------------------CAMBIAR ESTADO USUARIOS--------------------------------
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
        <?php



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
    <br><br><br><br><br>
    <footer class="footer">
        <h3 id="rights">@2025 ISFTyD24</h3>
        <div id="names">
            <h4>Dana Corsani, Alexis Gomez, Julieta Camara, Ramiro Ramos</h4>
        </div>
    </footer>
</body>
</html>
