<?php
require ("../../../Backend/insertarArticulo.php");
?>

<!-- Boton para activar el modal para agregar articulo -->

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
Agregar Artículo
</button>

<!-- Se despliega el formulario para agregar el Artículo -->
<section class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <section class="modal-dialog">
    <article class="modal-content">
        <header class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar artículo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </header>
        <section class="modal-body">
            <form class="row border rounded " id="stockForm" method="POST">
                <!-- <fieldset> -->
                    <section class="row mb-3">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <section class="col-sm-10"> 
                            <input type="text" id="nom" name="nombre" class="form-control mb-3" required>
                        </section>
                    </section>

                    <section class="row mb-3">
                        <label for="rubro" class="col-sm-2 col-form-label">Rubro</label>
                        <section class="col-sm-10">
                            <select name = "rubro" id="rub" class="form-control mb-3" require>
                                <?php
                                foreach ($rubros as $rubro)
                                {
                                    echo '<option value="'.$rubro["Rubro"].'">'.$rubro["Rubro"].'</option>';
                                }                            
                                ?> 
                            </select>
                        </section>
                    </section>

                    <section class="row mb-3">
                        <label for="cantidad" class="col-sm-2 col-form-label">Cantidad </label> 
                        <section class="col-sm-10">
                            <input type="number" name="cantidad" class="form-control mb-3" id="cant" min="1" value ="1">
                        </section>
                    </section>

                    <section>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </section>
            </form>
        </section>
    </article>
    </section>
</section>
