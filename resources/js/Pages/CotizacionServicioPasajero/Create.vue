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
        cotizacion_servicio_id: "",
        pasajero_id: "",
        precio: "",
        cantidad: "",
        descuento: "",
        total: "",
        estado_activo: "",
    });

    const formFields = {
        cotizacion_servicio_id: { type: 'text', placeholder: 'Ingrese el cotizacion_servicio', label: 'cotizacion_servicio' },
        pasajero_id: { type: 'text', placeholder: 'Ingrese el pasajero', label: 'pasajero' },
        precio: { type: 'text', placeholder: 'Ingrese el precio', label: 'precio' },
        cantidad: { type: 'text', placeholder: 'Ingrese la cantidad', label: 'cantidad' },
        descuento: { type: 'text', placeholder: 'Ingrese el descuento', label: 'descuento' },
        total: { type: 'text', placeholder: 'Ingrese el total', label: 'total' },
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
                  CotizacionServicioPasajero
              </h2>   
              <Link :href="route('cotizacion_servicio_pasajero')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista CotizacionServicioPasajero
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
                        @submit="form.post(route('cotizacion_servicio_pasajero.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  