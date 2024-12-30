<?php
?>

<!-- Boton para activar el modal para modificar usuario -->

<!-- Se despliega el formulario para modificar el usuario -->
<section class="modal fade" id="modalModificar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <section class="modal-dialog">
    <article class="modal-content">
        <header class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </header>
        <section class="modal-body">
            <form action="<?php echo BASE_URL."Backend/actualizarUsuario.php"?>" class="row border rounded " id="stockForm" method="POST">

                    <input type="hidden" id="idUsuario" name="idUsuario">
                    
                    <section class="row mb-3">
                        <label for="usuario" class="col-sm-2 col-form-label">Nombre de usuario</label>
                        <section class="col-sm-10"> 
                            <input type="text" id="usuario" name="usuario" class="form-control mb-3" >
                        </section>
                    </section>

                    <section class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                        <section class="col-sm-10"> 
                            <input type="password" id="password" name="password" class="form-control mb-3" min="8" max="25">
                        </section>
                    </section>

                    <section class="row mb-3">
                        <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                        <section class="col-sm-10">
                            <select name = "rol" id="rol" class="form-control mb-3" >
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
                        <input type="submit" id="btnAgregar" class="btn btn-primary" value="Guardar cambios">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </section>
            </form>
        </section>
    </article>
    </section>
</section>

