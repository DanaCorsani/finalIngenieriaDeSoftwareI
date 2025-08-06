<?php
session_start();
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desempeño</title>
    <link rel="icon" href="favicon.png" type="image/png">
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
</style>


</head>
<body>
    <?php
    $usu_id = $_SESSION["usu_id"];
    require_once "clases.php";
    $usuario = Usuario::tomarDatos($usu_id);
        echo '<br><h2 class="titulo-tabla">Desempeño en los Cursos</h2>';
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
</body>
</html>