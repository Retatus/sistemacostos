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
                        :Accion="Accion"
                        :Cotizacion="Cotizacion"
                        :Lista_destinos_turistico="ListaDestinosTuristicos"
                        :ListaCategorias="ListaCategorias"
                        :ListaServicios="ListaServicios"
                    />
                </div>
            </div>
        </div>
    </AppLayout>           
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioCotizacion from '@/Components/Cotizacion/CompCotizacionAdd.vue';

    const props = defineProps({  
        Accion: {
            type: String,
            required: true,
        },
        Cotizacion : {
            type: Object,
            required: true,
        },
        ListaDestinosTuristicos: {
            type: Object,
            required: true,
        },
        ListaCategorias: {
            type: Object,
            required: false,
        },
        ListaServicios: {
            type: Object,
            required: false,
        },
    })
</script>
  
  <style scoped>
    /* Estilos opcionales */
    button {
        background-color: turquoise;
        color: rgb(50, 75, 97);
    }
  </style>
  