<?php
    require_once dirname(__DIR__, 2).'/helpers/centros.php';

    function MostrarModalMovimientosCentro($idCentro)
    {
        try {
            $movimientos = obtenerMovimientosPorCentro($idCentro);
        }catch(Exception $e)
        {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            return;
        }
        ?>
        <div class="modal fade" id="modalMovimientosCentro<?php echo $idCentro;?>" tabindex="-1" aria-labelledby="modalMovimientoCentroLabel<?php echo $idCentro;?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMovimientoCentroLabel<?php echo $idCentro;?>">Movimientos del Centro <?php echo $idCentro;?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                            if(empty($movimientos))
                            {
                                echo "<h3>No se encontraron movimientos en esta oficina.</h3>";
                            }else
                            {
                                ?>
                                <table class="table table-responsive table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="p-3">Fecha</th>
                                            <th class="p-3">Accion</th>
                                            <th class="p-3">Articulo</th>
                                            <th class="p-3">Unidad</th>
                                            <th class="p-3">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($movimientos as $movimiento) {
                                                echo "<tr>";
                                                echo "<td class='p-3'>".$movimiento['fecha']."</td>";
                                                echo "<td class='p-3'>".$movimiento['accion']."</td>";
                                                echo "<td class='p-3'>".$movimiento['producto']."</td>";
                                                echo "<td class='p-3'>".$movimiento['unidad']."</td>";
                                                echo "<td class='p-3'>".$movimiento['cantidad']."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>