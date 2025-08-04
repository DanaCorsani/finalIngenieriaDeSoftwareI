<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Usuarios</title>
</head>
<body>
    <a href=?listar><button>Lista de Usuarios</button></a>
    <a href=?altas><button>Cargar Usuarios</button></a>   
    <form method="get" action="?buscar">
        <input type="text" name="buscar" required>
        <select name="opcion">
            <option value="nombre">Nombre</option>
            <option value="apellido">Apellido</option>
            <option value="email">Email</option>
            <option value="dni">DNI</option>
        </select>
        <input type=submit value=Buscar>
    </form>





    <?php
    require 'clases.php';
    //-----------------------------LISTAR Y BUSCAR USUARIOS--------------------------------
    #region Listar/Buscar
    if (isset($_GET["listar"]) || isset($_GET["buscar"])){

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
                            <td>
                                <button title="Modificar" type="submit" name="modificar" value="<?= $usuario["usu_id"] ?>"><i class="fas fa-edit"></i></button>
                                <button title="Eliminar" type="submit" name="eliminar" value="<?= $usuario["usu_id"] ?>"><i class="fas fa-trash-alt"></i></button>
                            </td>
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



        //-----------------------------CARGAR USUARIOS--------------------------------
        #region Cargar
        if (isset($_GET["altas"])){
            ?>
            <form method="post" action="?altas">
                <h2>Cargar Usuario</h2>
                <input type="hidden" name="cargar">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" maxlength="30" required><br>
                <label for="apellido">Apellido:</label><br>
                <input type="text" id="apellido" name="apellido" maxlength="30" required><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" maxlength="30" required><br>
                <label for="dni">DNI:</label><br>
                <input type="int" id="dni" name="dni" maxlength="8" minleght="8" required><br>
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
            $usuario = new Usuario($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['dni'], $_POST['clave'], $_POST['rol']);
            $resultado=$usuario->cargar();

            if($resultado==true){
                echo "<h2>Usuario cargado correctamente</h2>";
            }
            else{
                echo "<h2>El usuario ya existe</h2>";
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
</body>
</html>