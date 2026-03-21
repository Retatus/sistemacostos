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
        cotizacion_id: "",
        cotizacion_dia_id: "",
        servicio_id: "",
        proveedor_id: "",
        orden: "",
        hora: "",
        nombre_servicio: "",
        observacion: "",
        tipo_costo_id: "",
        tipo_habitacion_id: "",
        precio_id: "",
        moneda: "",
        precio_unitario: "",
        cantidad: "",
        capacidad: "",
        subtotal: "",
        estado_activo: "",

    });

    const formFields = {
        cotizacion_id: { type: 'text', placeholder: 'Ingrese el cotizacion', label: 'cotizacion' },
        cotizacion_dia_id: { type: 'text', placeholder: 'Ingrese el cotizacion_dia', label: 'cotizacion_dia' },
        servicio_id: { type: 'text', placeholder: 'Ingrese el servicio', label: 'servicio' },
        proveedor_id: { type: 'text', placeholder: 'Ingrese el proveedor', label: 'proveedor' },
        orden: { type: 'text', placeholder: 'Ingrese el orden', label: 'orden' },
        hora: { type: 'text', placeholder: 'Ingrese la hora', label: 'hora' },
        nombre_servicio: { type: 'text', placeholder: 'Ingrese el nombre_servicio', label: 'nombre_servicio' },
        observacion: { type: 'text', placeholder: 'Ingrese la observacion', label: 'observacion' },
        tipo_costo_id: { type: 'text', placeholder: 'Ingrese el tipo_costo', label: 'tipo_costo' },
        tipo_habitacion_id: { type: 'text', placeholder: 'Ingrese el tipo_habitacion', label: 'tipo_habitacion' },
        precio_id: { type: 'text', placeholder: 'Ingrese el precio', label: 'precio' },
        moneda: { type: 'text', placeholder: 'Ingrese la moneda', label: 'moneda' },
        precio_unitario: { type: 'text', placeholder: 'Ingrese el precio_unitario', label: 'precio_unitario' },
        cantidad: { type: 'text', placeholder: 'Ingrese la cantidad', label: 'cantidad' },
        capacidad: { type: 'text', placeholder: 'Ingrese la capacidad', label: 'capacidad' },
        subtotal: { type: 'text', placeholder: 'Ingrese el subtotal', label: 'subtotal' },   
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
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
  