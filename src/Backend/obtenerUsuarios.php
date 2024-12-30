<?php

try {
    include 'conexion.php';

    // ----------------QUERY Obtener usuarios ---------
    $query1 = 'SELECT * FROM "Usuarios"
    INNER JOIN "Roles" USING ("IdRol") 
    -- GROUP BY "IdConcepto","Articulo", "Rubro"
    ORDER BY "IdRol","IdUsuario" ';
    
    $stmt1 = $pdo->query($query1);
    $usuariosBD = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // ----------------QUERY Obtener Roles  ---------
    $queryRol = 'SELECT "Rol"
    FROM "Roles"';
    $stmtRol = $pdo->query($queryRol);
    $rolesBD = $stmtRol->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
finally {
    // Desconectar manualmente
    $pdo = null;
}
?>
