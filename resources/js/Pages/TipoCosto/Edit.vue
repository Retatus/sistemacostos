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
        tipoCosto: {
            type: Object, 
            required: true
        } 
    })
 
    console.log('Props:', props);
    const form = useForm({
        codigo: props.tipoCosto.codigo,
        nombre: props.tipoCosto.nombre,
        estado_activo: props.tipoCosto.estado_activo,
    });

    const formFields = {
        codigo: { type: 'text', placeholder: 'Ingrese el codigo', label: 'codigo' },
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
                  TipoCosto
              </h2>   
              <Link :href="route('tipo_costo')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista TipoCosto
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
                        @submit="form.patch(route('tipo_costo.update', tipoCosto))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  