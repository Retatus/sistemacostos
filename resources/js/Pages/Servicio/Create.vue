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
        ListaServicio_clase: {
            type: Object, 
            required: true
        } ,
        ListaServicio_detalle: {
            type: Object, 
            required: true
        } 
    })
console.log(props);
    const form = useForm({
        monto: "",
        moneda: "DOLARES",
        proveedor_id: "",
        servicio_detalle_id: "",
        ubicacion: "",
        tipo_pax: "ADULTO",
        servicio_clase_id: "",
        estado_activo: "1",

    });

    const formFields = {   
        monto: { type: 'text', placeholder: 'Ingrese el monto', label: 'monto' },     
        moneda: { 
            label: 'Moneda',
            type: 'select', 
            options: [
                { value: 'SOLES', label: 'SOLES' }, 
                { value: 'DOLARES', label: 'DOLARES' },
            ],             
        },
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
        ubicacion: { type: 'text', placeholder: 'Ingrese la ubicacion', label: 'ubicacion' },
        tipo_pax: { 
            label: 'Tipo pax', 
            type: 'select', 
            options: [
                { value: 'ADULTO', label: 'ADULTO' }, 
                { value: 'ESTUDIANTE', label: 'ESTUDIANTE' },
                { value: 'NINIO', label: 'NIÑO' }
            ], 
        },
        servicio_clase_id: { 
            label: 'Servicio Clase', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' }, 
                ...props.ListaServicio_clase
            ]
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
  