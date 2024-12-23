<?php

try {
    include 'conexion.php';

    // ----------------QUERY Obtener stock ---------
    $query1 = 'SELECT "IdConcepto","Articulo", "Rubro", SUM("Cantidad") as "ExistenciasTotales" FROM "Articulos"
    INNER JOIN "Rubros" USING ("IdRubro") 
    INNER JOIN "Movimientos" USING ("IdConcepto")
    GROUP BY "IdConcepto","Articulo", "Rubro"
    ORDER BY "IdConcepto" ';
    
    $stmt1 = $pdo->query($query1);
    $productos = $stmt1->fetchAll(PDO::FETCH_ASSOC);


    // ----------------QUERY OBTENER MOVIMENTOS  ---------
    $query2 = 'SELECT m."IdConcepto", m."Cantidad" , ac."Accion"
              FROM public."Movimientos" m
              JOIN public."Acciones" ac ON m."IdAccion" = ac."IdAccion"';
    $stmt2 = $pdo->query($query2);
    $movimientos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    // ----------------QUERY OBTENER RUBROS  ---------
    $query3 = 'SELECT "Rubro"
    FROM "Rubros"';
    $stmt3 = $pdo->query($query3);
    $rubros = $stmt3->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
?>
