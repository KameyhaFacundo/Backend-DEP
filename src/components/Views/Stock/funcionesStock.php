<?php 
    function calcularDisponible($articulo,$movimientos,$existencias)
    {
        $disponibles=$existencias;
        foreach ($movimientos as $movimiento) {
                if ($movimiento["IdConcepto"] == $articulo["IdConcepto"] && $movimiento["Accion"] == "Salida") 
                {
                   $disponibles -= $movimiento["Cantidad"]*2 ; 
                   if ($disponibles<0) {
                      $disponibles=0;
                   }
                   return $disponibles;
                } 
        }
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
?>