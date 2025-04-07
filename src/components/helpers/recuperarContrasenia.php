<?php
require_once dirname(__DIR__, 3) . '/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dato = $_POST['datoUsuarioContrasenia'] ?? null;
$tabla = "Usuarios";
if(!$dato) {
    header('Location: ' . BASE_URL . 'components/Views/RecuperarContrasenia/RecuperarContrasenia.php?error=No se ha ingresado un dato válido.');
    exit;
}else{
    $query = $pdo->prepare("SELECT * FROM $tabla WHERE 'Usuario' = '$dato' OR 'Mail' = '$dato'");
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if($resultado->num_rows === 0) {
        header('Location: ' . BASE_URL . 'components/Views/RecuperarContrasenia/RecuperarContrasenia.php?error=No se ha encontrado el usuario o el mail.');
        exit;
    }else{
        require 'path/to/PHPMailer/src/Exception.php';
        require 'path/to/PHPMailer/src/PHPMailer.php';
        require 'path/to/PHPMailer/src/SMTP.php';
    }
}
?>