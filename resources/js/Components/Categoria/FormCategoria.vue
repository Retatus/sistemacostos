<script>
export default {
    name: 'CategoriesForm'
}
</script>

<script setup>
    import FormSection from '../FormSection.vue';
    import InputError from '../InputError.vue';
    import InputLabel from '../InputLabel.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import TextInput from '../TextInput.vue';

    defineProps({
        form: {
            type: Object,
            required: true
        },
        updating: {
            type: Boolean,
            required: true,
            default: false
        }
     });
     // Comunicacion vertical descendente agregar o editar a traves de las props
     defineEmits(['submit']);
</script>
<template>
    <!-- Comunicacion vertical ascedente agregar o editar-->
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{updating ? 'Actualizar categoria proveedores' : 'Crear categoria proveedor'}}
        </template>
        <template #description>
            {{updating ? 'Actualiza la seccion de la categoria proveedor' : 'Crear la seccion de la categoria proveedor'}}
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="nombre" value="Nombre"/>
                <TextInput 
                    id="nombre"
                    type="text" 
                    class="mt-1 block w-full"  
                    v-model="form.nombre"                 
                    required 
                    autofocus 
                    autocomplete="nombre"
                />
                <InputError class="mt-2" :message="$page.props.errors.nombre" />
            </div>
            <div>
                <InputLabel for="estado" value="Estado" />
                <select v-model="form.estado" id="estado" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option value="1">Activo</option>
                    <option value="0">Desactivo</option>
                </select>
                <InputError class="mt-2" :message="form.errors.estado   " />                            
            </div>
        </template>
        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{updating ? 'Actualizar' : 'Crear'}}
            </PrimaryButton>
        </template>
    </FormSection>
</template>