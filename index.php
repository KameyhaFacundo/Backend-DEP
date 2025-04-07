<?php
require_once 'config.php';

// Verifica si hay un usuario logueado y redirige
session_start();
if (isset($_SESSION['user'])) {
    header('Location: src/components/Views/Movimientos/Movimiento.php');
    exit;
}

// Obtener la ruta solicitada y limpiarla
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Definir las rutas disponibles usando las variables de entorno
$routes = [
    'Backend-DEP/Movimientos' => $_ENV['MOVIMIENTOS_PATH'] ?? '',
    'Backend-DEP/Centros' => $_ENV['CENTROS_PATH'] ?? '',
    'Backend-DEP/Stock' => $_ENV['STOCK_PATH'] ?? '',
    'Backend-DEP/Usuarios' => $_ENV['USUARIOS_PATH'] ?? '',
];

// Verificar si la ruta existe y cargar el archivo correspondiente
if (isset($routes[$request]) && !empty($routes[$request])) {
    $filePath = __DIR__ . '/' . $routes[$request];
    
    if (file_exists($filePath)) {
        require $filePath;
    } else {
        http_response_code(500);
        echo "Error: El archivo no existe en $filePath";
    }
} else {
    http_response_code(404);
    echo '404 - Página no encontrada';
}
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
    <link rel="stylesheet" href="<?php echo BASE_URL ?>styles/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>styles/style.css">
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
                    <div class="d-flex flex-column flex-md-row">
                        <!-- Título: se mostrará en segundo lugar para small, y en primer lugar para md+ -->
                        <div class="col-12 col-md-6 py-4 order-2 order-md-1">
                            <h4 class="py-3 mx-2"><strong>Iniciar Sesión al Sistema</strong></h4>
                        </div>
                        <!-- Imagen: se mostrará primero en small y luego a la derecha en md+ -->
                        <div class="col-12 col-md-6 py-4 d-flex justify-content-center align-items-center order-1 order-md-2">
                            <img src="./src/assets/img/header-responsive-1.png" alt="header-login">
                        </div>
                    </div>
                </div>
                    <div class="card-body">
                        <?php
                            //Muestra de mensaje de error en caso que exista
                            if(isset($_GET['error'])){
                                echo '<div class="alert alert-danger mt-2" role="alert">'.htmlspecialchars($_GET['error']).'</div>';
                            }
                        ?>
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
                            <div class="w-100 d-flex justify-content-start mb-1 ms-1">
                                <a href="<?php echo BASE_URL?>components/Views/RecuperarContrasenia/RecuperarContrasenia.php" class="">Olvidaste tu contraseña?</a>
                            </div>
                            <div class="align-items-center">
                                <button type="submit" id="loginButton" class="btn-loggin-ingresar">Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>