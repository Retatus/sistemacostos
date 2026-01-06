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
        },
        precio: {
            type: Object, 
            required: true
        } 
    })
 
    console.log(props.servicios);

    const ListaServicios = ref([]);

    props.servicios.forEach(servicio => {
        ListaServicios.value.push({
            value: servicio.id,
            label: `[${servicio.proveedor.razon_social}] ${servicio.servicio_detalle.descripcion}`
        });
    });

    console.log(ListaServicios.value);

    const form = useForm({
        anio: props.precio.anio,
        moneda: props.precio.moneda,
        tipo_costo: props.precio.tipo_costo,
        tipo_habitacion: props.precio.tipo_habitacion,
        pax_min: props.precio.pax_min,
        pax_max: props.precio.pax_max,
        capacidad_pax: props.precio.capacidad_pax,
        monto: props.precio.monto,
        tipo_pasajero_id: props.precio.tipo_pasajero_id,
        servicio_id: props.precio.servicio_id,
        servicio_clase_id: props.precio.servicio_clase_id,
        estado_activo: props.precio.estado_activo,
    });

    const formFields = {   
        servicio_id: { 
            label: 'Servicio',
            type: 'select', 
            disabled: true,
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
            ]
        },
        tipo_habitacion: {
            label: 'Tipo Habitacion',
            type: 'select', 
            options: [
                { value: 'simple', label: 'SIMPLE' },
                { value: 'doble', label: 'DOBLE' },
                { value: 'triple', label: 'TRIPLE' },
                { value: 'cuadruple', label: 'CUADRUPLE' },
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
                        :updating="true"
                        @submit="form.patch(route('precio.update', precio))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  