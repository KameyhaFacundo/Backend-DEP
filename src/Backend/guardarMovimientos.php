<?php
include '../../config.php';
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fechaMov = $_POST['FechaMov'];
    $idConcepto = $_POST['Articulo'];
    $idCentro = $_POST['Centro'];
    $idAccion = $_POST['Accion'];
    $cantidad = $_POST['Cantidad'];
    $unidad = $_POST['Unidad'];
    $descripUnidad = $_POST['DescripUnidad'];
    $motivo = $_POST['Motivo'];

    $query = "INSERT INTO public.\"Movimientos\" 
        (\"FechaMov\", \"IdCentro\", \"Cantidad\", \"IdAccion\", 
         \"IdConcepto\", \"Unidad\", \"Motivo\", \"DescripUnidad\") 
        VALUES (:fechaMov, :idCentro, :cantidad, :idAccion, :idConcepto, :unidad, :motivo, :descripUnidad)";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':fechaMov', $fechaMov, PDO::PARAM_STR);
    $stmt->bindParam(':idCentro', $idCentro, PDO::PARAM_INT);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $stmt->bindParam(':idAccion', $idAccion, PDO::PARAM_INT);
    $stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_INT);
    $stmt->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
    $stmt->bindParam(':descripUnidad', $descripUnidad, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header('Location: '.BASE_URL.'../Movimientos');
        exit();
    } else {
        echo "Error al guardar el movimiento.";
    }
}
?>
