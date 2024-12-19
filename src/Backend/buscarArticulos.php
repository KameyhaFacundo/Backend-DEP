<?php
include 'conexion.php';

// Establece la cabecera de contenido como JSON.
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    try {
        // Prepara y ejecuta la consulta.
        $stmt = $pdo->prepare("SELECT \"Articulo\" FROM public.\"Articulos\" WHERE \"Articulo\" ILIKE :query || '%' LIMIT 10");

        $stmt->execute(['query' => $query]);

        // Obtén los resultados.
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devuelve los resultados en formato JSON.
        echo json_encode($resultados);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error en la consulta: " . $e->getMessage()]);
    }
} else {
    // Si no se recibe un parámetro, devuelve un array vacío.
    echo json_encode([]);
}
?>
