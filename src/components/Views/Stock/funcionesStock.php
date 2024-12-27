<?php 
    function calcularDisponible($articulo,$movimientos,$existencias)
    {
        $disponibles=$existencias;
        foreach ($movimientos as $movimiento) {
                if ($movimiento["IdConcepto"] == $articulo["IdConcepto"] ) 
                {
                    if ($movimiento["Accion"] == "Salida") {
                        $disponibles -= $movimiento["Cantidad"] ; 
                        if ($disponibles<0) {
                            $disponibles=0;
                        }
                    }
                } 
        }
        return $disponibles;
    }

    function obtenerExistencias($articulo,$existencias)
    { 
        $existenciasTotales=0;
        foreach ($existencias as $existencia) {
            if ($existencia["IdConcepto"] == $articulo["IdConcepto"]) 
            {
                $existenciasTotales = $existencia["ExistenciasTotales"]; 
                if ($existenciasTotales<0) {
                    $existenciasTotales=0;
                }
            } 
        }
        return $existenciasTotales;
    }



    function filtrarPorArticulo($articulos, $busqueda) {
        // Usar array_filter para filtrar el array original
        if(!$busqueda){
          return $articulos;
        }

        $articulosFiltrados = array_filter($articulos, function($articulo) use ($busqueda) {
            // Buscar la subcadena insensiblemente a mayúsculas/minúsculas
            return stripos($articulo['Articulo'], $busqueda) !== false;
        });
    
        // Reindexar el array resultante para que tenga índices consecutivos
        return array_values($articulosFiltrados);
    }


    function getPaginatedStock($page, $items_per_page, $articulos) {

        // if ($articulos) {
        //   $articulos = filtrarPorArticulo($articulo,$movimientos);
        // }
      
        $total_articulos = count($articulos);
        $total_pages = ceil($total_articulos / $items_per_page);
        $current_page = min($page, $total_pages);
      
        $offset = ($current_page - 1) * $items_per_page;
        $paginated_articulos = array_slice($articulos, $offset, $items_per_page);
      
        return [
          'cant_articulos' => $paginated_articulos,
          'total_pages' => $total_pages,
          'current_page' => $current_page
          ];
    }

?>