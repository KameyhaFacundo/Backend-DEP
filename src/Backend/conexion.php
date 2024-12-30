<?php
    $host = "localhost";
    $db = "DEP-Stock";
    $user = "postgres";
    $pass= "admin";

// Establecer la conexión a la base de datos usando PDO
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    // Establecer el modo de error de PDO para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error en la conexión, mostrar un mensaje
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    exit;
}

?>
