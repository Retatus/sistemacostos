<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const page = usePage();
const CategoriaProveedor = page.props.categoria_proveedor;

const initialValues = {
    nombre: CategoriaProveedor.nombre,
    estado: CategoriaProveedor.estado
}

const form = useForm(initialValues);

const fnSubmit = () => {
    form.patch(route('categoria_proveedor.update', CategoriaProveedor))
    //console.log('envio el dato');
}
</script>

<template>
    <AppLayout title="Create">
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Editar categoria
                </h2>   
                <Link :href="route('categoria_proveedor')">
                    Lista de categoria
                </Link>      
            </div>  
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <!-- @submit.prevent EVITA QUE LA PAGINA SE RECARGUE -->
                    <form class="py-5 space-y-3 w-1/3" @submit.prevent ="fnSubmit">
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0">
                            <p  v-if="form.recentlySuccessful"
                                class="text-sm text-green-600">
                                Actualizado correctamente.
                            </p>
                        </Transition>
                        <div>
                            <InputLabel for="nombre" value="Categoria" />
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
                            <select v-model="form.estado" name="estado" id="estado" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1">Activo</option>
                                <option value="0">Desactivo</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.estado   " />                            
                        </div>
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Editar categoria proveedor
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>