<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Cotizacion
              </h2>   
              <Link :href="route('cotizacion')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Cotizacion
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <FormularioCotizacion  
                        :Correlativo ="Correlativo"
                        :Lista_tipo_comprobante="ListaTipoComprobante"
                        :Lista_destinos_turistico="ListaDestinosTuristicos"
                        :Lista_paises="ListaPaises" 
                        :Lista_tipo_documento="ListaTipoDocumento"
                        :Lista_tipo_pasajero="ListaTipoPasajero"
                        :Lista_tipo_clase="ListaTipoClase"
                        :Lista_Proveedor_Categorias="ListaProveedorCategorias"
                        :ListaTipoSunat="ListaTipoSunat"
                    />
                </div>
            </div>
        </div>
    </AppLayout>           
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioCotizacion from '@/Components/Cotizacion/CompCotizacionAdd.vue';

    const props = defineProps({  
        Correlativo: {
            type: String,
            required: true,
        },
        ListaTipoComprobante: {
            type: Object,
            required: true,
        },
        ListaDestinosTuristicos: {
            type: Object,
            required: true,
        },
        ListaPaises: {
            type: Object,
            required: true,
        },
        ListaTipoDocumento: {
            type: Object,
            required: true,
        },
        ListaTipoPasajero: {
            type: Object,
            required: true,
        },        
        ListaTipoClase: {
            type: Object,
            required: true,
        },
        ListaProveedorCategorias: {
            type: Object,
            required: true,
        },
        ListaTipoSunat: {
            type: Object,
            required: true,
        }
    })  

    const ListaTipoDocumento = ref(props.ListaTipoDocumento);
    const ListaTipoSunat = ref(props.ListaTipoSunat);

</script>
  
  <style scoped>
    /* Estilos opcionales */
    button {
        background-color: turquoise;
        color: rgb(50, 75, 97);
    }
  </style>
  