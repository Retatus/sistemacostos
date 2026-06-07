import { ref } from 'vue'
//import api from '@/services/api'
import axios from 'axios';

export function useCatalogoServicios() {
  const categorias = ref([])
  const proveedores = ref([])
  const servicios = ref([])

  const cargarCategorias = async () => {
    categorias.value = await axios.get('/api/categorias')
  }

  const cargarProveedores = async (categoriaId) => {
    proveedores.value = await axios.get(`/api/proveedores/${categoriaId}`)
  }

  const cargarServicios = async (proveedorId) => {
    servicios.value = await axios.get(`/api/servicios/${proveedorId}`)
  }

  return {
    categorias,
    proveedores,
    servicios,
    cargarCategorias,
    cargarProveedores,
    cargarServicios
  }
}
