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
        $fileName = 'movimientos_' . date('Ymd_His') . '.xls';

        // Encabezados para descarga
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Comienza el archivo XML
        echo '<?xml version="1.0"?>' . "\n";
        echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
        echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" 
                xmlns:o="urn:schemas-microsoft-com:office:office" 
                xmlns:x="urn:schemas-microsoft-com:office:excel" 
                xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";

        // Hoja de cálculo
        echo '<Worksheet ss:Name="Movimientos">' . "\n";
        echo '<Table>' . "\n";

        // Encabezados
        echo '<Row>';
        foreach (array_keys($movimientos[0]) as $header) {
            echo '<Cell><Data ss:Type="String">' . htmlspecialchars($header) . '</Data></Cell>';
        }
        echo '</Row>' . "\n";

        // Filas de datos
        foreach ($movimientos as $row) {
            echo '<Row>';
            foreach ($row as $cell) {
                // Detectar tipo de dato
                $type = is_numeric($cell) ? "Number" : "String";
                echo '<Cell><Data ss:Type="' . $type . '">' . htmlspecialchars($cell) . '</Data></Cell>';
            }
            echo '</Row>' . "\n";
        }

        // Cierra tabla y hoja
        echo '</Table>' . "\n";
        echo '</Worksheet>' . "\n";

        // Cierra archivo
        echo '</Workbook>';
        exit;
    } else {
        echo "No hay datos para exportar.";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
