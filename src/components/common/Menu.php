<?php

// Lógica para cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset(); // Destruye las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: ../../../../index.php"); // Redirige al login
    exit();
}
?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light mt-2">
    <section class="container-fluid">
      <section class="collapse navbar-collapse" id="navbarNavDarkDropdown">
        <ul class="navbar-nav ms-auto p-2">
          <li class="nav-item dropdown">
            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Secciones
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo $movURL; ?>">Movimientos</a></li>
              <li><a class="dropdown-item" href="<?php echo $oficinaURL; ?>">Oficinas</a></li>
              <li><a class="dropdown-item" href="<?php echo $stockURL; ?>">Stock</a></li>
            </ul>
          </li>
          <!-- Botón de cerrar sesión -->
          <li class="nav-item ms-3">
            <form method="POST" class="d-inline">
              <input type="hidden" name="logout" value="1">
              <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
          </li>
        </ul>
      </section>
    </section>
  </nav>
