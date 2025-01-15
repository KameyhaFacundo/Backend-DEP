<?php
    define('BASE_URL', 'http://localhost/Backend-DEP/src/');
    define('BASE_PATH', __DIR__);
    //Enlaces relativos
    define('MENU_URL', '../../common/Menu.php');//URL relativo para el menú desde vistas
    define('FOOTER_URL', BASE_PATH.'/src/components/common/footer.php');
    define('FOOTER_CSS_URL', BASE_URL.'components/common/footer.css');
    // define('MENU_URL', '../../common/Menu.php');
    // define('MENU_URL', '../../common/Menu.php');
    // define('MENU_URL', '../../common/Menu.php');

    define('MOVIMIENTOS_URL', BASE_URL . 'components/Views/Movimientos/Movimiento.php');
    define('OFICINAS_URL', BASE_URL . 'components/Views/Centros/Centros.php');
    define('STOCK_URL', BASE_URL . 'components/Views/Stock/Stock.php');
    define('USUARIOS_URL', BASE_URL . 'components/Views/Usuarios/Usuarios.php');
    // $movURL = '../Movimientos/Movimiento.php';
    // $oficinaURL = '../Centros/Centros.php';
    // $stockURL = '../Stock/Stock.php';
    // $usuariosURL = '../Usuarios/Usuarios.php';
?>