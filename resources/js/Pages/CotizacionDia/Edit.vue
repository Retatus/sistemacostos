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
        cotizaciondias: {
            type: Object, 
            required: true
        } 
    })
 
    console.log(props);
    const form = useForm({
        cotizacion_id: props.cotizaciondias.cotizacion_id,
        dia: props.cotizaciondias.dia,
        nombre: props.cotizaciondias.nombre,
        descripcion: props.cotizaciondias.descripcion,
        estado_activo: props.cotizaciondias.estado_activo,
    });

    const formFields = {   
        cotizacion_id: { type: 'text', placeholder: 'Ingrese el cotizacion', label: 'cotizacion' },
        dia: { type: 'text', placeholder: 'Ingrese el dia', label: 'dia' },
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
        descripcion: { type: 'text', placeholder: 'Ingrese la descripcion', label: 'descripcion' },
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
                  CotizacionDias
              </h2>   
              <Link :href="route('cotizacion_dia')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista CotizacionDias
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
                        @submit="form.patch(route('cotizacion_dia.update', cotizaciondias))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  