
<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import CompDestinoTuristicoEdit from '@/Components/DestinoTuristico/CompDestinoTuristicoEdit.vue';

    const props = defineProps({
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
        DestinoTuristico: {
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
                    <CompDestinoTuristicoEdit
                        :Lista_itinerarios="ListaItinerarios" 
                        :Lista_proveedor="ListaProveedor"
                        :Lista_servicio="ListaServicio"    
                        :DestinoTuristico="DestinoTuristico"   
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
  