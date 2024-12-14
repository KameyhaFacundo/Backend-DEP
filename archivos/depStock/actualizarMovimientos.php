<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

try {
    include 'conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "PUT") {
        $data = json_decode(file_get_contents("php://input"), true);

        // Asegúrate de que el ID esté presente en la solicitud
        if (!isset($_GET['id'])) {
            echo json_encode(['message' => 'Falta el ID del movimiento']);
            http_response_code(400); // Código de error por solicitud incorrecta
            exit;
        }

        $idMovimiento = $_GET['id'];
        $fechaMov = $data['FechaMov'];
        $idConcepto = $data['IdConcepto'];
        $idCentro = $data['IdCentro'];
        $idAccion = $data['IdAccion'];
        $cantidad = $data['Cantidad'];
        $descripUnidad = $data['DescripUnidad'];
        $unidad = $data['Unidad'];
        $motivo = $data['Motivo'];

        // Actualizar el registro correspondiente en la base de datos
        $query = "UPDATE public.\"Movimientos\" 
                  SET 
                    \"FechaMov\" = :fechaMov,
                    \"IdCentro\" = :idCentro,
                    \"Cantidad\" = :cantidad,
                    \"IdAccion\" = :idAccion,
                    \"IdConcepto\" = :idConcepto,
                    \"Unidad\" = :unidad,
                    \"Motivo\" = :motivo,
                    \"DescripUnidad\" = :descripUnidad
                  WHERE 
                    \"IdMovimiento\" = :idMovimiento";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':fechaMov', $fechaMov, PDO::PARAM_STR);
        $stmt->bindParam(':idCentro', $idCentro, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':idAccion', $idAccion, PDO::PARAM_INT);
        $stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_STR);
        $stmt->bindParam(':unidad', $unidad, PDO::PARAM_STR);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
        $stmt->bindParam(':descripUnidad', $descripUnidad, PDO::PARAM_STR);
        $stmt->bindParam(':idMovimiento', $idMovimiento, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Movimiento actualizado correctamente.']);
        } else {
            echo json_encode(['message' => 'Error al actualizar el movimiento.']);
        }
    } else {
        echo json_encode(['message' => 'Método no permitido']);
        http_response_code(405); // Código para método no permitido
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    http_response_code(500); // Código de error interno del servidor
}
?>
