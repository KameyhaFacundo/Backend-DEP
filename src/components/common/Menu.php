<?php
  // require ("../../config.php");
?>

<header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-2">
  <section class="container-fluid ">
    <section class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav ms-auto p-2">
        <li class="nav-item dropdown">
          <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Secciones
          </button>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="<?php echo $movURL?>">Movimientos</a></li>
          <li><a class="dropdown-item" href="<?php echo $oficinaURL?>">Oficinas</a></li>
          <li><a class="dropdown-item" href="<?php echo $stockURL?>">Stock</a></li>
        </ul>
        </li>
      </ul>
    </section>
  </section>
</nav>

  
</header>

