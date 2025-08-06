<?php
session_start();
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Mi Perfil</title>
    <style>
      .tabla-desempeno {
        width: 50%;
        max-width: 800px;
        margin: 30px auto;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }

      .tabla-desempeno th, .tabla-desempeno td {
        padding: 12px 16px;
        border: 1px solid #ddd;
        text-align: center;
      }

      .tabla-desempeno thead {
        background-color: #f1c40f; /* amarillo */
        color: #333;
      }

      .tabla-desempeno tbody tr:nth-child(even) {
        background-color: #f9f9f9;
      }

      .tabla-desempeno tbody tr:hover {
        background-color: #fff8dc;
      }

      .titulo-tabla {
        text-align: center;
        font-family: Arial, sans-serif;
        font-size: 1.8rem;
        color: #555;
        margin-top: 40px;
        margin-bottom: 20px;
        font-weight: bold;
      }

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
  <!-- PERFIL -->
    <?php
    echo '<br><h2 class="titulo-tabla">Mi Perfil</h2>';
      ?>
    <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Email</th>
              <th>DNI</th>
              <th>Rol</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><?= htmlspecialchars($_SESSION['usu_id']) ?></td>
                <td><?= htmlspecialchars($_SESSION['nombre']) ?></td>
                <td><?= htmlspecialchars($_SESSION['apellido']) ?></td>
                <td><?= htmlspecialchars($_SESSION['usuario']) ?></td>
                <td><?= htmlspecialchars($_SESSION['dni']) ?></td>
                <td><?php
                if($_SESSION['rol_id']==1){
                  echo "Administrador";
                } else {
                  echo "Usuario Comun";
                }
                ?></td>
              </tr>
          </tbody>
        </table>

                <!-- DESEMPEÑO -->

    <?php
    $usu_id = $_SESSION["usu_id"];
    require_once "clases.php";
    $usuario = Usuario::tomarDatos($usu_id);
        echo '<br><h2 class="titulo-tabla">Mi Desempeño</h2>';
require_once "clases.php";
$datos = Curso::obtenerDesempenoUsuario($usu_id);

echo '<table class="tabla-desempeno">';
echo '<thead><tr><th>Curso</th><th>Nota</th><th>Estado</th></tr></thead>';
echo '<tbody>';

foreach ($datos as $curso) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($curso['curso']) . '</td>';
    echo '<td>' . htmlspecialchars($curso['nota']) . '</td>';
    echo '<td>' . htmlspecialchars($curso['estado']) . '</td>';
    echo '</tr>';
}

echo '</tbody></table>';

    ?>
    <br><br><br>
    <footer class="footer">
        <h3 id="rights">@2025 ISFTyD24</h3>
        <div id="names">
            <h4>Dana Corsani, Alexis Gomez, Julieta Camara, Ramiro Ramos</h4>
        </div>
    </footer>
</body>
</html>