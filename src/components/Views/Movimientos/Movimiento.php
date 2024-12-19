<?php
include 'funcionesMov.php';

$movimientos = getMovimientos();
$acciones = getAcciones();
$articulos = getArticulos();
$centros = getCentros();

$fechaMov = isset($_GET['fechaMov']) ? $_GET['fechaMov'] : null;
if ($fechaMov) {
    $movimientos = filtrarPorFecha($fechaMov);
}

$accion = isset($_GET['accion']) ? $_GET['accion'] : null;
if ($accion) {
    $movimientos = filtrarPorAccion($accion);
}

$articulo = isset($_GET['articulo']) ? $_GET['articulo'] : null;
if ($articulo) {
    $movimientos = filtrarPorArticulo($articulo);
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;

// Obtener los movimientos filtrados y paginados
$pagination = getPaginatedMovimientos(
    $page, 
    $items_per_page, 
    $movimientos, 
    $fechaMov, 
    $accion,
    $articulo 
);

$movimientos = $pagination['movimientos'];
$total_pages = $pagination['total_pages'];
$current_page = $pagination['current_page'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <link rel="stylesheet" href="Movimiento.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="movimientos-container">
        <div class="movimientos-header">
            <h2>Movimientos Registrados</h2>
            <button type="button" class="general-button" data-toggle="modal" data-target="#addMovementModal">
                Agregar Movimiento
            </button>
        </div>

        <?php if (is_array($movimientos) && count($movimientos) > 0): ?>

            <div class="filter-container mb-3">
                <div class="row">
                    <!-- Formulario de filtro por fecha -->
                    <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                        <form method="GET" action="">
                            <div class="form-row">
                                <div class="col-8">
                                    <input type="date" id="fechaMov" name="fechaMov" class="form-control" value="<?= isset($_GET['fechaMov']) ? $_GET['fechaMov'] : '' ?>">
                                </div>
                                <div class="col-4 d-flex align-items-center">
                                    <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Formulario de búsqueda de artículo -->
                    <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                        <form id="filterForm" method="GET" action="">
                            <div class="form-row position-relative">
                            <div class="col-8">
                                <input
                                type="text"
                                id="articulo"
                                name="articulo"
                                class="form-control"
                                placeholder="Buscar artículo..."
                                autocomplete="off"
                                />
                                <div id="articulos-results" class="list-group"></div>
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                            </div>
                            </div>
                        </form>
                    </div>
                    <!-- Formulario de filtro por acción -->
                    <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                        <form method="GET" action="">
                            <div class="form-row">
                                <div class="col-8">
                                    <select name="accion" class="form-control">
                                        <option value="">Seleccionar acción</option>
                                        <option value="Entrada" <?= isset($_GET['accion']) && $_GET['accion'] == 'Entrada' ? 'selected' : '' ?>>Entrada</option>
                                        <option value="Salida" <?= isset($_GET['accion']) && $_GET['accion'] == 'Salida' ? 'selected' : '' ?>>Salida</option> 
                                    </select>
                                </div>
                                <div class="col-4 d-flex align-items-center">
                                    <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="movimientos-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th class="px-4">Fecha</th>
                            <th class="px-4">Artículo</th>
                            <th>Centro</th>
                            <th>Acción</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Descripción Unidad</th>
                            <th>Motivo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $movimiento): ?>
                            <tr>
                                <td><?= $movimiento['IdConcepto'] ?></td>
                                <td class="px-0"><?= $movimiento['FechaMov'] ?></td>
                                <td><?= $movimiento['Articulo'] ?></td>
                                <td><?= $movimiento['Centro'] ?></td>
                                <td><?= $movimiento['Accion'] ?></td>
                                <td><?= $movimiento['Cantidad'] ?></td>
                                <td><?= $movimiento['Unidad'] ?></td>
                                <td><?= $movimiento['DescripUnidad'] ?></td>
                                <td><?= $movimiento['Motivo'] ?></td>
                                <td>
                                    <!-- Botón de editar que abre el modal y pasa los datos -->
                                    <a href="#" class="btn trasp btn-sm" data-toggle="modal" data-target="#editMovementModal" 
                                    data-id="<?= $movimiento['IdMovimiento'] ?>"
                                    data-fecha="<?= $movimiento['FechaMov'] ?>"
                                    data-accion="<?= $movimiento['Accion'] ?>"
                                    data-articulo="<?= $movimiento['Articulo'] ?>"
                                    data-centro="<?= $movimiento['Centro'] ?>"
                                    data-cantidad="<?= $movimiento['Cantidad'] ?>"
                                    data-unidad="<?= $movimiento['Unidad'] ?>"
                                    data-descripunidad="<?= $movimiento['DescripUnidad'] ?>"
                                    data-motivo="<?= $movimiento['Motivo'] ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <!-- Formulario de eliminación -->
                                    <form method="POST" action="../../../Backend/eliminarMovimiento.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $movimiento['IdMovimiento'] ?>">
                                        <button type="submit" class=" style-button btn btn-sm eliminar-style-button" onclick="return confirm('¿Estás seguro de que deseas eliminar este movimiento?');">
                                            <i class="fas trasp fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&fechaMov=<?= urlencode($_GET['fechaMov'] ?? '') ?>&accion=<?= urlencode($_GET['accion'] ?? '') ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&fechaMov=<?= urlencode($_GET['fechaMov'] ?? '') ?>&accion=<?= urlencode($_GET['accion'] ?? '') ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&fechaMov=<?= urlencode($_GET['fechaMov'] ?? '') ?>&accion=<?= urlencode($_GET['accion'] ?? '') ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php else: ?>
            <p class="no-records">No hay movimientos registrados.</p>
        <?php endif; ?>
    </div>
    

    <!-- Modal de agregar movimiento -->
    <div id="addMovementModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addMovementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg para hacerlo más pequeño -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMovementModalLabel">Formulario de Movimiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../../Backend/guardarMovimientos.php">
                        <div class="row">
                            <!-- Fecha -->
                            <div class="form-group col-md-6">
                                <label for="FechaMov">Fecha:</label>
                                <input type="date" id="FechaMov" name="FechaMov" class="form-control" required>
                            </div>
                            <!-- Acción -->
                            <div class="form-group col-md-6">
                                <label for="Accion">Acción:</label>
                                <select id="Accion" name="Accion" class="form-control" required>
                                    <option value="">Seleccione una acción</option>
                                    <?php foreach ($acciones as $accion): ?>
                                        <option value="<?= $accion['IdAccion'] ?>"><?= $accion['Accion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Artículo -->
                            <div class="form-group col-md-6">
                                <label for="Articulo">Artículo:</label>
                                <select id="Articulo" name="Articulo" class="form-control" required>
                                    <option value="">Seleccione un artículo</option>
                                    <?php foreach ($articulos as $articulo): ?>
                                        <option value="<?= $articulo['IdConcepto'] ?>"><?= $articulo['Articulo'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Centro -->
                            <div class="form-group col-md-6">
                                <label for="Centro">Centro:</label>
                                <select id="Centro" name="Centro" class="form-control" required>
                                    <option value="">Seleccione un centro</option>
                                    <?php foreach ($centros as $centro): ?>
                                        <option value="<?= $centro['IdCentro'] ?>"><?= $centro['Centro'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Cantidad -->
                            <div class="form-group col-md-6">
                                <label for="Cantidad">Cantidad:</label>
                                <input type="number" id="Cantidad" name="Cantidad" class="form-control" required>
                            </div>
                            <!-- Motivo -->
                            <div class="form-group col-md-6">
                                <label for="Motivo">Motivo:</label>
                                <textarea id="Motivo" name="Motivo" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Unidad -->
                            <div class="form-group col-md-6">
                                <label for="Unidad">Unidad:</label>
                                <input type="text" id="Unidad" name="Unidad" class="form-control" required>
                            </div>
                            <!-- Descripción Unidad -->
                            <div class="form-group col-md-6">
                                <label for="DescripUnidad">Descripción:</label>
                                <input type="text" id="DescripUnidad" name="DescripUnidad" class="form-control" required>
                            </div>
                        </div>
                        <!-- Botones -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit " class="style-button btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de editar movimiento -->
    <div id="editMovementModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editMovementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMovementModalLabel">Modificar Movimiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editMovementForm" method="POST" action="../../../Backend/actualizarMovimiento.php">
                        <input type="hidden" id="editIdMovimiento" name="idMovimiento">

                        <!-- Campos para editar -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="editFechaMov">Fecha:</label>
                                <input type="date" id="editFechaMov" name="FechaMov" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editAccion">Acción:</label>
                                <select id="editAccion" name="Accion" class="form-control" required>
                                    <option value="">Seleccione una acción</option>
                                    <?php foreach ($acciones as $accion): ?>
                                        <option value="<?= $accion['IdAccion'] ?>"><?= $accion['Accion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Resto de campos -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="editArticulo">Artículo:</label>
                                <select id="editArticulo" name="Articulo" class="form-control" required>
                                    <option value="">Seleccione un artículo</option>
                                    <?php foreach ($articulos as $articulo): ?>
                                        <option value="<?= $articulo['IdConcepto'] ?>"><?= $articulo['Articulo'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editCentro">Centro:</label>
                                <select id="editCentro" name="Centro" class="form-control" required>
                                    <option value="">Seleccione un centro</option>
                                    <?php foreach ($centros as $centro): ?>
                                        <option value="<?= $centro['IdCentro'] ?>"><?= $centro['Centro'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="editCantidad">Cantidad:</label>
                                <input type="number" id="editCantidad" name="Cantidad" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editMotivo">Motivo:</label>
                                <textarea id="editMotivo" name="Motivo" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="editUnidad">Unidad:</label>
                                <input type="text" id="editUnidad" name="Unidad" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editDescripUnidad">Descripción:</label>
                                <input type="text" id="editDescripUnidad" name="DescripUnidad" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class=" style-button btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Editar Movimiento -->
    <script>
        $('#editMovementModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var idMovimiento = button.data('id');
            var fecha = button.data('fecha');
            var accion = button.data('accion');
            var articulo = button.data('articulo');
            var centro = button.data('centro');
            var cantidad = button.data('cantidad');
            var unidad = button.data('unidad');
            var descripunidad = button.data('descripunidad');
            var motivo = button.data('motivo');

            // Asigna los valores al formulario
            $('#editIdMovimiento').val(idMovimiento);
            $('#editFechaMov').val(fecha);
            $('#editAccion').val(accion);
            $('#editArticulo').val(articulo);
            $('#editCentro').val(centro);
            $('#editCantidad').val(cantidad);
            $('#editUnidad').val(unidad);
            $('#editDescripUnidad').val(descripunidad);
            $('#editMotivo').val(motivo);
        });
    </script>

    <!-- Autocompletar articulos -->
     <script>
    document.getElementById("articulo").addEventListener("input", function () {
        const articulo = this.value;

        // Si no hay texto, limpiar resultados y no realizar petición.
        if (articulo.trim() === "") {
            document.getElementById("articulos-results").innerHTML = "";
            return;
        }

        // Realizar petición a `buscarArticulos.php` con el texto parcial.
        fetch("../../../Backend/buscarArticulos.php?query=" + encodeURIComponent(articulo))
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error en la respuesta del servidor");
                }
                return response.json();
            })
            .then(data => {
                const resultsContainer = document.getElementById("articulos-results");
                resultsContainer.innerHTML = ""; // Limpiar resultados previos.

                // Generar la lista de resultados.
                data.forEach(item => {
                    const listItem = document.createElement("a");
                    listItem.href = "#"; // Puedes ajustar esto para que seleccione el artículo.
                    listItem.className = "list-group-item list-group-item-action";
                    listItem.textContent = item.Articulo;

                    // Agregar evento de clic para seleccionar el artículo.
                    listItem.addEventListener("click", function (e) {
                        e.preventDefault();
                        document.getElementById("articulo").value = item.Articulo;
                        resultsContainer.innerHTML = ""; // Limpiar resultados.
                    });

                    resultsContainer.appendChild(listItem);
                });
            })
            .catch(error => console.error("Error en la solicitud:", error));
    });
    </script>

</body>
</html>
