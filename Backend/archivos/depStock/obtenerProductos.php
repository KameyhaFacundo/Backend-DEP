<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {
    include 'conexion.php';

    // ----------------QUERY ---------
    $query = 'SELECT "IdConcepto","Articulo", "Rubro", SUM("Cantidad") as "ExistenciasTotales" FROM "Articulos"
    INNER JOIN "Rubros" USING ("IdRubro") 
    INNER JOIN "Movimientos" USING ("IdConcepto")
    GROUP BY "IdConcepto","Articulo", "Rubro"
    ORDER BY "IdConcepto" ';
    
    $stmt = $pdo->query($query);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([
        'success' => true,
        'productos' => $productos
        ]
    );
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error al obtener productos: ' . $e->getMessage()]);
}
?>
