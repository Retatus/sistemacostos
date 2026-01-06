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
            label: `[${servicio.proveedor.razon_social}] ${servicio.servicio_detalle.descripcion}`
        });
    });

    const form = useForm({
        anio: "",
        moneda: "USD",
        tipo_costo: "UNITARIO",
        tipo_habitacion: "simple",
        pax_min: 1,
        pax_max: 99,
        capacidad_pax: 1,
        monto: "",
        tipo_pasajero_id: "",
        servicio_id: "",
        servicio_clase_id: "",
        estado_activo: "1",
    });

    const formFields = {   
        servicio_id: { 
            label: 'Servicio', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... ListaServicios.value
            ]
        },
        anio: { type: 'text', placeholder: 'Ingrese la año', label: 'año' },
        moneda: { 
            label: 'Moneda',
            type: 'select', 
            options: [
                { value: 'USD', label: 'USD' },
                { value: 'PEN', label: 'PEN' }, 
            ],             
        },
        tipo_costo: {
            label: 'Tipo Costo',
            type: 'select', 
            options: [
                { value: 'UNITARIO', label: 'Unitario' },
                { value: 'GRUPAL', label: 'Grupal' }, 
                { value: 'HABITACION', label: 'Habitacion' }, 
            ],             
        },
        tipo_habitacion: {
            label: 'Tipo Habitacion',
            type: 'select', 
            options: [
                { value: 'simple', label: 'Simple' },
                { value: 'doble', label: 'Doble' }, 
                { value: 'triple', label: 'Triple' },
                { value: 'cuadruple', label: 'Cuadruple' },
                { value: 'suite', label: 'Suite' },
            ]
        },
        pax_min: { type: 'number', placeholder: 'Ingrese pax min', label: 'pax min' },
        pax_max: { type: 'number', placeholder: 'Ingrese pax max', label: 'pax max' },
        capacidad_pax: { type: 'number', placeholder: 'Ingrese capacidad pax', label: 'capacidad pax' },     
        monto: { type: 'text', placeholder: 'Ingrese el monto', label: 'monto' },
        tipo_pasajero_id: { 
            label: 'Tipo Pasajero', 
            type: 'select', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... props.tipopasajeros
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
  