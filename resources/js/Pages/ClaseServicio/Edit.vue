<script>
    export default {
        name: 'CategoryEdit'
    }
</script>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Link, useForm } from '@inertiajs/vue3';
    import CategoryForm from '@/Components/Categoria/FormCategoria.vue';

    const props = defineProps({
        claseServicio: {
            type: Object, 
            required: true
        } 
    })

    const form = useForm({
        nombre: props.claseServicio.nombre,
        estado: props.claseServicio.estado
    });

</script>
            
<template>
    <AppLayout title="Create">
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Editar clase servicio
                </h2>   
                <Link :href="route('clase_servicio')">
                    Lista de clase servicio
                </Link>      
            </div>      
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- :form="form"                                           comunicacion vertical descendente a traves de las props -->
                            <!-- @submit="form.post(route('categoria_proveedor.store')) comunicacion horizontal ascendente -->
                            <CategoryForm :updating="true" :titulo="'Clase Servicio'" :form="form" @submit="form.patch(route('clase_servicio.update', claseServicio))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>