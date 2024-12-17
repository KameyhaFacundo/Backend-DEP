<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include 'conexion.php';

try
{
    if(!isset($_GET['idCentro'])){
        //En caso que no se pase el id del centro como parametro retorna un error
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message'=>'El parametro ID es requerido'
        ]);
        exit;
    }
    $idCentro=$_GET['idCentro']; //Recibe el id del centro u oficina de la que se desea buscar los movimientos 
    //Consulta
    $query='SELECT 
        c."Centro" AS Centro,
        m."FechaMov" AS Fecha,
        a."Accion" AS Accion,
        art."Articulo" AS Producto,
        m."Unidad" AS Unidad,
        m."Cantidad" AS Cantidad
    FROM 
        "Movimientos" m
    JOIN 
        "Centros" c ON m."IdCentro" = c."IdCentro"
    JOIN 
        "Acciones" a ON m."IdAccion" = a."IdAccion"
    JOIN 
        "Articulos" art ON m."IdConcepto" = art."IdConcepto"
    WHERE 
        m."IdCentro" = :idCentro
    ORDER BY 
        m."FechaMov"';

    //Prepara la consulta en el PDO
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(':idCentro', $idCentro, PDO::PARAM_INT);

    //Ejecuta la consulta
    $stmt->execute();

    $movimientos=$stmt->fetchAll(PDO::FETCH_ASSOC);

    //Si encuentra movimientos retorna los datos
    if($movimientos){
        echo json_encode([
            'success'=>true,
            'data'=>$movimientos
        ]);
    }else
    {
        echo json_encode([
            'success'=>false,
            'message'=>'No se encontraron movimientos en esta oficina.'
        ]);
    }
    
}catch (PDOException $e) {
    http_response_code(500); // Indica que hubo un error
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
    exit;
}
?>