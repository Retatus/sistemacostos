// resources/js/services/apiService.js
import axios from 'axios';

const apiService = {
  async getProveedorCategories() {
    //const response = await axios.get(`${route('ProveedorCategoria')}/selectOptions`); 
    const response = await axios.get(`/dashboard/proveedor_categoria/selectOptions`); 
    return response.data;
  },

  async getUbicaciones() {
    const response = await axios.get(`/dashboard/ubicacion/selectOptions`); 
    return response.data;
  },

  async getTipoSunat() {
    const response = await axios.get(`/dashboard/tipo_sunat/selectOptions`); 
    return response.data;
  },

  async getTipoComprobantes() {
    const response = await axios.get(`/dashboard/tipo_comprobante/selectOptions`); 
    return response.data;
  },

  async getTipoPasajeros() {
    const response = await axios.get(`/dashboard/tipo_pasajero/selectOptions`); 
    return response.data;
  },

  async getTipoDocumentos() {
    const response = await axios.get(`/dashboard/tipo_documento/selectOptions`); 
    return response.data;
  },

  async getPais() {
    const response = await axios.get(`/dashboard/pais/selectOptions`); 
    return response.data;
  },

  async getServicioClases() {
    const response = await axios.get(`/dashboard/servicio_clase/selectOptions`); 
    return response.data;
  },
};

export default apiService;