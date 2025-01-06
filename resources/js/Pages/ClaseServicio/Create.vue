<script>
    export default {
        name: 'CategoryCreate'
    }
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import CategoryForm from '@/Components/Categoria/FormCategoria.vue';

const form = useForm({
    nombre: "",
    estado: "1"
});

</script>
            
<template>
    <AppLayout title="Create">
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Crear clase servicio
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
                            <CategoryForm :form="form" @submit="form.post(route('clase_servicio.store'))" :updating="false" :titulo="'Clase Servicio'"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>