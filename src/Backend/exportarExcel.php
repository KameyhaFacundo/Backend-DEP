<?php
include 'conexion.php';

try {
    // Consulta los datos
    $stmt = $pdo->query('
    SELECT 
        m."IdMovimiento", 
        m."IdConcepto", 
        m."FechaMov", 
        m."Cantidad", 
        m."DescripUnidad", 
        m."Unidad", 
        a."Articulo", 
        c."Centro", 
        ac."Accion", 
        m."Motivo"
    FROM 
        public."Movimientos" m
    JOIN 
        public."Articulos" a ON m."IdConcepto" = a."IdConcepto"
    JOIN 
        public."Centros" c ON m."IdCentro" = c."IdCentro"
    JOIN 
        public."Acciones" ac ON m."IdAccion" = ac."IdAccion"
    ORDER BY 
        m."IdMovimiento" ASC
    ');
    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($movimientos) {
        // Nombre del archivo
        $fileName = 'movimientos_' . date('Ymd_His') . '.csv';

        // Configurar encabezados para descarga
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Abrir un flujo de salida
        $output = fopen('php://output', 'w');

        // Escribir encabezados al archivo CSV usando punto y coma como delimitador
        fputcsv($output, array_keys($movimientos[0]), ';');

        // Escribir datos al archivo CSV usando punto y coma como delimitador
        foreach ($movimientos as $row) {
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
