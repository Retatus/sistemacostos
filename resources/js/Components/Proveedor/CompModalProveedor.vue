<template>
    <Modal :show="isModalVisibleProveedor" maxWidth="2xl" closeable @close="closeModal">
        <template #default>
            <div class="p-1">
                <!-- Header -->
                <div class="px-4 py-3 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">Agregar persona</h2>
                </div>
                <!-- Body -->
                <form @submit.prevent="addCliente">
                    <div class="grid grid-cols-6 gap-6 w-full p-5">
                        <div class="col-span-3">
                            <label for="tipo_documento" class=" text-sm font-medium text-gray-700">Tipo Documento</label>                            
                            <select v-model="personas.tipo_documento_id" id="tipo_documento"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm">
                                <option disabled value="">-- Selecciona una opción --</option>
                                <option v-for="option in TipoDocumento" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>                   
                        <div class="col-span-3 ">
                            <label for="ruc" class=" text-sm font-medium text-gray-700">Numero</label>
                            <div class="flex items-center space-x-2">
                                <input v-model="personas.ruc" type="text" id="ruc"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el numero">
                                <PrimaryButton type="button"
                                    class="mt-1">
                                    Buscar
                                </PrimaryButton>
                            </div>
                        </div>
                        <div class="col-span-6">
                            <label for="razon_social" class=" text-sm font-medium text-gray-700">Razon social</label>
                            <input v-model="personas.razon_social" type="text" id="razon_social"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el razon social">
                        </div>
                        <div class="col-span-6">
                            <label for="direccion" class=" text-sm font-medium text-gray-700">Direccion</label>
                            <input v-model="personas.direccion" type="text" id="direccion"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el direccion">
                        </div>
                        <div class="col-span-2">
                            <label for="tipo_sunat" class=" text-sm font-medium text-gray-700">Tipo Sunat</label>
                            <select v-model="personas.tipo_sunat" id="tipo_sunat" 
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option disabled value="">-- Selecciona una opción --</option>
                                <option v-for="option in tiposSunat" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select> 
                        </div>
                        <div class="col-span-2">
                            <label for="contacto" class=" text-sm font-medium text-gray-700">Contacto</label>
                            <input v-model="personas.contacto" type="text" id="contacto"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el contacto">
                        </div>
                        <div class="col-span-2">
                            <label for="correo" class=" text-sm font-medium text-gray-700">Correo</label>
                            <input v-model="personas.correo" type="email" id="correo"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el correo">
                        </div>
                    </div>                    
                    <!-- Footer -->
                    <div class="px-4 py-3 border-t flex justify-end space-x-2">
                        <SecondaryButton @click="closeModal">Cerrar</SecondaryButton>
                        <PrimaryButton type="submit">Agregar</PrimaryButton>
                    </div>
                </form>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { useCategoriesStore } from '@/Stores/categories';
const categoriesStore = useCategoriesStore();

const props = defineProps({
    isModalVisibleProveedor: { 
        type: Boolean, 
        required: true 
    },
})

// Variables para el personas y detalle temporal
const personas = ref({
    ruc: '',
    razon_social: '',
    contacto: '',
    correo: '',
    direccion: '',
    tipo_documento_id: '',
    tipo_comprobante: 1,//otros
    tipo_sunat: 1,
    proveedor_categoria_id: 0,//cliente
    escliente: 1,
    estado_activo: 1,
});

const TipoDocumento = ref({ ...categoriesStore.globals.tipo_documentos });
const tiposSunat = ref({ ...categoriesStore.globals.tipo_sunat });
const emit = defineEmits(['close', 'submit']);

function closeModal() {
    emit('close');
}

const Cliente = ref({
    id: '',
    nombre: '',
});
async function addCliente() {
    try {
        const response = await axios.post(`${route('proveedor.store')}`, personas.value);  
        if (response.status === 201) { 
            Cliente.value.id = response.data.data.id;
            Cliente.value.nombre = response.data.data.razon_social;  
            emit('submit', Cliente.value);
            //props.isModalVisibleProveedor = false;
            // Swal.fire({
            //     title: 'Registro exitoso',
            //     html: `Este elemento <strong>${personas.value.razon_social}</strong> agregado correctamente.`,
            //     icon: 'success',
            //     timer: 2000,
            //     showConfirmButton: false,
            // });             
        }else{
            //console.error('Error al agregar el elemento:', error);
            alert('Error al agregar el elemento:', response.data);
        }

    } catch (err) {
        error.value = err.response?.data?.message || 'Ocurrió un error';
    }
}
</script>
