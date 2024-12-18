<?php

include 'funciones.php';
// Obtener los movimientos, acciones, artículos y centros
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
    <link rel="stylesheet" href="Movimiento.css"> <!-- Enlaza la hoja de estilos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="movimientos-container">
        <div class="movimientos-header">
            <h2>Movimientos Registrados</h2>
            <!-- Botón para abrir el modal -->
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
                <form method="POST" action="movimiento.php">
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
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Scripts de Bootstrap y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
