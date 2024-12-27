<?php
    require_once '../../../../config.php';
    $ruta1 = BASE_URL.'styles';
    $ruta2= 'Stock';
    $rutaFooter="../../common/";
    require("../../common/header.php");
    include 'funcionesMov.php';
    require (MENU_URL);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
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

    $usuarioPermitido = isset($_SESSION['user']) && ($_SESSION['user']['rol'] == 'administrador' || $_SESSION['user']['rol'] == 'usuario');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <link rel="stylesheet" href="Movimiento.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../../../styles/css/bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
    <div class="movimientos-container">
        <div class="movimientos-header">
            <h2>Movimientos Registrados</h2>
        <?php if ($usuarioPermitido): ?>
            <button type="button" class="general-button" data-toggle="modal" data-target="#movementModal" data-action="add">
                Agregar Movimiento
            </button>
        <?php endif; ?>
        </div>

        <div class="filter-container mb-3">
            <div class="row">
                <!-- Formulario de filtro por fecha -->
                <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                    <form method="GET" action="" id="filterDateForm">
                        <div class="form-row">
                            <div class="col-8">
                                <input type="date" id="fechaMov" name="fechaMov" class="form-control" 
                                    value="<?= isset($_GET['fechaMov']) ? $_GET['fechaMov'] : '' ?>">
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Formulario de búsqueda de artículo -->
                <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                    <form id="filterArticuloForm" method="GET" action="">
                        <div class="form-row position-relative">
                            <div class="col-8">
                                <input
                                    type="text"
                                    id="articulo"
                                    name="articulo"
                                    class="form-control"
                                    placeholder="Buscar artículo..."
                                    autocomplete="off"
                                    value="<?= isset($_GET['articulo']) ? $_GET['articulo'] : '' ?>"
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
                    <form method="GET" action="" id="filterAccionForm">
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
            <div class="container">
                <table class="table table-striped table-bordered movimientos-table">
                    <thead>
                            <tr>
                                <th>Código</th>
                                <th class="px-5">Fecha</th> 
                                <th class="px-5">Artículo</th> 
                                <th class="px-4">Centro</th>
                                <th class="px-4">Acción</th>
                                <th class="px-3">Cantidad</th>
                                <th class="px-4">Unidad</th>
                                <?php if ($usuarioPermitido): ?>
                                    <th class="px-4">DescripUnidad</th>
                                    <th >Motivo</th>
                                    <th class="px-2">Funciones</th>
                                <?php else: ?>
                                    <th class="px-5">DescripUnidad</th>
                                    <th class="px-5">Motivo</th>
                                <?php endif; ?>                                   
                            </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($movimientos) && count($movimientos) > 0): ?>
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
                                    <?php if ($usuarioPermitido): ?>
                                        <td>
                                            <a href="#" class="btn trasp btn-sm" data-toggle="modal" data-target="#movementModal"
                                            data-action="edit"
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
                                            <a href="#" class="btn btn-sm eliminar-style-button" data-toggle="modal" data-target="#deleteModal" 
                                            data-id="<?= $movimiento['IdMovimiento'] ?>">
                                                <i class="fas trasp fa-trash"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>                                    
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="py-5 text-center">No hay movimientos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginado -->
        <?php if (is_array($movimientos) && count($movimientos) > 0): ?>
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
        <?php endif; ?>

         <!-- Modal para agregar o editar movimientos -->
        <div id="movementModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="movementModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="movementModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="movementForm" method="POST">
                            <input type="hidden" id="idMovimiento" name="idMovimiento">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fechaMov">Fecha:</label>
                                    <input type="date" id="fechaMov" name="FechaMov" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="accion">Acción:</label>
                                    <select id="accion" name="Accion" class="form-control" required>
                                        <option value="">Seleccione una acción</option>
                                        <?php foreach ($acciones as $accion): ?>
                                            <option value="<?= $accion['IdAccion'] ?>"><?= $accion['Accion'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="Articulo">Artículo:</label>
                                    <select id="Articulo" name="Articulo" class="form-control" required>
                                        <option value="">Seleccione un artículo</option>
                                        <?php foreach ($articulos as $articulo): ?>
                                            <option value="<?= $articulo['IdConcepto'] ?>"><?= $articulo['Articulo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
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
                                <div class="form-group col-md-6">
                                    <label for="Cantidad">Cantidad:</label>
                                    <input type="number" id="Cantidad" name="Cantidad" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Motivo">Motivo:</label>
                                    <textarea id="Motivo" name="Motivo" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="Unidad">Unidad:</label>
                                    <input type="text" id="Unidad" name="Unidad" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="DescripUnidad">Descripción:</label>
                                    <input type="text" id="DescripUnidad" name="DescripUnidad" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

           <!-- Modal para confirmar eliminación -->
        <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="lead">¿Estás seguro de que deseas eliminar este movimiento?</p>
                        <p class="text-muted">Esta acción no se puede deshacer.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <form id="deleteForm" method="POST" action="../../../Backend/eliminarMovimiento.php">
                            <input type="hidden" name="id" id="deleteId">
                            <button type="button" class="btn btn-outline-secondary btn-cancelar" data-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-danger">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Script para manejar el modal -->
    <script>
        // Configura el modal de eliminación con los datos del movimiento
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id'); // Obtiene el ID del movimiento

            var modal = $(this);
            modal.find('#deleteId').val(id); // Asigna el ID al campo oculto en el formulario
        });
    </script>

    <!-- Modificar o agregar movimientos -->
    <script>
        $('#movementModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var action = button.data('action'); // "edit" o "add"

            var modal = $(this);
            var form = $('#movementForm');

            if (action === 'edit') {
                modal.find('.modal-title').text('Modificar Movimiento');
                form.attr('action', '../../../Backend/actualizarMovimiento.php');
                modal.find('button[type="submit"]').text('Guardar cambios');

                // Llena los campos con los datos del movimiento
                $('#idMovimiento').val(button.data('id'));
                $('#fechaMov').val(button.data('fecha'));
                $('#accion').val(button.data('accion'));
                $('#Articulo').val(button.data('articulo'));
                $('#Centro').val(button.data('centro'));
                $('#Cantidad').val(button.data('cantidad'));
                $('#Unidad').val(button.data('unidad'));
                $('#DescripUnidad').val(button.data('descripunidad'));
                $('#Motivo').val(button.data('motivo'));
            } else if (action === 'add') {
                modal.find('.modal-title').text('Agregar Movimiento');
                form.attr('action', '../../../Backend/guardarMovimientos.php');
                modal.find('button[type="submit"]').text('Agregar');

                // Limpia los campos
                $('#idMovimiento').val('');
                $('#fechaMov').val('');
                $('#accion').val('');
                $('#Articulo').val('');
                $('#Centro').val('');
                $('#Cantidad').val('');
                $('#Unidad').val('');
                $('#DescripUnidad').val('');
                $('#Motivo').val('');
            }
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

<?php
    require_once  $rutaFooter."footer.php"
?>
