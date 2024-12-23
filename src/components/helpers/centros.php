<?php
    require_once dirname(__DIR__, 3) . '/config.php';

    function obtenerCentros() {
        $url = BASE_URL.'Backend/ObtenerOficinas.php';
        $solicitud = curl_init($url);

        curl_setopt($solicitud, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($solicitud, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($solicitud);
        $httpCode = curl_getinfo($solicitud, CURLINFO_HTTP_CODE);
        if(curl_errno($solicitud)){
            $errorMenssage = curl_error($solicitud);
            curl_close($solicitud);
            throw new Exception('Error en la petición: ' . $errorMenssage);
        }

        curl_close($solicitud);

        if($httpCode === 200){
            $result = json_decode($response, true);
            if(isset($result['success']) && $result['success']===true){
                return $result['centros'];
            }else
            {
                throw new Exception('Error en la respuesta del backend: '.$result['message']??'Error desconocido');
            }
        }else
        {
            throw new Exception('Error en la solicitur: Codigo HTTO: '.$httpCode);
        }
    }
?>