<?php
    require 'ModalMovimientoCentro.php';

    function ItemCertro($centro){
        ob_start();
        ?>
        <tr>
            <td><?php echo $centro['IdCentro']; ?></td>
            <td><?php echo $centro['Centro']; ?></td>
            <td>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMovimientosCentro<?php echo $centro['IdCentro']; ?>">
                    Movimientos
                </button>
                <?php MostrarModalMovimientosCentro($centro['IdCentro']); ?>
            </td>
        </tr>
        <?php
        return ob_get_clean();
    }
?>