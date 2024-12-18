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

include 'conexion.php';

try {
    // Verificar que el método sea POST
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo json_encode(['message' => 'Método no permitido.']);
        http_response_code(405); // Method Not Allowed
        exit;
    }

    // Decodificar datos JSON del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar campos requeridos
    $requiredFields = ['IdMovimiento', 'FechaMov', 'IdConcepto', 'IdCentro', 'IdAccion', 'Cantidad', 'Unidad', 'Motivo', 'DescripUnidad'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            echo json_encode(['message' => "El campo $field es obligatorio."]);
            http_response_code(400); // Bad Request
            exit;
        }
    }

    // Asignar valores a variables
    $idMovimiento = $data['IdMovimiento'];
    $fechaMov = $data['FechaMov'];
    $idConcepto = $data['IdConcepto'];
    $idCentro = $data['IdCentro'];
    $idAccion = $data['IdAccion'];
    $cantidad = $data['Cantidad'];
    $unidad = $data['Unidad'];
    $motivo = $data['Motivo'];
    $descripUnidad = $data['DescripUnidad'];

    // Validar tipos de datos
    if (!is_numeric($idMovimiento) || !is_numeric($idCentro) || !is_numeric($idAccion) || !is_numeric($cantidad)) {
        echo json_encode(['message' => 'Los campos numéricos deben ser válidos.']);
        http_response_code(400); // Bad Request
        exit;
    }
    if (!strtotime($fechaMov)) {
        echo json_encode(['message' => 'La fecha proporcionada no es válida.']);
        http_response_code(400); // Bad Request
        exit;
    }

    // Preparar consulta SQL
    $query = "UPDATE public.\"Movimientos\" 
              SET \"FechaMov\" = :fechaMov,
                  \"IdCentro\" = :idCentro,
                  \"Cantidad\" = :cantidad,
                  \"IdAccion\" = :idAccion,
                  \"IdConcepto\" = :idConcepto,
                  \"Unidad\" = :unidad,
                  \"Motivo\" = :motivo,
                  \"DescripUnidad\" = :descripUnidad
              WHERE \"IdMovimiento\" = :idMovimiento";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idMovimiento', $idMovimiento, PDO::PARAM_INT);
    $stmt->bindParam(':fechaMov', $fechaMov, PDO::PARAM_STR);
    $stmt->bindParam(':idCentro', $idCentro, PDO::PARAM_INT);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $stmt->bindParam(':idAccion', $idAccion, PDO::PARAM_INT);
    $stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_STR);
    $stmt->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
    $stmt->bindParam(':descripUnidad', $descripUnidad, PDO::PARAM_STR);

    // Ejecutar consulta
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Movimiento actualizado correctamente.']);
    } else {
        echo json_encode(['message' => 'Error al actualizar el movimiento.']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error en el servidor.', 'error' => $e->getMessage()]);
   
} catch (Exception $e) {
    echo json_encode(['message' => 'Error inesperado.', 'error' => $e->getMessage()]);
    
}
?>
