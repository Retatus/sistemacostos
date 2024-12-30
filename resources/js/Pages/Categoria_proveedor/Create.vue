<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const initialValues = {
    nombre: "",
    estado: "1"
}

const form = useForm(initialValues);

const fnSubmit = () => {
    form.post(route('categoria_proveedor.store'))
}

</script>

<template>
    <AppLayout title="Create">
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Crear categoria proveedor
                </h2>   
                <Link :href="route('categoria_proveedor')">
                    Lista de categoria proveedor
                </Link>      
            </div>      
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form class="py-5 space-y-3 w-1/3" @submit.prevent ="fnSubmit">
                        <div>
                            <InputLabel for="nombre" value="Clase servicio" />
                            <TextInput
                                id="nombre"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nombre"
                                required
                                autofocus
                                autocomplete="nombre"
                            />
                            <InputError class="mt-2" :message="form.errors.nombre   " />                            
                        </div>
                        <div>
                            <InputLabel for="estado" value="Estado" />
                            <select v-model="form.estado" id="estado" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1">Activo</option>
                                <option value="0">Desactivo</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.estado   " />                            
                        </div>
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Crear categoria proveedor
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>