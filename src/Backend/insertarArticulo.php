<?php

try {
    include 'conexion.php';

    if (!empty($_GET['nombre']) && !empty($_GET['rubro']) && !empty($_GET['cantidad'])) {
        $nombre = trim($_GET['nombre']);
        $rubro = $_GET['rubro'];
        $cantidad = (int)$_GET['cantidad'];

        // ----------------QUERY PARA OBTENER IDARTICULO E IDRUBRO ---------
        $queryIdArt = 'SELECT "IdArticulo", "IdRubro"
        FROM "Articulos" INNER JOIN "Rubros" USING ("IdRubro") 
        WHERE "Rubro" = :rubro
        ORDER BY "IdArticulo" desc LIMIT 1';

        $stmtIdArt = $pdo->prepare($queryIdArt);
        $stmtIdArt->bindParam(':rubro', $rubro, PDO::PARAM_INT);
        $stmtIdArt->execute();
        
        $idArt = 0;
        $idRub = 0;
        
        while ($fila = $stmtIdArt->fetch(PDO::FETCH_ASSOC)) {
            $idArt = $fila['IdArticulo'];
            $idRub = $fila['IdRubro'];
        }
        //Creo el IdConcepto a partir del IdRubro e IdArticulo. Estas funciones me agregan los 0 necesarios a la izquierda de cada id para que coincidan con el patron definido. 
        $idConcepto = str_pad($idRub, 2, "0", STR_PAD_LEFT)."".str_pad($idArt, 3, "0", STR_PAD_LEFT);

        // ----------------QUERY INSERTAR ARTICULO ---------
        $queryInsert = 'INSERT INTO "Articulos" ("IdArticulo", "IdRubro", "IdConcepto", "Articulo") 
         VALUES (:idArticulo, :idRubro, :idConcepto, :articulo)';

        //Vinculo los parametros para realizar la consulta.

        $stmtInsert = $pdo->prepare($queryInsert);
        $stmtInsert->bindParam(':idArticulo', ($idArt+1), PDO::PARAM_INT);
        $stmtInsert->bindParam(':idRubro', $idRub, PDO::PARAM_INT);
        $stmtInsert->bindParam(':idConcepto', $idConcepto, PDO::PARAM_STR);
        $stmtInsert->bindParam(':articulo', $nombre, PDO::PARAM_STR);
        // $productos = $stmtInsert->fetchAll(PDO::FETCH_ASSOC); 
        
        if ($stmtInsert->execute()) {
            header('Location: '.BASE_URL.'components/Views/Stock/Stock.php');
            // echo '<p>Insercion exitosa</p>';
        } else {
            echo "Error al agregar el articulo.";
        }
    }
    
} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
?>
