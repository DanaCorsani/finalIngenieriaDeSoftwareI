<?php
session_start();
include 'navbar.php';
$usu_id = $_SESSION['usu_id']; // Asegurate de tener el login activo
$cur_id = $_POST['id'] ?? null; // ID del curso pasado por GET (ej: verRespuestas.php?id=3)

if (!$cur_id) {
    die("Curso no especificado.");
}

// Función para obtener respuestas
function obtenerRespuestasUsuario($usu_id, $cur_id) {
    $mysqli = new mysqli("localhost", "root", "", "ambd");
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $sql = "
        SELECT 
            p.texto AS pregunta,
            ou.texto AS opcion_usuario,
            oc.texto AS opcion_correcta,
            CASE WHEN ou.opt_id = oc.opt_id THEN 1 ELSE 0 END AS es_correcta
        FROM respuestas r
        INNER JOIN preguntas p ON r.preg_id = p.preg_id
        INNER JOIN opciones ou ON r.opt_id = ou.opt_id
        INNER JOIN opciones oc ON p.preg_id = oc.preg_id AND oc.es_correcta = 1
        WHERE r.usu_id = ? AND p.cur_id = ?
        ORDER BY p.preg_id
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $usu_id, $cur_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $respuestas = [];
    while ($fila = $result->fetch_assoc()) {
        $respuestas[] = [
            'pregunta' => $fila['pregunta'],
            'respuesta_usuario' => $fila['opcion_usuario'],
            'respuesta_correcta' => $fila['opcion_correcta'],
            'es_correcta' => (bool) $fila['es_correcta']
        ];
    }

    $stmt->close();
    $mysqli->close();

    return $respuestas;
}

$respuestas = obtenerRespuestasUsuario($usu_id, $cur_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="favicon.png" type="image/png">
  <title>Respuestas del Examen</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef1f5;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 30px;
      background-color: #fff;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }
    .respuesta {
      border-left: 4px solid #007BFF;
      padding: 15px;
      margin-bottom: 20px;
      background-color: #f9f9f9;
      border-radius: 4px;
    }
    .respuesta.correcta {
      border-left-color: #28a745;
      background-color: #eaf8ed;
    }
    .respuesta.incorrecta {
      border-left-color: #dc3545;
      background-color: #fcebea;
    }
    .respuesta strong {
      color: #007BFF;
      display: block;
      margin-bottom: 8px;
    }
    .correcta-text {
      color: #28a745;
      font-weight: bold;
    }
    .incorrecta-text {
      color: #dc3545;
      font-weight: bold;
    }
    .detalle {
      margin-top: 5px;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Respuestas del Examen</h1>

    <?php if (empty($respuestas)): ?>
      <p>No se encontraron respuestas para este examen.</p>
    <?php else: ?>
      <?php foreach ($respuestas as $r): ?>
        <div class="respuesta <?= $r['es_correcta'] ? 'correcta' : 'incorrecta' ?>">
          <strong>Pregunta:</strong> <?= htmlspecialchars($r['pregunta']) ?><br>
          <div class="detalle">
            Tu respuesta: <em><?= htmlspecialchars($r['respuesta_usuario']) ?></em><br>
            Respuesta correcta: <em><?= htmlspecialchars($r['respuesta_correcta']) ?></em><br>
            <?= $r['es_correcta'] 
              ? '<span class="correcta-text">✔ Correcta</span>' 
              : '<span class="incorrecta-text">✘ Incorrecta</span>' ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
