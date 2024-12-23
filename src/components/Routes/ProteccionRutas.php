<?php
session_start();

function verificarUsuarioLogueado() {
    if (!isset($_SESSION['user'])) {
        header("Location: http://localhost/Backend-DEP/"); //Esta ruta habria que modificarla al momento de subir el proyecto
        exit();
    }
}

// Llamar a la función para verificar si el usuario está logueado
verificarUsuarioLogueado();
?>