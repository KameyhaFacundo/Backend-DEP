<?php
//Inicia la sesion
session_start();

//Verifica si los datos del formulario se envian correctamente
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $nombreUsuario=$_POST['nombreUsuario'];
    $contrasenia=$_POST['contrasenia'];
    
    //URL del back
    $url = 'http://localhost/Backend-DEP/src/Backend/login.php';

    //Crea los datos para mandarlos al back
    $data = json_encode([
        "username" => $nombreUsuario,
        "password" => $contrasenia
    ]);

    $solicitud = curl_init($url);
    curl_setopt($solicitud, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($solicitud, CURLOPT_POST, true);
    curl_setopt($solicitud, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($solicitud, CURLOPT_POSTFIELDS, $data);

    //Ejecuta la solicitud
    $response=curl_exec($solicitud);
    $httpCode=curl_getinfo($solicitud, CURLINFO_HTTP_CODE);

    //Decodifica la respuesta del backend
    $result=json_decode($response,true);

    echo "<script>console.log('".$result."')</script>";

    if($httpCode===200 && isset($result['success']) && $result['success']===true)
    {
        $_SESSION['user']=[
            'id' => $result['idusuario'],
            'username'=>$result['usuario']
        ];
        header('Location: ../../home.php');
        exit;
    }else
    {
        //Falla la autenticacion
        $errorMessage = $result['message'] ?? 'Error. Intentelo de nuevo mas tarde.';
        header('Location: ../../../index.php?error='.urlencode($errorMessage));
        exit;
    }
} else
{
    header('Location: ../../../index.php');
    exit;
}
?>