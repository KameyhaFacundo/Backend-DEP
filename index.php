<?php
    require_once 'config.php';
    $ruta1 = 'src/styles';
    $ruta2= 'src/index';
    $rutaFooter="src/components/common/";
    //require("src/components/common/header.php");

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
    <link rel="stylesheet" href="<?php echo $ruta1 ?>/css/bootstrap.min.css">
    <!-- Enlace dinamico al css propio -->
    <link rel="stylesheet" href="<?php echo $ruta2?>.css">
    <!-- Enlace al css del footer  -->
    <link rel="stylesheet" href="<?php echo $rutaFooter?>footer.css">
</head>
<body class="container-fluid">

<main class="d-flex justify-content-center align-items-center mt-5 pt-5">
<div class="container text-center mb-5">
            <div class="title m-4">
                <h2><strong>DEP-Stock Management - Dirección Estadística de Tucumán</strong></h2>
            </div>
            <div class="d-flex justify-content-center mx-3">
                <div class="card p-0">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="col-6 py-4">
                                <h4 class="py-3 mx-2"><strong>Iniciar Sesión al Sistema</strong></h4>
                            </div>
                            <div class="col-6 py-4 d-flex justify-content-center align-items-center">
                                <img src="./src/assets/img/header-responsive-1.png" alt="header-login">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="loginForm" action="./src/components/helpers/querie_login.php" method="POST" name="formLogin">
                            <div class="mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="nombreUsuario" 
                                    name="nombreUsuario" 
                                    placeholder="Ingrese su nombre de usuario" 
                                    maxlength="16" 
                                    required>
                            </div>
                            <div class="mb-3">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="contrasenia" 
                                    name="contrasenia" 
                                    placeholder="Ingrese su contraseña" 
                                    maxlength="16" 
                                    required>
                            </div>
                            <!--Muestra un mensaje de error en caso que corresponda-->

                            <?php if(isset($_GET['error'])): ?>
                              <div id="errorMessage" class="text-danger mb-3">
                                <? htmlspecialchars($_GET['error']) ?>
                              </div>
                            <?php endif;?>
                            <button type="submit" id="loginButton" class="btn btn-primary">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
