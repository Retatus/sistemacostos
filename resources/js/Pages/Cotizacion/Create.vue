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
        proveedor_id: "",
        file_nro: "",
        file_nombre: "",
        comprobante_id: "",
        fecha: "",
        nro_pasajeros: "",
        nro_ninio: "",
        nro_adulto: "",
        nro_estudiante: "",
        idioma: "",
        mercado: "",
        destino_turistico_id: "",
        pais_id: "",
        fecha_inicio: "",
        fecha_fin: "",
        nro_dias: "",
        estado_cotizacion: "",
        costo_parcial: "",
        descuento_estudiante: "",
        descuento_ninio: "",
        descuento_otro: "",
        costo_total: "",
        estado_activo: "",

    });

    const formFields = {   
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
                  Cotizacion
              </h2>   
              <Link :href="route('cotizacion')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Cotizacion
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
                        @submit="form.post(route('cotizacion.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  