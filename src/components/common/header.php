<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="T">
    <meta name="author" content="">
    <title>DEP</title>
    <!-- Enlace dinamico al bootstrap -->
    <link rel="stylesheet" href="<?php echo $ruta1 ?>/css/bootstrap.min.css">
    <!-- Enlace dinamico al css propio -->
    <link rel="stylesheet" href="<?php echo $ruta2?>.css">
    <!-- Enlace al css del footer  -->
    <link rel="stylesheet" href="<?php echo $rutaFooter?>footer.css">
</head>
<body class="container-fluid">
    <?php 
        include 'cabecera.php';
        echo cabecera();
    
    ?>