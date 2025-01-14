<?php 
    

    function obtenerEntradas($articulo,$existencias)
    { 
        $entradas=$articulo["Cantidad"];
        foreach ($existencias as $existencia) {
            if ($existencia["IdConcepto"] == $articulo["IdConcepto"] && $existencia["Accion"] == "Entrada") 
            {
                $entradas += $existencia["ExistenciasTotales"]; 
                if ($entradas<0) {
                    $entradas=0;
                }
            } 
        }
        return $entradas;
    }
 
    function obtenerSalidas($articulo,$existencias)
    { 
        $salidas=0;
        foreach ($existencias as $existencia) {
            if ($existencia["IdConcepto"] == $articulo["IdConcepto"] && $existencia["Accion"] == "Salida") 
            {
                $salidas += $existencia["ExistenciasTotales"]; 
                if ($salidas<0) {
                    $salidas=0;
                }
            } 
        }
        return $salidas;
    }



    function obtenerDisponible($salidas, $entradas)
    {         
        $disponible=$entradas-$salidas;
        if ($disponible<0) {
            $disponible=0;
        }
        return $disponible;
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

    function filtrarPorRubro($articulos, $busqueda) {
        
        if(!$busqueda){
            return $articulos;
        }
        
        // Uso array_filter para filtrar el array original
        $articulosFiltrados = array_filter($articulos, function($articulo) use ($busqueda) {
            // Busco la subcadena insensiblemente a mayúsculas/minúsculas
            return stripos($articulo['Rubro'], $busqueda) !== false;
        });
    
        // Reindexo el array resultante para que tenga índices consecutivos
        return array_values($articulosFiltrados);
    }


    function getPaginatedStock($page, $items_per_page, $articulos) {


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