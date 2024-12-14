<?php
// Incluye el archivo de conexión
include 'conexion.php';

// Establecer los encabezados de respuesta para CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verifica si se envió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos enviados desde el frontend (React)
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;

    $error = '';
    try {
        // Consulta preparada para buscar el usuario
        $query = $pdo->prepare('SELECT * FROM "Usuarios" u WHERE "Usuario" = :username');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();

        // Verifica si se encontró el usuario
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            // Verifica la contraseña con MD5
            if ($user['Password'] === md5($password)) {
                // Si la autenticación es exitosa, devuelve el usuario y un mensaje de éxito
                echo json_encode([
                    'success' => true,
                    'usuario' => $user['Usuario'],
                    'idusuario' => $user['IdUsuario']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos: ' . $e->getMessage()]);
    }
}
?>
