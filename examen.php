<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cur_id'])) {
        $cur_id = $_POST['cur_id'];
        $respuestas = $_POST['respuestas'];
        $usu_id = $_SESSION['usu_id']; // Reemplazar con el ID del usuario actual
        require_once "clases.php";
        $nota = Curso::corregirExamen($usu_id, $cur_id, $respuestas);
        echo "<script>
                alert('Tu nota fue: $nota / 10');
                window.location.href = 'detallesCurso.php?curso=" . $cur_id . "';
            </script>";

    }
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="favicon.png" type="image/png">
  <title>Resolver Examen</title>
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #fff8e1; /* Fondo suave, estilo crema */
    margin: 0;
    padding: 0;
    }

    .container {
    max-width: 800px;
    margin: 40px auto;
    padding: 30px;
    background-color: white;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 8px;
    }

    h1 {
    text-align: center;
    color: #6a1b09; /* Marrón oscuro, estilo Mostaza */
    margin-bottom: 30px;
    }

    .pregunta {
    margin-bottom: 25px;
    padding: 15px;
    background-color: #fff3cd; /* Fondo amarillo claro */
    border-left: 4px solid #d32f2f; /* Rojo oscuro */
    border-radius: 4px;
    }

    .pregunta strong {
    display: block;
    margin-bottom: 10px;
    font-size: 1.1rem;
    color: #d32f2f; /* Rojo Mostaza */
    }

    .pregunta label {
    display: block;
    margin-bottom: 8px;
    cursor: pointer;
    }

    .pregunta input[type="radio"] {
    margin-right: 8px;
    }

    .boton-enviar {
    display: block;
    width: 100%;
    padding: 15px;
    background-color: #f9a825; /* Amarillo Mostaza */
    color: #212121;
    font-size: 1.1rem;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .boton-enviar:hover {
    background-color: #f57f17; /* Mostaza más intensa */
    }

  </style>
</head>
<body>
  <div class="container">
    <h1>Resolver Examen</h1>
    <form method="post">
        <input type="hidden" name="cur_id" value="<?= $_POST['id'] ?>">
      <?php
      // Ejemplo estático: reemplazá esto por tu consulta a base de datos
      $cur_id = $_POST['id'];
      require_once "clases.php";
      $preguntas = Curso::obtenerPreguntas($cur_id);

      foreach ($preguntas as $index => $pregunta) {
          echo "<div class='pregunta'>";
          echo "<strong>" . ($index + 1) . ". " . htmlspecialchars($pregunta['enunciado']) . "</strong>";

          foreach ($pregunta['opciones'] as $letra => $opcion) {
              echo "<label>";
              echo "<input type='radio' name='respuestas[{$pregunta['id']}]' value='$letra' required> ";
              echo htmlspecialchars($opcion);
              echo "</label>";
          }

          echo "</div>";
      }
      ?>
      <button type="submit" class="boton-enviar">Enviar examen</button>
    </form>


    
  </div>
</body>
</html>
