<?php 

    function filtrarPorUsuario($usuarios, $busqueda) {
        // Usar array_filter para filtrar el array original
        if(!$busqueda){
          return $usuarios;
        }

        $usuariosFiltrados = array_filter($usuarios, function($usuario) use ($busqueda) {
            // Buscar la subcadena insensiblemente a mayúsculas/minúsculas
            return stripos($usuario['Usuario'], $busqueda) !== false;
        });
    
        // Reindexar el array resultante para que tenga índices consecutivos
        return array_values($usuariosFiltrados);
    }

    function filtrarPorRubro($usuarios, $busqueda){

        if(!$busqueda){
            return $usuarios;
        }
        // Uso array_filter para filtrar el array original
        $usuariosFiltrados = array_filter($usuarios, function($usuario) use ($busqueda) {
            // Busco la subcadena insensiblemente a mayúsculas/minúsculas
            return stripos($usuario['Rol'], $busqueda) !== false;
        });
    
        // Reindexo el array resultante para que tenga índices consecutivos
        return array_values($usuariosFiltrados);
    }



    function getPaginatedStock($page, $items_per_page, $usuarios) {

      
        $total_usuarios = count($usuarios);
        $total_pages = ceil($total_usuarios / $items_per_page);
        $current_page = min($page, $total_pages);
      
        $offset = ($current_page - 1) * $items_per_page;
        $paginated_usuarios = array_slice($usuarios, $offset, $items_per_page);
      
        return [
          'cant_usuarios' => $paginated_usuarios,
          'total_pages' => $total_pages,
          'current_page' => $current_page
          ];
    }

?>