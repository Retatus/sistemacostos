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
        servicioClase: {
            type: Object, 
            required: true
        } 
    })
 
    console.log(props);
    const form = useForm({
        nombre: props.servicioClase.nombre,
        estado_activo: props.servicioClase.estado_activo,
    });

    const formFields = {
        nombre: { type: 'text', placeholder: 'Ingrese el nombre', label: 'nombre' },
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
                  Destino
              </h2>   
              <Link :href="route('servicio_clase')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Destino
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <!-- :form="form"                                           comunicacion vertical descendente a traves de las props -->
                    <!-- @submit="form.post(route('categoria_proveedor.store')) comunicacion horizontal ascendente -->
                    <FormularioDinamico
                        :form="form"
                        :fields="formFields"                            
                        :updating="true"
                        @submit="form.patch(route('servicio_clase.update', servicioClase))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  