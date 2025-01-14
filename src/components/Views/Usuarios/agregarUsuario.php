<?php
?>

<!-- Boton para activar el modal para agregar usuario -->

<!-- Se despliega el formulario para agregar el Usuario -->
<section class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <section class="modal-dialog">
    <article class="modal-content">
        <header class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </header>
        <section class="modal-body">
            <form action="<?php echo BASE_URL."Backend/insertarUsuario.php"?>" class="row border rounded " id="agregarUsuForm" method="POST">
                <!-- <fieldset> -->
                    <section class="row mb-3">
                        <label for="usu" class="col-sm-2 col-form-label">Nombre de usuario</label>
                        <section class="col-sm-10"> 
                            <input type="text" id="usu" name="usu" class="form-control mb-3" required>
                        </section>
                    </section>

                    <section class="row mb-3">
                        <label for="contra" class="col-sm-3 col-form-label">Contraseña</label>
                        <section class="col-sm-9"> 
                            <input type="password" id="contra" name="contra" class="form-control mb-3" min="8" max="25" autocomplete="off" required>
                        </section>
                    </section>

                    <section class="row mb-3">
                        <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                        <section class="col-sm-10">
                            <select name = "rol" id="rolUsu" class="form-control mb-3" require>
                                <?php
                                $roles = $rolesBD;
                                foreach ($roles as $rol)
                                {
                                    echo '<option value="'.$rol['Rol'].'">'.$rol['Rol'].'</option>';
                                }                            
                                ?> 
                            </select>
                        </section>
                    </section>

                    <section>
                        <input type="submit" id="btnAgregar" class="btn btn-primary" value="Agregar">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </section>
            </form>
        </section>
    </article>
    </section>
</section>

