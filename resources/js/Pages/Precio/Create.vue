<script>
    export default {
        components: { FormularioDinamico },
    };
</script>

<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioDinamico from '@/Components/Categoria/FormDinanico.vue';
    import { ref } from 'vue';

    const props = defineProps({
        tipopasajeros: {
            type: Object, 
            required: true
        },        
        servicios: {
          type: Object, 
          required: true
        },
        servicios_clases: {
            type: Object, 
            required: true
        }
    })  

    const ListaServicios = ref([]);

    props.servicios.forEach(servicio => {
        ListaServicios.value.push({
            value: servicio.id,
            label: `${servicio.servicio_detalle.descripcion} [ ${servicio.tipo_pax} ]`
        });
    });

    const form = useForm({
        anio: "",
        moneda: "DOLARES",
        monto: "",
        tipo_pasajero_id: "",
        servicio_id: "",
        servicio_clase_id: "",
        estado_activo: "1",
    });

    const formFields = {   
        anio: { type: 'text', placeholder: 'Ingrese la año', label: 'año' },
        moneda: { 
            label: 'Moneda',
            type: 'select', 
            options: [
                { value: 'DOLARES', label: 'DOLARES' },
                { value: 'SOLES', label: 'SOLES' }, 
            ],             
        },
        monto: { type: 'text', placeholder: 'Ingrese el monto', label: 'monto' },
        tipo_pasajero_id: { 
            label: 'Tipo Pasajero', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... props.tipopasajeros
            ]
        },
        servicio_id: { 
            label: 'Servicio', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... ListaServicios.value
            ]
        },
        servicio_clase_id: {
            label: 'Servicio Clase',
            type: 'select',
            options: [
                { value: '', label: '--Seleccionar--' },
                ... props.servicios_clases
            ]
        },
        estado_activo: { 
            type: 'select', 
            options: [
                { value: '1', label: 'Activo' }, 
                { value: '0', label: 'Desactivo' }
            ], 
            label: 'Estado activo' 
        }
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Precio
              </h2>   
              <Link :href="route('precio')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Precio
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
                        @submit="form.post(route('precio.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  