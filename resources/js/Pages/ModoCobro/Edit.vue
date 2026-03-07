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
        modoCobro: {
            type: Object, 
            required: true
        } 
    })
 
    console.log('modoCobro:', props.modoCobro);
    const form = useForm({
        codigo: props.modoCobro.codigo,
        nombre: props.modoCobro.nombre,
        requiere_cantidad: props.modoCobro.requiere_cantidad,
        requiere_habitacion: props.modoCobro.requiere_habitacion,
        estado_activo: props.modoCobro.estado_activo,
    });

    const formFields = {
        codigo: { type: 'text', placeholder: 'Ingrese el codigo', label: 'codigo' },
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
        requiere_cantidad: { type: 'text', placeholder: 'Ingrese la cantidad requerida', label: 'Requiere Cantidad' },
        requiere_habitacion: { type: 'text', placeholder: 'Ingrese la habitacion requerida', label: 'Requiere Habitacion' },
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
                  ModoCobro
              </h2>   
              <Link :href="route('modo_cobro')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista ModoCobro
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
                        @submit="form.patch(route('modo_cobro.update', modoCobro))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  