<script>
    export default {
        components: { FormularioDinamico },
    };
</script>

<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioDinamico from '@/Components/Categoria/FormDinanico.vue';

    const props = defineProps({
        ListaProveedor: {
            type: Object, 
            required: true
        },
        ListaUbicacion: {
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

    const form = useForm({
        proveedor_id: "",
        servicio_detalle_id: "",
        ubicacion_id: "",
        estado_activo: "1",
    });

    const formFields = {   
        proveedor_id: { 
            label: 'Proveedor', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... props.ListaProveedor
            ]
        },
        servicio_detalle_id: { 
            label: 'Servicio Detalle', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' }, 
                ...props.ListaServicio_detalle
            ]
        },
        ubicacion_id: { 
            label: 'Ubicacion', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' },  
                ...props.ListaUbicacion
            ], 
        },
        estado_activo: { 
            label: 'Estado activo',
            type: 'select', 
            options: [
                { value: '1', label: 'Activo' }, 
                { value: '0', label: 'Desactivo' }
            ], 
        }
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Servicio
              </h2>   
              <Link :href="route('servicio')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Servicio
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <FormularioDinamico
                        :form="form"
                        :fields="formFields"                            
                        :updating="false"
                        @submit="form.post(route('servicio.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  