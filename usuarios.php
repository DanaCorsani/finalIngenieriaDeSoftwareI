<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <a href=?listar><button>Lista de Usuarios</button></a>
    <a href=?altas><button>Cargar Usuarios</button></a>   
    <form method=get>
        <input type="hidden" name="buscar">
        <input type=text name=buscado required>
        <select name="" id="">
            <option value="nombre">Nombre</option>
            <option value="apellido">Apellido</option>
            <option value="email">Email</option>
            <option value="dni">DNI</option>
        </select>
        <input type=submit value=Buscar>
    </form>





    <?php
    require 'clases.php';
    if (isset($_GET["listar"])){
            $lista=Usuario::listar();

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
                echo "<h2>No hay usuarios cargados</h2>";
            }
        }




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
                <input type="text" id="email" name="email" maxlength="30" required><br>
                <label for="dni">DNI:</label><br>
                <input type="text" id="dni" name="dni" maxlength="8" minleght="8" required><br>
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
    ?>
</body>
</html>