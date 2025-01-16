
<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioProveedor from '@/Components/Proveedor/CompProveedorAdd.vue';

    const props = defineProps({
        proveedorcategorias: {
            type: Object, 
            required: true
        },
        ListaServicio_clase: {
          type: Object, 
          required: true
        } ,
        ListaServicio_detalle: {
            type: Object, 
            required: true
        },
        categoriaCostos: {
            type: Object, 
            required: true
        },
        categoriaDestinos: {
            type: Object, 
            required: true
        } ,
        categoriaDistribuciones: {
            type: Object, 
            required: true
        } 
    })

    console.log(props.proveedorcategorias);
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
                    <FormularioProveedor  
                        :categoriaCostos="categoriaCostos" 
                        :categoriaDestinos="categoriaDestinos" 
                        :categoriaDistribuciones="categoriaDistribuciones"
                        :proveedorcategorias="proveedorcategorias" 
                        :ListaServicio_clase="ListaServicio_clase" 
                        :ListaServicio_detalle="ListaServicio_detalle"                
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
  