<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostaza Academy</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" href="favicon.png" type="image/png">
</head>
<body>
    <header class="header">
        <h1>Academia Mostaza</h1>
    </header>
    <!-- <nav>      for later
        <ul>
            <li>Home</li>
            <li>Log in</li>
            <li>Sign in</li>
            <li>Menu</li>
            <li>Courses</li>
        </ul>
    </nav> -->
    <main class="main">
        <section>
            <div class="ourBurgers">
                <h2 id="mainTitle">Nuestras hamburguesas</h2>
                <!-- <img class="img" src="" alt="Imagen de una hamburgesa visualmente atractiva"> -->
            </div>
        </section>
        <section>
        </section>
    </main>
    <aside class="aside">
        <section>
            <div class="flex-container">
                <div class="logInBread" id="logInBreadTop">
                    <h2>Login</h2>
                </div>
                <div class="logInTomato">
                    <!-- <p>tomato placeholder</p> -->
                </div>
                <div class="logInCheese">
                    <form method="post" action="login.php">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="logInBurger">
                    <label for="clave">Contraseña:</label>
                    <input type="password" id="clave" name="clave" required>
                </div>
                <div class="logInLettuce">
                    <!-- <p>lettuce placeholder</p> -->
                </div>
                <div class="logInBread" id="logInBreadBottom">
                    <button type="submit">Ingresar</button>
            </form>
                </div>
            </div>
        </section>

    </aside>
    <footer class="footer">
        <h3 id="rights">@2025 ISFTyD24</h3>
        <div id="names">
            <h4>Dana Corsani, Alexis Gomez</h4>
            <h4>Julieta Camara, Ramiro Ramos, Leonardo Camacho </h4>
        </div>
    </footer>
    
    <?php
    if (isset($_SESSION['msj'])) {
        echo "<script>alert('Usuario o Contraseña Incorrectos');</script>";
        unset($_SESSION['msj']);
    }
    ?>
    <?php
    # termino sesion para que el usuario tenga que loguearse para volver a entrar
        session_unset();
        session_destroy();
    ?>
</body>
</html>