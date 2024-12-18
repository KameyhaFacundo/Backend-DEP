<?php
    $ruta1 = 'src/styles';
    $ruta2= 'src/index';
    require("src/components/common/header.php");

?>
<main class="d-flex justify-content-center align-items-center">
        <section class="text-center">
            <header>
                <h1 class="mb-4">Iniciar Sesión</h1>
            </header>

            <form action="php/logueo.php" method="POST" class="p-4 rounded">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" id="username" name="username" class="form-control mb-3" required>

                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control mb-4" required>

                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </section>
    </main>
<?php
    // require("php/footer.php");
?>