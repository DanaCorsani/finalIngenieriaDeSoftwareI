<style>
    body{
        box-sizing: border-box;
        margin: 0 0;
    }
    .navbar{
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        background-color: darkorange;
        padding: .5rem 3vw;
        margin-bottom: 3vh;
        /* ^ espacio entre la bara y resto de la pagina */
    }
    .navbar-botones{
        margin-left: 5vw;
    }
    .navbar-perfil{
        display: flex;
        gap: 0.3vw;
    }
    .navbar button, .navbar input[type="submit"]{
        border-radius: .5rem;
        padding: .5rem 1rem;
    }
</style>
<nav class="navbar">
    <a href="inicio.php" title="Capacitaciones Mostaza"><button>Home</button></a>
    <div class="navbar-botones">
        <a href="cursos.php" title="Cursos"><button>Cursos</button></a>
        <a href="usuarios.php" title="Usuarios"><button>Usuarios</button></a>
        <a href="mensaje.php" title="Enviar consulta"><button>Consulta</button></a>
    </div>
    <div class="navbar-perfil">
        <a href="perfil.php" title="Mi Perfil"><button>Mi Perfil</button></a>
        <form action="" method="post">
            <input type="submit" name="cerrar" value="Cerrar Sesión">
        </form>
    </div>
</nav>
<?php
if(isset($_POST["cerrar"])){
    session_unset();
    session_destroy();
    header("Location: index.php");
}
?>