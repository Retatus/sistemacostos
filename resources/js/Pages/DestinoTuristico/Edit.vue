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
        destinoTuristico: {
            type: Object, 
            required: true
        } 
    })
 
    console.log(props);
    const form = useForm({
        nombre: props.destinoTuristico.nombre,
        descripcion: props.destinoTuristico.descripcion,
        pais: props.destinoTuristico.pais,
        dias: props.destinoTuristico.dias,
        costo_total: props.destinoTuristico.costo_total,
        
        margen: props.destinoTuristico.margen,
        ganancia: props.destinoTuristico.ganancia,
        venta: props.destinoTuristico.venta,
        estado_activo: props.destinoTuristico.estado_activo,
    });

    const formFields = {   
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
        descripcion: { type: 'textarea', placeholder: 'Ingrese la descripcion', label: 'descripcion' },
        pais: { type: 'text', placeholder: 'Ingrese el pais', label: 'pais' },
        dias: { type: 'text', placeholder: 'Ingrese los dias', label: 'dias' },
        costo_total: { type: 'text', placeholder: 'Ingrese el costo_total', label: 'costo_total' },
        
        margen: { type: 'text', placeholder: 'Ingrese el margen', label: 'margen' },
        ganancia: { type: 'text', placeholder: 'Ingrese la ganancia', label: 'ganancia' },
        venta: { type: 'text', placeholder: 'Ingrese la venta', label: 'venta' },
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
                  DestinoTuristico
              </h2>   
              <Link :href="route('destino_turistico')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista DestinoTuristico
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
                        @submit="form.patch(route('destino_turistico.update', destinoTuristico))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  