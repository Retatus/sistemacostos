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
        proveedor: {
            type: Object, 
            required: true
        },
        proveedorcategorias: {
            type: Object, 
            required: true
        } 
    })

    const form = useForm({
        ruc: props.proveedor.ruc,
        razon_social: props.proveedor.razon_social,
        direccion: props.proveedor.direccion,
        tipo_comprobante: props.proveedor.tipo_comprobante,
        correo: props.proveedor.correo,
        tipo_sunat: props.proveedor.tipo_sunat,
        contacto: props.proveedor.contacto,
        estado_activo: props.proveedor.estado_activo,
        proveedor_categoria_id: props.proveedor.proveedor_categoria_id
    });

    const formFields = {            
        ruc: { type: 'text', placeholder: 'Ingrese el ruc', label: 'ruc' },
        razon_social: { type: 'text', placeholder: 'Ingrese el razon_social', label: 'razon_social' },
        direccion: { type: 'text', placeholder: 'Ingrese el direccion', label: 'direccion' },
        tipo_comprobante: { type: 'text', placeholder: 'Ingrese el tipo_comprobante', label: 'tipo_comprobante' },
        correo: { type: 'text', placeholder: 'Ingrese el correo', label: 'correo' },
        tipo_sunat: { type: 'text', placeholder: 'Ingrese el tipo_sunat', label: 'tipo_sunat' },
        contacto: { type: 'text', placeholder: 'Ingrese el contacto', label: 'contacto' },
        estado_activo: { 
        type: 'select', 
            options: [
                { value: '1', label: 'Activo' }, 
                { value: '0', label: 'Desactivo' }
            ], 
            label: 'Estado' 
        },
        proveedor_categoria_id: { 
            type: 'select', 
            label: 'Categoría', 
            options: props.proveedorcategorias
        }
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Proveedor
              </h2>   
              <Link :href="route('proveedor')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Proveedor
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
                        @submit="form.patch(route('proveedor.update', proveedor))" 
                    />
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  