<?php
function filtrarPorFecha($fechaMov = null) {

    include 'conexion.php'; 
    
    $sql = "SELECT * FROM movimientos WHERE 1=1";

    if ($fechaMov) {
        $sql .= " AND FechaMov = :fechaMov";
    }

    $stmt = $conexion->prepare($sql);

    if ($fechaMov) {
        $stmt->bindParam(':fechaMov', $fechaMov);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>