<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

try {
    include 'conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        $fechaMov = $data['FechaMov'];
        $idConcepto = $data['IdConcepto'];
        $idCentro = $data['IdCentro'];
        $idAccion = $data['IdAccion'];
        $cantidad = $data['Cantidad'];
        $descripUnidad = $data['DescripUnidad'];
        $unidad = $data['Unidad'];
        $motivo = $data['Motivo'];
        $query = "INSERT INTO public.\"Movimientos\" 
          (\"FechaMov\", \"IdCentro\", \"Cantidad\", \"IdAccion\", 
           \"IdConcepto\", \"Unidad\", \"Motivo\", \"DescripUnidad\") 
          VALUES (:fechaMov, :idCentro, :cantidad, :idAccion, :idConcepto, :unidad, :motivo, :descripUnidad)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':fechaMov', $fechaMov, PDO::PARAM_STR);
        $stmt->bindParam(':idCentro', $idCentro, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':idAccion', $idAccion, PDO::PARAM_INT);
        $stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_STR);
        $stmt->bindParam(':unidad', $unidad, PDO::PARAM_STR);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
        $stmt->bindParam(':descripUnidad', $descripUnidad, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Movimiento guardado correctamente.']);
        } else {
            echo json_encode(['message' => 'Error al guardar el movimiento.']);
        }
    } else {
        echo json_encode(['message' => 'Método no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
}
?>
