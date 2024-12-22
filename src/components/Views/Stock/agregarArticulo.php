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
            <form class="modal-form" id="stockForm" method="POST">
                <input type="hidden" id="idArticulo" name="idArt">
                
                <section class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </section>
            </form>
        </section>
    </article>
    </section>
</section>
