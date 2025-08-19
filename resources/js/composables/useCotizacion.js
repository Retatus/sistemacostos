import { reactive } from 'vue';
import { crearCotizacionVacia } from '@/models/cotizacionModel';
import axios from 'axios';

const cotizacion = reactive(crearCotizacionVacia());

async function cargarCotizacion(id) {
  const response = await axios.get(`/api/cotizaciones/${id}`);
  Object.assign(cotizacion, response.data); // <- MANTIENE REACTIVIDAD
}

async function guardarCotizacion() {
  if (cotizacion.id) {
    await axios.put(`/api/cotizaciones/${cotizacion.id}`, cotizacion);
  } else {
    await axios.post('/api/cotizaciones', cotizacion);
  }
}

export function useCotizacion() {
  return {
    cotizacion,
    cargarCotizacion,
    guardarCotizacion,
  };
}
