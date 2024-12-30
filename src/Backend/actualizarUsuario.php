<?php

try {
    include 'conexion.php';

    if (!empty($_POST['usuario']) && !empty($_POST['password']) && !empty($_POST['rol']) && !empty($_POST['idUsuario'])) {
        $usu = trim($_POST['usuario']);
        $contra = trim(md5($_POST['password']));
        $rol = $_POST['rol'];
        $idUsuario = $_POST['idUsuario'];

        // ----------------QUERY PARA OBTENER UN USUARIO YA ALMACENADO SI ES QUE EXISTE ---------
        $queryUsuRepetido = 'SELECT "Usuario" FROM "Usuarios" WHERE "Usuario" = :usuario';
        $stmtUpdateUsu = $pdo->prepare($queryUsuRepetido);
        $stmtUpdateUsu->bindParam(':usuario', $usu, PDO::PARAM_STR);
        $stmtUpdateUsu->execute();

        $usuario = $stmtUpdateUsu->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            header('Location: ../components/Views/Usuarios/Usuarios.php?error=El+usuario+ya+existe');
            exit();
        }

        // ----------------QUERY PARA OBTENER IDROL  ---------
        // $queryIdRol = 'SELECT "IdRol" FROM "Roles" WHERE "Rol" = :rol';

        // $stmtIdRol = $pdo->prepare($queryIdRol);
        // $stmtIdRol->bindParam(':rol', $rol, PDO::PARAM_INT);
        // $stmtIdRol->execute();

        // $idRol = $stmtIdRol->fetch(PDO::FETCH_ASSOC);

        // ----------------QUERY MODIFICAR USUARIO ---------
        $queryInsert = 'UPDATE "Usuarios" 
        SET "Usuario" = :usu, 
            "IdRol" = (SELECT "IdRol" FROM "Roles" WHERE "Rol" = :rol), 
            "Password" = :contra   
        WHERE "IdUsuario" = :idUsu';

        //Vinculo los parametros para realizar la consulta.

        $stmtInsert = $pdo->prepare($queryInsert);
        $stmtInsert->bindParam(':idUsu', $idUsuario, PDO::PARAM_STR);
        $stmtInsert->bindParam(':usu', $usu, PDO::PARAM_STR);
        $stmtInsert->bindParam(':rol', $rol, PDO::PARAM_INT);
        $stmtInsert->bindParam(':contra', $contra, PDO::PARAM_STR);
        
        if ($stmtInsert->execute()) {
            header('Location: ../components/Views/Usuarios/Usuarios.php');
            exit();
            // echo '<p>Modificacion exitosa</p>';
        } else {
            echo "Error al modificar el usuario.";
        }
    }
    else {
        echo "Falta algún parámetro";
    }
    
} catch (PDOException $e) {
        'Error : ' . $e->getMessage();
}
?>
