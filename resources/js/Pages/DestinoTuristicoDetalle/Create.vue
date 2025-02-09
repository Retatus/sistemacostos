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
        destinoturisticoslista: {
            type: Object, 
            required: true
        } 
    })

    console.log(props);

    const form = useForm({
        nro_dia: "",
        nombre: "" ,
        descripcion: "",
        estado_activo: "",
        destino_turistico_id: "",
    });

    const formFields = {   
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
        descripcion: { type: 'textarea', placeholder: 'Ingrese la descripcion', label: 'descripcion' }, 
        nro_dia: { type: 'text', placeholder: 'Ingrese el nro_dia', label: 'nro_dia' },
        
        destino_turistico_id: { 
            type: 'select', 
            label: 'Destino Turistico',
            options: props.destinoturisticoslista
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
                  DestinoTuristicoDetalle
              </h2>   
              <Link :href="route('destino_turistico_detalle')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista DestinoTuristicoDetalle
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
                        @submit="form.post(route('destino_turistico_detalle.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  