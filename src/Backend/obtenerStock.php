<?php

try {
    include 'conexion.php';

    $query1 = 'SELECT "IdConcepto","Articulo", "Rubro" FROM "Articulos"
    INNER JOIN "Rubros" USING ("IdRubro") 
    -- GROUP BY "IdConcepto","Articulo", "Rubro"
    ORDER BY "IdConcepto" ';
    
    $stmt1 = $pdo->query($query1);
    $productos = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    // ----------------QUERY Obtener stock ---------
    $query2 = 'SELECT "IdConcepto",SUM("Cantidad") as "ExistenciasTotales" 
    FROM "Movimientos" 
    GROUP BY "IdConcepto"
    ORDER BY "IdConcepto" ';
    
    $stmt2 = $pdo->query($query2);
    $existencias = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    
    // ----------------QUERY OBTENER MOVIMENTOS  ---------
    $query3 = 'SELECT m."IdConcepto", m."Cantidad" , ac."Accion"
              FROM public."Movimientos" m
              JOIN public."Acciones" ac ON m."IdAccion" = ac."IdAccion"
              ORDER BY "IdConcepto"';
    $stmt3 = $pdo->query($query3);
    $movimientos = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    
    // ----------------QUERY OBTENER RUBROS  ---------
    $query4 = 'SELECT "Rubro"
    FROM "Rubros"';
    $stmt4 = $pdo->query($query3);
    $rubros = $stmt4->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
?>
