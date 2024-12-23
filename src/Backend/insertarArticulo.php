<?php

try {
    include 'conexion.php';
    $query2 = 'SELECT "Rubro"
    FROM "Rubros"';
    $stmt2 = $pdo->query($query2);
    $rubros = $stmt2->fetchAll(PDO::FETCH_ASSOC);


    if (!empty($_POST['nombre']) && !empty($_POST['rubro']) && !empty($_POST['cantidad'])) {
        $nombre = trim($_POST['nombre']);
        $rubro = $_POST['rubro'];
        $cantidad = (int)$_POST['rubro'];
        // ----------------QUERY INSERTAR ARTICULO ---------
        $query1 = 'INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") 
        VALUES (16, 3, "03016", "Guantes de látex para limpieza")';
        
        $stmt1 = $pdo1->query($query1);
        // $productos = $stmt1->fetchAll(PDO::FETCH_ASSOC);   
    }
    
} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
?>
