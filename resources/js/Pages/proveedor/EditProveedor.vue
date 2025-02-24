
<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioProveedorEdit from '@/Components/Proveedor/CompProveedorEdit.vue';

    const props = defineProps({
        proveedor_edit: {
            type: Object, 
            required: true
        },
        servicio_edit: {
            type: Object, 
            required: true
        },
        proveedorcategorias: {
            type: Object, 
            required: true
        },
        ListaTipoComprobante: {
            type: Object, 
            required: true
        },
        ListaTipoSunat: {
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
        } 
    })
   
    //console.log("que fue" + props);
    //console.log(props.proveedor_edit);
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
                    <FormularioProveedorEdit  
                        :proveedor_edit="proveedor_edit"
                        :servicio_edit="servicio_edit"
                        :proveedorcategorias="proveedorcategorias" 
                        :ListaTipoComprobante="ListaTipoComprobante"
                        :ListaTipoSunat="ListaTipoSunat"
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
  