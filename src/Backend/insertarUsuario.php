<?php

try {
    include 'conexion.php';

    if (!empty($_POST['usu']) && !empty($_POST['contra']) && !empty($_POST['rol'])) {
        $usu = trim($_POST['usu']);
        $contra = trim(md5($_POST['contra']));
        $rol = $_POST['rol'];

        // ----------------QUERY PARA OBTENER IDROL  ---------
        $queryIdRol = 'SELECT "IdRol" FROM "Roles" WHERE "Rol" = :rol';

        $stmtIdRol = $pdo->prepare($queryIdRol);
        $stmtIdRol->bindParam(':rol', $rol, PDO::PARAM_INT);
        $stmtIdRol->execute();

        $idRol = $stmtIdRol->fetch(PDO::FETCH_ASSOC);

        // ----------------QUERY INSERTAR USUARIO ---------
        $queryInsert = 'INSERT INTO "Usuarios" ("Usuario", "IdRol", "Password") 
         VALUES (:usuario, :idRol, :contra)';

        //Vinculo los parametros para realizar la consulta.

        $stmtInsert = $pdo->prepare($queryInsert);
        $stmtInsert->bindParam(':usuario', $usu, PDO::PARAM_STR);
        $stmtInsert->bindParam(':idRol', $idRol['IdRol'], PDO::PARAM_INT);
        $stmtInsert->bindParam(':contra', $contra, PDO::PARAM_STR);
        
        if ($stmtInsert->execute()) {
            header('Location: ../components/Views/Usuarios/Usuarios.php');
            exit();
            // echo '<p>Insercion exitosa</p>';
        } else {
            echo "Error al agregar el articulo.";
        }
    }
    else {
        echo "Falta algún parámetro";
    }
    
} catch (PDOException $e) {
        'Error al obtener productos: ' . $e->getMessage();
}
?>
