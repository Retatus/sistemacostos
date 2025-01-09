<template>
    <Modal :show="isModalVisible" maxWidth="lg" closeable @close="closeModal">
        <template #default>
            <div class="p-1">
                <!-- Header -->
                <div class="px-4 py-3 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">{{ title }}</h2>
                </div>
                <!-- Body -->
                <form @submit.prevent="handleSubmit">
                    <div class="px-4 py-4">
                        <div>
                            <InputLabel :for="inputId" :value="inputLabel" />
                            <TextInput
                                v-model="formData.nombre"
                                :type="inputType"
                                :id="inputId"
                                class="border p-2 w-full mb-2"
                                :placeholder="inputPlaceholder"
                                :required="true"
                                autocomplete="off"
                            />
                            <InputError class="mt-2" :message="errorMessage" />
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-4 py-3 border-t flex justify-end space-x-2">
                        <SecondaryButton @click="closeModal">Cerrar</SecondaryButton>
                        <PrimaryButton type="submit">{{ submitButtonText }}</PrimaryButton>
                    </div>
                </form>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    title: { type: String, default: 'Agregar servicio clase' },
    inputLabel: { type: String, default: 'Nombre' },
    inputPlaceholder: { type: String, default: 'Ingrese un nombre' },
    inputType: { type: String, default: 'text' },
    inputId: { type: String, default: 'nombre' },
    submitButtonText: { type: String, default: 'Agregar' },
    isModalVisible: { type: Boolean, required: true },
    errorMessage: { type: String, default: '' },
    defaultData: { type: Object, default: () => ({ nombre: '' }) },
});

const emit = defineEmits(['close', 'submit']);
const formData = ref({ ...props.defaultData });
const validationError = ref(''); // Para almacenar errores de validación

function resetFormData() {
    formData.value = { ...props.defaultData };
}

function closeModal() {
    resetFormData(); // Limpiar los datos al cerrar el modal
    validationError.value = ''; // Limpiar mensajes de error
    emit('close');
}

async function handleSubmit() {
    try {
        //validationError.value = ''; // Limpiar errores previos
        await emit('submit', formData.value); // Emitir el evento de envío al padre
        //resetFormData(); // Limpiar solo si el envío es exitoso
    } catch (error) {
        if (error.response && error.response.data.message) {
            validationError.value = error.response.data.message; // Mostrar mensaje de error
        } else {
            console.error('Error inesperado:', error);
        }
    }
}
</script>
