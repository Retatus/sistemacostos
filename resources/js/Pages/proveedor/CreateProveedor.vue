
<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioProveedorAdd from '@/Components/Proveedor/CompProveedorAdd.vue';

    const props = defineProps({ 
        ListaServicioDetalle: {
            type: Object, 
            required: true
        }
    })
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Proveedor
              </h2>   
              <Link :href="route('proveedor')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Proveedor
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <FormularioProveedorAdd
                        :ListaServicioDetalle="ListaServicioDetalle"
                    />
                </div>
            </div>
        </div>
    </AppLayout>          
</template>
  
  <style scoped>
    /* Estilos opcionales */
    button {
        background-color: turquoise;
        color: rgb(50, 75, 97);
    }
  </style>
  