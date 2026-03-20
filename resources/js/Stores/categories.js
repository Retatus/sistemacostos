import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';
import apiService from '@/Services/apiService';

export const useCategoriesStore = defineStore("categories", () => {
    const isLoaded = ref(false); // Para evitar recargas innecesarias
    
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
        mercado: [],
        tipo_costos: [],
    });

    async function initializeGlobals() {
        // Si ya tenemos datos, no volvemos a pegarle a la API
        if (isLoaded.value) return;

        try {
            // Ejecución en paralelo (Mucho más rápido)
            const [
                prov, ubi, sunat, comp, pas, doc, p, cl, id, mer, cost
            ] = await Promise.all([
                apiService.getProveedorCategories(),
                apiService.getUbicaciones(),
                apiService.getTipoSunat(),
                apiService.getTipoComprobantes(),
                apiService.getTipoPasajeros(),
                apiService.getTipoDocumentos(),
                apiService.getPais(),
                apiService.getServicioClases(),
                apiService.getIdioma(),
                apiService.getMercado(),
                apiService.getTipoCostos(),
            ]);

            // Asignación limpia
            globals.proveedor_categories = prov;
            globals.ubicaciones = ubi;
            globals.tipo_sunat = sunat;
            globals.tipo_comprobantes = comp;
            globals.tipo_pasajeros = pas;
            globals.tipo_documentos = doc;
            globals.pais = p;
            globals.servicio_clases = cl;
            globals.idioma = id;
            globals.mercado = mer;
            globals.tipo_costos = cost;

            isLoaded.value = true;
        } catch (error) {
            console.log('Error al inicializar los datos globales:', error);
        }
    }

    // Retornar el estado y las funciones
    return {
        globals,
        isLoaded,
        initializeGlobals,
    };
}, 
{
    persist: true,
});