<link rel="icon" href="favicon.png" type="image/png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php
if(isset($_POST["cerrar"])){
    session_unset();
    session_destroy();
    header("Location: index.php");
}
?>
<style>
    body{
        box-sizing: border-box;
        margin: 0 0;
    }
    .navbar{
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        background-color: darkred;
        padding: .5rem 3vw;
        /* margin-bottom: 3vh; */
        /* ^ espacio entre la bara y resto de la pagina */
    }
    .navbar-botones{
        margin-left: 5vw;
    }
    .navbar-perfil{
        display: flex;
        gap: 0.3vw;
    }
    .navbar-perfil form{
        margin: 0;
    }
    .navbar button, .navbar input[type="submit"]{
        padding: .5rem 1rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        }
</style>
<nav class="navbar">
    <a href="inicio.php" title="Capacitaciones Mostaza"><button><i class="fas fa-house"></i> Home</button></a>
    <div class="navbar-botones">
        <a href="cursos.php?listar" title="Cursos"><button><i class="fas fa-graduation-cap"></i> Cursos</button></a>
        <?php
            if($_SESSION['rol_id']==1){
                ?>
            <a href="usuarios.php?listar"><button><i class="fas fa-users"></i>
 Usuarios</button></a>
            <?php
            }else{}
            ?>
        <!-- <a href="mensaje.php" title="Enviar consulta"><button>Consulta</button></a> -->
    </div>
    <div class="navbar-perfil">
        <a href="perfil.php" title="Mi Perfil"><button><i class="fas fa-user"></i> Mi Perfil</button></a><form action="" method="post">
            <button type="submit" name="cerrar">
  <i class="fas fa-right-from-bracket"></i> Cerrar Sesión
</button>

        </form>
    </div>
</nav>