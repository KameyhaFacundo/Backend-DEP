          <article class="col-sm-4 col-md-4 col-lg-4 mb-2">

            <form id="filterArticuloForm" method="GET" action="">
              <section class="form-row d-flex row">
                <section class="col-8" >
                  <input
                    type="text"
                    id="articulo"
                    name="busqueda"
                    class="form-control"
                    placeholder="Buscar artículo..."
                    autocomplete="off"
                  />
                  <section id="articulos-results" class="list-group"></section>
                </section>
                <section class="col-4 d-flex align-items-center">
                  <button type="submit" id="btn-buscar" class="btn btn-sm btn-primary btn-filtrar">Filtrar</button>
                </section>
              </section>
            </form>

          </article>



          <!-- Filtro rubro -->
          <article class="col-sm-4 col-md-4 col-lg-4 mb-2">

            <form id="filterRubroForm" method="GET" action="">
              <section class="form-row d-flex row"> 
                  <!-- <label for="rubroFiltro" class="col-sm-2 col-form-label">Rubro</label> -->
                  <section class="col-8 align-items-center my-auto">
                      <select name = "rubroFiltro" id="rubroFiltro" class="form-control " require>
                          <option value="">Filtrar por rubro...</option>
                          <?php
                          foreach ($rubros as $rubro)
                          {
                              echo '<option value="'.$rubro["Rubro"].'">'.$rubro["Rubro"].'</option>';
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


