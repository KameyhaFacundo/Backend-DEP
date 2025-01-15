<?php

try {
    include 'conexion.php';

    // ----------------QUERY Obtener articulos ---------
    $query1 = 'SELECT "IdConcepto","Articulo", "Rubro", "Cantidad" FROM "Articulos"
    INNER JOIN "Rubros" USING ("IdRubro") 
    -- GROUP BY "IdConcepto","Articulo", "Rubro"
    ORDER BY "IdConcepto" ';
    
    $stmt1 = $pdo->query($query1);
    $stock = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // ----------------QUERY Obtener los movimientos de los articulos ---------
    $query2 = 'SELECT "IdConcepto",SUM("Cantidad") as "ExistenciasTotales", "Accion" 
    FROM "Movimientos"
    JOIN "Acciones"  USING ("IdAccion")
    -- WHERE "Accion" = \'Entrada\'
    GROUP BY "IdConcepto","Accion"';
    
    $stmt2 = $pdo->query($query2);
    $existencias = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    
    // ----------------QUERY OBTENER MOVIMENTOS  ---------
    $query3 = 'SELECT m."IdConcepto", m."Cantidad" , ac."Accion"
              FROM public."Movimientos" m
              JOIN public."Acciones" ac ON m."IdAccion" = ac."IdAccion"
              ORDER BY "IdConcepto"';
    $stmt3 = $pdo->query($query3);
    $movimientos = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    
    // ---------------- QUERY OBTENER RUBROS ---------
    $query4 = 'SELECT "Rubro"
    FROM "Rubros"';
    $stmt4 = $pdo->query($query4);
    $rubros = $stmt4->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
?>