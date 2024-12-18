import React from "react";
import { Modal, Button } from "react-bootstrap";

function ModalMovimiento({
  showModal,
  onClose,
  onSubmit,
  formData,
  handleInputChange,
  data,
  selectedArticulo,
  selectedCentro,
  selectedAccion,
  setSelectedArticulo,
  setSelectedCentro,
  setSelectedAccion,
}) {
  return (
    <Modal show={showModal} onHide={onClose} centered>
      <Modal.Header closeButton>
        <Modal.Title>Formulario de Movimiento</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <form onSubmit={onSubmit} className="modal-form">
          <div className="form-group">
            <label>
              Fecha:
              <input
                type="date"
                name="FechaMov"
                value={formData.FechaMov}
                onChange={handleInputChange}
                required
              />
            </label>
          </div>
          <div className="form-group">
            <label>
              Acción:
              <select
                value={selectedAccion}
                onChange={(e) => setSelectedAccion(e.target.value)}
                required
              >
                <option value="">Seleccione una acción</option>
                {data.acciones.map((accion) => (
                  <option key={accion.IdAccion} value={accion.IdAccion}>
                    {accion.Accion}
                  </option>
                ))}
              </select>
            </label>
          </div>
          <div className="form-group">
            <label>
              Artículo:
              <select
                value={selectedArticulo}
                onChange={(e) => setSelectedArticulo(e.target.value)}
                required
              >
                <option value="">Seleccione un artículo</option>
                {data.articulos.map((articulo) => (
                  <option key={articulo.IdConcepto} value={articulo.IdConcepto}>
                    {articulo.Articulo}
                  </option>
                ))}
              </select>
            </label>
          </div>
          <div className="form-group">
            <label>
              Centro:
              <select
                value={selectedCentro}
                onChange={(e) => setSelectedCentro(e.target.value)}
                required
              >
                <option value="">Seleccione un centro</option>
                {data.centros.map((centro) => (
                  <option key={centro.IdCentro} value={centro.IdCentro}>
                    {centro.Centro}
                  </option>
                ))}
              </select>
            </label>
          </div>
          <div className="form-group">
            <label>
              Cantidad:
              <input
                type="number"
                name="Cantidad"
                value={formData.Cantidad}
                onChange={handleInputChange}
                required
              />
            </label>
          </div>
          <div className="form-group">
            <label>
              Motivo:
              <textarea
                name="Motivo"
                value={formData.Motivo}
                onChange={handleInputChange}
                required
              ></textarea>
            </label>
          </div>
          <div className="form-group double">
            <label>
              Unidad:
              <input
                type="text"
                name="Unidad"
                value={formData.Unidad}
                onChange={handleInputChange}
                required
              />
            </label>
          </div>
          <div className="form-group double">
            <label>
              Descripción:
              <input
                type="text"
                name="DescripUnidad"
                value={formData.DescripUnidad}
                onChange={handleInputChange}
                required
              />
            </label>
          </div>
          <div className="modal-footer">
            <button type="button" onClick={onClose}>
              Cancelar
            </button>
            <button type="submit">Guardar</button>
          </div>
        </form>
      </Modal.Body>
    </Modal>
  );
}

export default ModalMovimiento;
