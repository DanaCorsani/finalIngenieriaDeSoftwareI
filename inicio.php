<?php
# (v) continuo sesion
session_start();
?>
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

        footer{
    grid-area: footer;
    display: flex;
    justify-content: space-between;
    color: #450101;
    font-weight: 900;
    position: fixed;    /*pongo una posicion fija para el texto del footer */
    bottom: 0;          /*setteo que el texto quede bien al final de la pagina, pegado. */
    left: 0;
    right: 0;
    background-color: orangered;
    padding: 0 1rem;
}
    </style>
</head>
<body>
    <?php
    include_once "navbar.php";
    session_start();
    ?>
    
    <h1>Bienvenido a la Academia Mostaza</h1>
    <div class="container">
        <div class="imagen">
            <img src="mostaza.jpg" alt="Imagen de la Academia">
        </div>
        <div class="botones">
            <a href="cursos.php?listar"><button>Cursos</button></a>
            <?php
                if ($_SESSION["rol"] == 1) {
                    ?>
                    <a href="usuarios.php?listar"><button>Usuarios</button></a>
                    <?php
                }
            ?>

            <a href="mensaje.php"><button>Enviar un mensaje</button></a>
        </div>
    </div>

    <footer class="footer">
        <h3 id="rights">@2025 ISFTyD24</h3>
        <div id="names">
            <h4>Dana Corsani, Alexis Gomez, Julieta Camara, Ramiro Ramos, Leonardo Camacho </h4>
        </div>
    </footer>
</body>
</html>
