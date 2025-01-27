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
        descripcion: "",
        pais: "",
        dias: "",
        costo_total: "",
        descuento_tipo: "0",
        descuento_estudiante: "",
        descuento_ninio: "",
        descuento_otros: "",
        margen: "",
        venta: "",
        estado_activo: "1",
    });

    const formFields = {   
        nombre: { type: 'text', placeholder: 'Ingrese la nombre', label: 'nombre' },
        descripcion: { type: 'textarea', placeholder: 'Ingrese la descripcion', label: 'descripcion' },
        pais: { type: 'text', placeholder: 'Ingrese el pais', label: 'pais' },
        dias: { type: 'text', placeholder: 'Ingrese los dias', label: 'dias' },
        costo_total: { type: 'text', placeholder: 'Ingrese el costo_total', label: 'costo_total' },
        descuento_tipo: { 
            type: 'select', 
            options: [
                { value: '1', label: '%' }, 
                { value: '0', label: 'MONTO' }
            ], 
            label: 'Tipo descuento' 
         },
        descuento_estudiante: { type: 'text', placeholder: 'Ingrese el descuento_estudiante', label: 'descuento_estudiante' },
        descuento_ninio: { type: 'text', placeholder: 'Ingrese el descuento_ninio', label: 'descuento_ninio' },
        descuento_otros: { type: 'text', placeholder: 'Ingrese el descuento_otros', label: 'descuento_otros' },
        margen: { type: 'text', placeholder: 'Ingrese el margen', label: 'margen' },
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
                        :updating="false"
                        @submit="form.post(route('destino_turistico.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  