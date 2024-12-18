<?php
include 'funciones.php'; // Asumiendo que 'funciones.php' contiene la lógica para obtener los datos

$movimientos = getMovimientos();
$acciones = getAcciones();
$articulos = getArticulos();
$centros = getCentros();
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMovementModal">
                Agregar Movimiento
            </button>
        </div>

        <?php if (is_array($movimientos) && count($movimientos) > 0): ?>
            <div class="table-responsive">
                <table class="movimientos-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Artículo</th>
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
                                <td><?= $movimiento['FechaMov'] ?></td>
                                <td><?= $movimiento['Articulo'] ?></td>
                                <td><?= $movimiento['Centro'] ?></td>
                                <td><?= $movimiento['Accion'] ?></td>
                                <td><?= $movimiento['Cantidad'] ?></td>
                                <td><?= $movimiento['Unidad'] ?></td>
                                <td><?= $movimiento['DescripUnidad'] ?></td>
                                <td><?= $movimiento['Motivo'] ?></td>
                                <td>
                                    <!-- Botón de editar que abre el modal y pasa los datos -->
                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMovementModal" 
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
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este movimiento?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-records">No hay movimientos registrados.</p>
        <?php endif; ?>
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
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
</body>
</html>
