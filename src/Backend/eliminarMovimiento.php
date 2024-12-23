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

// Manejo de preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // Respuesta vacía para solicitudes OPTIONS
}

try {
    include 'conexion.php';

    // Verifica que se haya recibido un ID válido
    $idMovimiento = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($idMovimiento > 0) {

        $query = "DELETE FROM public.\"Movimientos\" WHERE \"IdMovimiento\" = :idMovimiento";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idMovimiento', $idMovimiento, PDO::PARAM_INT);

        if ($stmt->execute()) {
                header('Location: ../components/Views/Movimientos/Movimiento.php');
                exit();
            } else {
                echo "Error al guardar el movimiento.";
            }
    
    } else {
        echo json_encode(['message' => 'ID de movimiento no válido.']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
?>
