//Helper para calcular la disponibilidad de articulos en stock

export const calcularDisponibles = (productos, movimientos) => { 
   try {  
      let disponibles = productos.ExistenciasTotales;
       movimientos.forEach((movimiento) => { 
         if (movimiento.IdConcepto === productos.IdConcepto && movimiento.Accion === "Salida") 
         {
            disponibles -= movimiento.Cantidad*2 ; 
            if (disponibles<0) {
               disponibles=0;
            }
         } 
       }); 
       return disponibles; 
   } catch (error) {
      console.log('A ocurrido un error: '+error);
      return null;
   } 
  };