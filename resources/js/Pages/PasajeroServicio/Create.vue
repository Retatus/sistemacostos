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
        ListaPasajero: {
            type: Object, 
            required: true
        },
        ListaItinerarioServicio: {
            type: Object, 
            required: true
        }
    })

    const form = useForm({
        pasajero_id: "",
        itinerario_servicio_id: "",
        estado_activo: 1,
    });

    const formFields = {
        pasajero_id: { 
            type: 'select', 
            label: 'Pasajero', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... props.ListaPasajero
            ]
        },
        itinerario_servicio_id: { 
            type: 'select', 
            label: 'Itinearario Servicio', 
            options: [
                { value: '', label: '--Seleccionar--' },
                ... props.ListaItinerarioServicio
            ]
        },
        estado_activo: { 
            type: 'select', 
            options: [
                { value: '1', label: 'Activo' }, 
                { value: '0', label: 'Desactivo' }
            ], 
            label: 'Estado activo' 
        },
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  PasajeroServicio
              </h2>   
              <Link :href="route('pasajero_servicio')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista PasajeroServicio
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
                        @submit="form.post(route('pasajero_servicio.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  