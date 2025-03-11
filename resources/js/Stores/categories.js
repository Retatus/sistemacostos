import { defineStore } from 'pinia';
import { reactive } from 'vue';
import apiService from '@/Services/apiService';

export const useCategoriesStore = defineStore("categories", () => {
    // Objeto reactivo global
    const globals = reactive({
      proveedor_categories: [],
      ubicaciones: [],
      tipo_sunat: [],
      tipo_comprobantes: [],
      tipo_pasajeros: [],
      tipo_documentos: [],
      pais: [],
      servicio_clases: [],
      idioma: [],
      mercado: []
    });

    async function initializeGlobals() {
        try {
            globals.proveedor_categories = await apiService.getProveedorCategories();
            globals.ubicaciones = await apiService.getUbicaciones();
            globals.tipo_sunat = await apiService.getTipoSunat();
            globals.tipo_comprobantes = await apiService.getTipoComprobantes();
            globals.tipo_pasajeros = await apiService.getTipoPasajeros();
            globals.tipo_documentos = await apiService.getTipoDocumentos();
            globals.pais = await apiService.getPais();
            globals.servicio_clases = await apiService.getServicioClases();
            globals.idioma = await apiService.getIdioma();
            globals.mercado = await apiService.getMercado();
        } catch (error) {
            console.log('Error al inicializar los datos globales:', error);
        }
    }

    // Retornar el estado y las funciones
    return {
        globals,
        initializeGlobals,
    };
}, 
{
    persist: true,
});