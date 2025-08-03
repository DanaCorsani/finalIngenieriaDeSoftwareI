<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    if (isset($_GET["listar"])){
            $lista=Usuario::listar();

            if ($lista){
                ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
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
                            <td><?= $usuario["email"] ?></td>
                            <td><input type="radio" name="opcion" value="<?= $usuario["usu_id"] ?>" required></td>
                        </tr>
                        <?php
                    }
                    ?>
                <th colspan=5>
                    <input type="submit" name="modificar" value="Modificar">
                    <input type="submit" name="eliminar" value="Eliminar">
                </th>    
                </form></table>
                <?php
            }
            else{
                echo "<h2>No hay usuarios cargados</h2>";
            }
        }
    ?>
</body>
</html>