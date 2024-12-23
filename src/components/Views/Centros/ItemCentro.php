<?php

    function ItemCertro($centro){
        $html = "<tr>";
        $html .= "<td class='p-3'>".$centro['IdCentro']."</td>";
        $html .= "<td class='p-3'>".$centro['Centro']."</td>";
        $html .= "<td class='p-3'>";
        $html .= "<a href='Movimientos.php?id=".$centro['IdCentro']."' class='btn btn-danger'>Movimientos</a>";
        $html .= "</td>";
        $html .= "</tr>";
        return $html;
    }
?>