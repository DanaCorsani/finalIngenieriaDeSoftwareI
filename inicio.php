<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="favicon.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            gap: 60px;
        }

        .imagen {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .imagen img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .botones {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .botones a button {
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            background-color: #ffcc00;
            color: #000;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .botones a button:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>
    <?php
    include_once "navbar.php";
    ?>
    
    <h1>Bienvenido a la Academia Mostaza</h1>
    <div class="container">
        <div class="imagen">
            <img src="mostaza.jpg" alt="Imagen de la Academia">
        </div>
        <div class="botones">
            <a href="cursos.php?listar"><button>Cursos</button></a>
            <a href="usuarios.php?listar"><button>Usuarios</button></a>
            <a href="mensaje.php"><button>Enviar un mensaje</button></a>
        </div>
    </div>
</body>
</html>
