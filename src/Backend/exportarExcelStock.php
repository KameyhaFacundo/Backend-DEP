<?php
include 'conexion.php';

try {

    // Consulta los datos
    $stmt = $pdo->query('SELECT * FROM "Articulos" ORDER BY "IdConcepto" ASC');
    $backStock = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($backStock) {
        // Nombre del archivo
        $fileName = 'stock_' . date('Ymd_His') . '.csv';

        // Configurar encabezados para descarga
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Abrir un flujo de salida
        $output = fopen('php://output', 'w');

        // Escribir encabezados al archivo CSV usando punto y coma como delimitador
        fputcsv($output, array_keys($backStock[0]), ';');

        // Escribir datos al archivo CSV usando punto y coma como delimitador
        foreach ($backStock as $row) {
            fputcsv($output, $row, ';');
        }

        // Cerrar el flujo de salida
        fclose($output);
        exit;
    } else {
        echo "No hay datos para exportar.";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
