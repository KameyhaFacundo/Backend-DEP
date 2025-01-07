<?php

// Lógica para cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset(); // Destruye las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: ../../../../index.php"); // Redirige al login
    exit();
    
}

$usuarioPermitido = ($_SESSION['user']['rol'] == 'administrador');
$baseURL = "http://localhost/Backend-DEP/";

?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light mt-2">
    <section class="container-fluid">
    <!-- Aqui van la foto y el nombre de usuario , -->
      <a href="" class="nav-link">
        <section class="d-flex align-items-center ">
          <h3 class="mb-0" ><?php echo $_SESSION['user']['username']?></h3>
            <figure class="mb-0">
              <img src="<?php echo BASE_URL?>assets/usuariosImg/usuario_default.png" alt="Imagen de usuario" class="rounded-circle img-fluid" width="30">
            </figure>
          </section>
      </a>

       <!-- Botón para colapsar menú en pantallas pequeñas -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <section class="collapse navbar-collapse" id="navbarNavDarkDropdown">
        <ul class="navbar-nav ms-auto p-2 align-items-end">

          <li class="nav-item dropdown py-1">
            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Secciones
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo MOVIMIENTOS_URL; ?>">Movimientos</a></li>
              <li><a class="dropdown-item" href="<?php echo OFICINAS_URL; ?>">Oficinas</a></li>
              <li><a class="dropdown-item" href="<?php echo STOCK_URL; ?>">Stock</a></li>
              <?php
              if ($usuarioPermitido) {//debo controlas que solo admin tenga acceso a la gestion de usuarios
                echo '<li><a class="dropdown-item" href="'.USUARIOS_URL.'">Usuarios</a></li>';
              }
              ?>
            </ul>
          </li>
          <!-- Botón de cerrar sesión -->
          <li class="nav-item ms-3 py-1">
            <form method="POST" class="d-inline">
              <input type="hidden" name="logout" value="1">
              <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
          </li>
        </ul>
      </section>
    </section>
  </nav>
