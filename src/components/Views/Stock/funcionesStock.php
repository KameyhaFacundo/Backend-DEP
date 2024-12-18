<?php 
    function calcularDisponible($productos,$movimientos)
    {
        $disponibles=$productos["ExistenciasTotales"];    

            foreach ($movimientos as $movimiento) {
                if ($movimiento["IdConcepto"] == $productos["IdConcepto"] && $movimiento["Accion"] == "Salida") 
                {
                   $disponibles -= $movimiento["Cantidad"]*2 ; 
                   if ($disponibles<0) {
                      $disponibles=0;
                   }
                } 
                return $disponibles;
            }
    }
?>