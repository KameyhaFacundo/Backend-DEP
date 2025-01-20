<?php
include '../../config.php';
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

// Recibir datos del formulario
$idMovimiento = $_POST['idMovimiento'];
$fechaMov = $_POST['FechaMov'];
$accion = $_POST['Accion'];
$articulo = $_POST['Articulo'];
$centro = $_POST['Centro'];
$cantidad = $_POST['Cantidad'];
$unidad = $_POST['Unidad'];
$descripUnidad = $_POST['DescripUnidad'];
$motivo = $_POST['Motivo'];

// Actualizar el movimiento en la base de datos
$query = "UPDATE public.\"Movimientos\" 
          SET \"FechaMov\" = :fechaMov, \"IdAccion\" = :accion, \"IdConcepto\" = :articulo, \"IdCentro\" = :centro, 
              \"Cantidad\" = :cantidad, \"Unidad\" = :unidad, \"DescripUnidad\" = :descripUnidad, \"Motivo\" = :motivo 
          WHERE \"IdMovimiento\" = :idMovimiento";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':fechaMov', $fechaMov, PDO::PARAM_STR);
$stmt->bindParam(':accion', $accion, PDO::PARAM_INT);
$stmt->bindParam(':articulo', $articulo, PDO::PARAM_INT);
$stmt->bindParam(':centro', $centro, PDO::PARAM_INT);
$stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
$stmt->bindParam(':unidad', $unidad, PDO::PARAM_STR);
$stmt->bindParam(':descripUnidad', $descripUnidad, PDO::PARAM_STR);
$stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
$stmt->bindParam(':idMovimiento', $idMovimiento, PDO::PARAM_INT);
    if ($stmt->execute()) {
        header('Location: '.BASE_URL.'../Movimientos');
        exit();
    } else {
        echo "Error al guardar el movimiento.";
    }
?>
