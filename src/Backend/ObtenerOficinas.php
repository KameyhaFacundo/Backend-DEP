<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include 'conexion.php';

try {
    //Consulta para obtener los centros
    $queryCentros = 'SELECT "IdCentro", "Centro" FROM public."Centros"';
    //Ejecuta la consulta
    $stmtCentros = $pdo->query($queryCentros);

    //Obtener resultados
    $centros = $stmtCentros->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'centros' => $centros
    ]);
} catch (PDOException $e) {
    http_response_code(500); // Indica que hubo un error
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
    exit;
}
?>