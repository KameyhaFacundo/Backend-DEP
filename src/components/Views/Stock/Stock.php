
<?php

?>
   <div className='mainSection'>
    
    {/* Tabla de productos */}
    <div className="productos-container">
      <div className="productos-header">
        <h2>Productos Registrados</h2>
      </div>

      <Table responsive striped hover bordered>
        <thead>
          <tr>
            <th className="p-3">Código</th>
            <th className="p-3">Artículo</th>
            <th className="p-3">Rubro</th>
            <th className="p-3">Existencias Totales</th>
            <th className="p-3">Existencias Disponibles</th>
          </tr>
        </thead>
        <tbody >
          {currentProduct.length > 0 ? (
             currentProduct.map((productos, index) => ( 
               <tr>
               <td className="p-3">{productos.IdConcepto}</td>
              <td className="p-3">{productos.Articulo}</td>
              <td className="p-3">{productos.Rubro}</td>
              <td className="p-3">{productos.ExistenciasTotales}</td>
              <td className="p-3">{calcularDisponibles(productos,movimientos)}</td>
              </tr>
              ))
              )  
                   : (
                     <tr>
                      <td colSpan="9">No hay productos registrados.</td>
                    </tr>
                    )}  
                  </tbody>
                </Table>
                <div className="pagination">
                  <Button
          variant="secondary"
          onClick={() => paginate(currentPage - 1)}
          disabled={currentPage === 1}
          className="pagination-btn"
          >
          <i className="fa fa-arrow-left"></i>
        </Button>
        <span>{currentPage}</span>
        <Button
        variant="secondary"
        onClick={() => paginate(currentPage + 1)}
        disabled={
          currentPage === Math.ceil(movimientos.length / rowsPerPage) ||
          movimientos.length === 0
        }
        className="pagination-btn"
        >
        <i className="fa fa-arrow-right"></i>
      </Button>
    </div>
    
  </div>
</div>
</>
);
}

<?php
          ?>
