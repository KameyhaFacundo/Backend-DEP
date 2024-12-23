<?php
// Lista de orígenes permitidos
$allowedOrigins = ['http://localhost:5173', 'http://localhost:5174'];

// Verifica si el origen de la solicitud está en la lista permitida
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
} else {
    header('Access-Control-Allow-Origin: null'); // Bloquea solicitudes no permitidas
}

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // Respuesta vacía para solicitudes OPTIONS
}

try {
    include 'conexion.php';

    $query = '
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

';
    $stmt = $pdo->query($query);
    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['movimientos' => $movimientos]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
