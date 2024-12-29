<?php

try {
    include 'conexion.php';

    if (!empty($_POST['usu']) && !empty($_POST['contra']) && !empty($_POST['rol'])) {
        $usu = trim($_POST['usu']);
        $contra = trim(md5($_POST['contra']));
        $rol = $_POST['rol'];

        // ----------------QUERY PARA OBTENER UN USUARIO YA ALMACENADO SI ES QUE EXISTE ---------
        $queryUsuarios = 'SELECT "Usuario" FROM "Usuarios" WHERE "Usuario" = :usuario';
        $stmtUsuarios = $pdo->prepare($queryUsuarios);
        $stmtUsuarios->bindParam(':usuario', $usu, PDO::PARAM_STR);
        $stmtUsuarios->execute();

        $usuario = $stmtUsuarios->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            header('Location: ../components/Views/Usuarios/Usuarios.php?error=El+usuario+ya+existe');
            exit();
        }

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
