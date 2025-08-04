<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje</title>
</head>
<body>
    <form action="enviar.php" method="post">
  <input type="text" name="nombre" placeholder="Tu nombre" required>
  <input type="email" name="email" placeholder="Tu correo" required>
  <textarea name="mensaje" placeholder="Tu mensaje" required></textarea>
  <button type="submit">Enviar</button>
</form>

</body>
</html>