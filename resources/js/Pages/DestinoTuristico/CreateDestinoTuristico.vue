
<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import CompDestinoTuristicoAdd from '@/Components/DestinoTuristico/CompDestinoTuristicoAdd.vue';

    const props = defineProps({
        ListaProveedorCategorias: {
            type: Object, 
            required: true
        },
        ListaProveedor: {
            type: Object, 
            required: true
        },
        ListaServicioClase: {
          type: Object, 
          required: true
        } ,
        ListaServicioDetalle: {
            type: Object, 
            required: true
        },
    })  
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Destino Turistico
              </h2>   
              <Link :href="route('proveedor')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Destino Turistico
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <CompDestinoTuristicoAdd 
                        :Lista_proveedor_categorias="ListaProveedorCategorias" 
                        :Lista_proveedor="ListaProveedor"
                        :Lista_servicio_clase="ListaServicioClase" 
                        :Lista_servicio_detalle="ListaServicioDetalle"                    
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
  