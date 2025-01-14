<section class="row">
    <article class="col-sm-4 col-md-4 col-lg-4 mb-2">

        <form id="filterUsuarioForm" method="GET" action="">
        <section class="form-row d-flex row">
            <section class="col-8" >
            <input
                type="text"
                id="buscar"
                name="busqueda"
                class="form-control"
                placeholder="Buscar usuario..."
                autocomplete="off"
            />
            <section id="usuarios-results" class="list-group"></section>
            </section>
            <section class="col-4 d-flex align-items-center">
            <button type="submit" id="btn-buscar" class="btn btn-sm btn-primary btn-filtrar">Buscar</button>
            </section>
        </section>
        </form>
    </article>

    <!-- FILTRO POR ROL DE USUARIO-->
    <article class="col-sm-4 col-md-4 col-lg-4 mb-2">
        <form id="filterRolForm" method="GET" action="">
        <section class="form-row d-flex row"> 
            <!-- <label for="rolFiltro" class="col-sm-2 col-form-label">Rubro</label> -->
            <section class="col-8 align-items-center my-auto">
                <select name = "rolFiltro" id="rolFiltro" class="form-control " require>
                    <option value="">Filtrar por rol...</option>
                    <?php
                     $roles = $rolesBD;
                     foreach ($roles as $rol)
                     {
                         echo '<option value="'.$rol['Rol'].'">'.$rol['Rol'].'</option>';
                     }                              
                    ?> 
                </select>
            </section>
            <section class="col-4 d-flex align-items-center vertical-center">
                <button type="submit" id="btn-buscar" class="btn btn-sm btn-primary btn-filtrar">Filtrar</button>
            </section>
        </section>
        </form>

    </article>

</section>