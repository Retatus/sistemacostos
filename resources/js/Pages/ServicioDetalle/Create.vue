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
        proveedorcategorias: {
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

    const form = useForm({
        descripcion: "",
        proveedor_categoria_id: "1",
        costo_id: "1",
        destino_id: "1",
        distribucion_venta_id: "1",
        estado_activo: "1",
    });

    const formFields = {   
        descripcion: { type: 'text', placeholder: 'Ingrese la descripcion', label: 'descripcion' },
        proveedor_categoria_id: { 
            type: 'select', 
            label: 'Categoria', 
            options: props.proveedorcategorias
        },
        costo_id: { 
            type: 'select', 
            label: 'Costos', 
            options: props.categoriaCostos
        },
        destino_id: { 
            type: 'select', 
            label: 'Destino', 
            options: props.categoriaDestinos
        },
        distribucion_venta_id: { 
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
                  ServicioDetalle
              </h2>   
              <Link :href="route('serviciodetalle')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista ServicioDetalle
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
                        @submit="form.post(route('serviciodetalle.store'))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  