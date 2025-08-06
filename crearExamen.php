<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['cur_id']))) {
      $cur_id = $_POST['cur_id'];
      require_once "clases.php";
      if (Curso::agregarExamen($cur_id, $_POST)) {
          echo "<script>
                alert('Examen guardado correctamente.');
                window.location.href = 'detallesCurso.php?curso=" . $cur_id . "';
              </script>";

      } else {
        echo "<script>
                alert('No se pudo guardar el examen.');
              </script>";
      }
    }
  ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Examen</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 2rem; }
    h2 { margin-top: 2rem; }
    fieldset { border: 1px solid #ccc; padding: 1rem; margin-bottom: 1.5rem; }
    legend { font-weight: bold; }
    .opciones { margin-left: 1rem; }
    label { display: block; margin: 0.3rem 0; }
    input[type=text], select, textarea { width: 100%; padding: 0.5rem; margin-bottom: 0.5rem; }
    button { padding: 0.7rem 1.5rem; font-size: 1rem; }
  </style>
</head>
<body>
<h1>Crear examen</h1>
<form method="POST">
  <input type="hidden" name="cur_id" value="<?= ($_POST['id']) ?>">
  <?php for ($i = 1; $i <= 3; $i++): ?>
    <fieldset>
      <legend>Pregunta <?= $i ?></legend>
      <label>Texto de la pregunta:
        <input type="text" name="pregunta_<?= $i ?>" required>
      </label>
      <div class="opciones">
        <?php for ($j = 1; $j <= 4; $j++): ?>
          <label>
            Opción <?= $j ?>:
            <input type="text" name="opcion_<?= $i ?>_<?= $j ?>" required>
            <input type="radio" name="correcta_<?= $i ?>" value="<?= $j ?>" required>
            Es correcta
          </label>
        <?php endfor; ?>
      </div>
    </fieldset>
  <?php endfor; ?>
  <button type="submit">Guardar examen</button>


  
</form>
</body>
</html>
