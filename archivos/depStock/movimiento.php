
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include 'conexion.php';
try {
    // Consultas para obtener datos para los selects
    $queryArticulos = 'SELECT "IdConcepto", "Articulo" FROM public."Articulos"';
    $queryCentros = 'SELECT "IdCentro", "Centro" FROM public."Centros"';
    $queryAcciones = 'SELECT "IdAccion", "Accion" FROM public."Acciones"';

    // Ejecutar las consultas
    $stmtArticulos = $pdo->query($queryArticulos);
    $stmtCentros = $pdo->query($queryCentros);
    $stmtAcciones = $pdo->query($queryAcciones);

    // Obtener los resultados
    $articulos = $stmtArticulos->fetchAll(PDO::FETCH_ASSOC);
    $centros = $stmtCentros->fetchAll(PDO::FETCH_ASSOC);
    $acciones = $stmtAcciones->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'articulos' => $articulos,
        'centros' => $centros,
        'acciones' => $acciones
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
