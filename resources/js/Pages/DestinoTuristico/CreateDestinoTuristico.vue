
<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import CompDestinoTuristicoAdd from '@/Components/DestinoTuristico/CompDestinoTuristicoAdd.vue';

    const props = defineProps({
        Accion: {
            type: String,
            required: true,
        },
        DestinoTuristico: {
            type: Object, 
            default: () => ({})
        },
        ListaItinerarios: {
            type: Object, 
            required: true
        },
        ListaProveedor: {
            type: Object, 
            required: true
        },
        ListaServicio: {
            type: Object, 
            required: true
        },
    })      
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight dark:text-gray-200">
                  Destino Turistico
              </h2>   
              <Link :href="route('destino_turistico')" class="btn btn-primary dark:text-gray-200"> <i class="bi bi-plus"></i>
                  Lista Destino Turistico
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <CompDestinoTuristicoAdd
                        :Accion="Accion"
                        :DestinoTuristico="DestinoTuristico"
                        :Lista_itinerarios="ListaItinerarios" 
                        :Lista_proveedor="ListaProveedor"
                        :Lista_servicio="ListaServicio"       
                    />
                </div>
            </div>
        </div>
    </AppLayout>          
</template>
  
  <style scoped>
    button {
        background-color: turquoise;
        color: rgb(50, 75, 97);
    }
  </style>
  