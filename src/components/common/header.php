<?php
   require_once dirname(__DIR__, 3) . '/config.php';
   require dirname(__DIR__, 2).'/components/Routes/ProteccionRutas.php';
   verificarUsuarioLogueado();
   //var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="T">
    <meta name="author" content="">
    <title>DEP</title>
    <!-- Enlace dinamico al bootstrap -->
    <link rel="stylesheet" href="<?php echo BASE_URL?>styles/css/bootstrap.min.css">
    <!-- Enlace dinamico al css propio -->
    <link rel="stylesheet" href="<?php echo RUTA_CSS?>">
    <!-- Enlace al css del footer  -->
    <link rel="stylesheet" href="<?php echo FOOTER_CSS_URL?>">
    <!-- Enlace a los iconos de bootstrap -->
    <link rel="stylesheet" href="<?php echo BASE_URL?>styles/icons/font/bootstrap-icons.min.css">
    <!--<link rel="stylesheet" href="<?php echo BASE_URL?>styles/css/bootstrap4.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="container-fluid">
    <?php 
        include 'cabecera.php';
        echo cabecera();
    
    ?>