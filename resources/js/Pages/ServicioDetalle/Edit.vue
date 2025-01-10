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
        servicioDetalle: {
            type: Object, 
            required: true
        },
        categoriaCostos: {
            type: Object, 
            required: true
        },
        categoriaDestinos: {
            type: Object, 
            required: true
        } ,
        categoriaDistribuciones: {
            type: Object, 
            required: true
        } 
    })
 
    console.log(props);
    const form = useForm({
        descripcion: props.servicioDetalle.descripcion,
        costo: props.servicioDetalle.costo,
        destino: props.servicioDetalle.destino,
        distribucion: props.servicioDetalle.distribucion,
        estado_activo: props.servicioDetalle.estado_activo,
    });

    const formFields = {   
        descripcion: { type: 'text', placeholder: 'Ingrese la descripcion', label: 'descripcion' },
        costo: { 
            type: 'select', 
            label: 'Costos', 
            options: props.categoriaCostos
        },
        destino: { 
            type: 'select', 
            label: 'Destino', 
            options: props.categoriaDestinos
        },
        distribucion: { 
            type: 'select', 
            label: 'Distribucion', 
            options: props.categoriaDistribuciones
        }        
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Servicio detalle
              </h2>   
              <Link :href="route('servicio_detalle')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Servicio detalle
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
                        @submit="form.patch(route('servicio_detalle.update', servicioDetalle))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  