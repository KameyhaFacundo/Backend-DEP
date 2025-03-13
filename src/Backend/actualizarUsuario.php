<?php
include '../../config.php';
try {
    include 'conexion.php';

    if (!empty($_POST['usuario']) && !empty($_POST['rol']) && !empty($_POST['idUsuario'])) {
        $usu = trim($_POST['usuario']);
        //$contra = trim(md5($_POST['password']));
        $rol = $_POST['rol'];
        $idUsuario = $_POST['idUsuario'];

        if(empty($_POST['password'])){
            // ----------------QUERY MODIFICAR USUARIO SIN CONTRASÑA---------
            $queryInsert = 'UPDATE "Usuarios" 
            SET "Usuario" = :usu, 
                "IdRol" = (SELECT "IdRol" FROM "Roles" WHERE "Rol" = :rol)
            WHERE "IdUsuario" = :idUsu';   

            //Vinculo los parametros para realizar la consulta.
            $stmtInsert = $pdo->prepare($queryInsert);
            $stmtInsert->bindParam(':idUsu', $idUsuario, PDO::PARAM_STR);
            $stmtInsert->bindParam(':usu', $usu, PDO::PARAM_STR);
            $stmtInsert->bindParam(':rol', $rol, PDO::PARAM_INT);       
        }
        else{
            $contra = trim(md5($_POST['password']));
            // ----------------QUERY MODIFICAR USUARIO CON CONTRASEÑA---------
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
        }
        

        
        if ($stmtInsert->execute()) {
            header('Location: '.BASE_URL.'components/Views/Usuarios/Usuarios.php');
            exit();
            // echo '<p>Modificacion exitosa</p>';
        } else {
            header('Location:'.BASE_URL.'../Usuarios?error=El+usuario+ya+existe');
            exit();
            echo "Error al modificar el usuario.";
        }
    }
    else {
        header('Location:'.BASE_URL.'../Usuarios?error=Faltan+parametros+requeridos.');
        exit();
    }
    
} catch (PDOException $e) {
        'Error : ' . $e->getMessage();
}
?>
