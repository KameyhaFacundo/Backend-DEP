<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Content-Type: application/json');

try {
    include 'conexion.php';

    $query = 'SELECT m."IdConcepto", m."FechaMov", m."Cantidad", m."DescripUnidad", m."Unidad", 
                     a."Articulo", c."Centro", ac."Accion", m."Motivo"
              FROM public."Movimientos" m
              JOIN public."Articulos" a ON m."IdConcepto" = a."IdConcepto"
              JOIN public."Centros" c ON m."IdCentro" = c."IdCentro"
              JOIN public."Acciones" ac ON m."IdAccion" = ac."IdAccion"';
    $stmt = $pdo->query($query);
    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['movimientos' => $movimientos]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
