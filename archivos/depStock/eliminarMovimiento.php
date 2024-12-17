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

    // Verifica que se haya enviado una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtiene los datos del cuerpo de la solicitud
        $data = json_decode(file_get_contents("php://input"), true);
        $idMovimiento = $data['IdMovimiento'];

        if (isset($idMovimiento) && !empty($idMovimiento)) {
            // Consulta para eliminar el movimiento
            $query = "DELETE FROM public.\"Movimientos\"  WHERE \"IdMovimiento\" = :idMovimiento";

            // Prepara la consulta
            $stmt = $pdo->prepare($query);

            // Enlaza el parámetro y ejecuta la consulta
            $stmt->bindParam(':idMovimiento', $idMovimiento, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Movimiento eliminado correctamente.']);
            } else {
                echo json_encode(['message' => 'Error al eliminar el movimiento.']);
            }
        } else {
            // Si no se ha proporcionado el idMovimiento
            echo json_encode(['message' => 'ID de movimiento no proporcionado.']);
        }
    } else {
        echo json_encode(['message' => 'Método no permitido.']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
?>
