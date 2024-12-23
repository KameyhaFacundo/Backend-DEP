<?php 
    function calcularDisponible($productos,$movimientos,$existencias)
    {
        $disponibles=$existencias;
        foreach ($movimientos as $movimiento) {
                if ($movimiento["IdConcepto"] == $productos["IdConcepto"] && $movimiento["Accion"] == "Salida") 
                {
                   $disponibles -= $movimiento["Cantidad"]*2 ; 
                   if ($disponibles<0) {
                      $disponibles=0;
                   }
                   return $disponibles;
                } 
        }
    }

    function obtenerExistencias($producto,$existencias)
    { 
        $existenciasTotales=0;
        foreach ($existencias as $existencia) {
            if ($existencia["IdConcepto"] == $producto["IdConcepto"]) 
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