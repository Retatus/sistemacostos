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
        nombre: "",
        apellido_paterno: "",
        apellido_materno: "",
        documento_tipo_id: "",
        documento_numero: "",
        pais_id: "",
        documento_file: "",
        tipo_pasajero_id: "",
        clase_id: "",
        cotizacion_id: "",
        estado_activo: "1",

    });

    const formFields = {   
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
        apellido_paterno: { type: 'text', placeholder: 'Ingrese la apellido paterno', label: 'apellido paterno' },
        apellido_materno: { type: 'text', placeholder: 'Ingrese la apellido materno', label: 'apellido materno' },
        documento_tipo_id: { type: 'select', options: [], label: 'Tipo documento' },
        documento_numero: { type: 'text', placeholder: 'Ingrese el documento numero', label: 'documento numero' },
        pais_id: { type: 'select', options: [], label: 'Pais' },
        documento_file: { type: 'file', label: 'Documento' },
        tipo_pasajero_id: { type: 'select', options: [], label: 'Tipo pasajero' },
        clase_id: { type: 'select', options: [], label: 'Clase' },
        cotizacion_id: { type: 'select', options: [], label: 'Cotizacion' },
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
                  Pasajero
              </h2>   
              <Link :href="route('pasajero')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Pasajero
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
                        @submit="form.post(route('pasajero.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  