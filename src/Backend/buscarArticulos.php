<?php
include 'conexion.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $stmt = $pdo->prepare("SELECT \"Articulo\" FROM public.\"Articulos\" WHERE \"Articulo\" ILIKE :query || '%' LIMIT 10");
    $stmt->execute(['query' => $query]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        foreach ($resultados as $resultado) {
            echo '<a href="#" class="col-md-12 list-group-item list-group-item-action">' . htmlspecialchars($resultado['Articulo']) . '</a>';
        }
    } else {
        echo '<p class="col-md-12 no-results">No se encontraron resultados</p>';
    }
}
?>
