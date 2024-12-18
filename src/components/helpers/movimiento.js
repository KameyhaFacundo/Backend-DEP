const API_BASE_URL = "http://localhost/archivos/depStock";

export const fetchInitialData = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/movimiento.php`);
    const data = await response.json();
    return {
      articulos: data.articulos || [],
      centros: data.centros || [],
      acciones: data.acciones || [],
    };
  } catch (error) {
    console.error("Error fetching initial data:", error);
    throw error;
  }
};

export const fetchMovimientos = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/obtenerMovimientos.php`);
    const data = await response.json();
    return data.movimientos || [];
  } catch (error) {
    console.error("Error fetching movimientos:", error);
    throw error;
  }
};

export const saveMovimiento = async (payload) => {
  try {
    const response = await fetch(`${API_BASE_URL}/guardarMovimientos.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error saving movimiento:", error);
    throw error;
  }
};

export const deleteMovimiento = async (payload) => {
  try {
    const response = await fetch(`${API_BASE_URL}/eliminarMovimiento.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error al eliminar movimiento:", error);
    throw error;
  }
};

export const updateMovimiento = async (payload) => {
  try {
    const response = await fetch(`${API_BASE_URL}/actualizarMovimiento.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error al actualizar movimiento:", error);
    throw error;
  }
};
