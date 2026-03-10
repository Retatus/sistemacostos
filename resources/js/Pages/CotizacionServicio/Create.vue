<script>
    export default {
        components: { FormularioDinamico },
    };
</script>

<script setup>
    import {Link, useForm} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioDinamico from '@/Components/Categoria/FormDinanico.vue';

    const form = useForm({
        nro_dia: "",
        nro_orden: "",
        hora: "",
        itinerario_servicio_id: "",
        cotizacion_id: "",
        precio_id: "",
        moneda: "",
        precio_unitario: "",
        cantidad: "",
        capacidad: "",
        tipo_habitacion_id: "",
        subtotal: "",
        observacion: "",
        tipo_costo_id: "",
        estado_activo: "",

    });

    const formFields = {
        nro_dia: { type: 'text', placeholder: 'Ingrese el nro_dia', label: 'Nro dia' },
        nro_orden: { type: 'text', placeholder: 'Ingrese el nro_orden', label: 'Nro orden' },
        hora: { type: 'text', placeholder: 'Ingrese la hora', label: 'Hora' },
        itinerario_servicio_id: { type: 'text', placeholder: 'Ingrese el itinerario_servicio_id', label: 'Itinerario servicio ID' },
        cotizacion_id: { type: 'text', placeholder: 'Ingrese el cotizacion_id', label: 'Cotizacion ID' },
        precio_id: { type: 'text', placeholder: 'Ingrese el precio_id', label: 'Precio ID' },
        moneda: { type: 'text', placeholder: 'Ingrese la moneda', label: 'Moneda' },
        precio_unitario: { type: 'text', placeholder: 'Ingrese el precio_unitario', label: 'Precio unitario' },
        cantidad: { type: 'text', placeholder: 'Ingrese la cantidad', label: 'Cantidad' },
        capacidad: { type: 'text', placeholder: 'Ingrese la capacidad', label: 'Capacidad' },
        tipo_habitacion_id: { type: 'text', placeholder: 'Ingrese el tipo_habitacion_id', label: 'Tipo habitacion ID' },
        subtotal: { type: 'text', placeholder: 'Ingrese el subtotal', label: 'Subtotal' },
        observacion: { type: 'text', placeholder: 'Ingrese la observacion', label: 'Observacion' },
        tipo_costo_id: { type: 'text', placeholder: 'Ingrese el tipo_costo_id', label: 'Tipo costo ID' },        
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
                  CotizacionServicio
              </h2>   
              <Link :href="route('cotizacion_servicio')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista CotizacionServicio
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
                        @submit="form.post(route('cotizacion_servicio.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  