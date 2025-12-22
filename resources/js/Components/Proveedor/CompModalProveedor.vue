<template>
    <Modal :show="isModalVisibleProveedor" maxWidth="2xl" closeable @close="closeModal">
        <template #default>
            <div class="p-1">
                <!-- Header -->
                <div class="px-4 py-3 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">Agregar cliente</h2>
                </div>
                <!-- Body -->
                 <div class="overflow-x-auto py-0">
                    <div class="text-center">
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0">
                            <p  v-if="responseMessage"
                                class="text-sm text-red-600">
                                {{ responseMessage }}
                            </p>
                        </Transition>
                    </div>                    
                    <form @submit.prevent="addCliente">
                        <div class="grid grid-cols-6 gap-4 w-full p-5">
                            <div class="col-span-3">
                                <label for="tipo_documento" class=" text-xs font-medium text-gray-700">Tipo Documento</label>                            
                                <select v-model="personas.tipo_documento_id" id="tipo_documento"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs">
                                    <option disabled value="">-- Selecciona una opción --</option>
                                    <option v-for="option in TipoDocumento" :key="option.value" :value="option.value">
                                        {{ option.label }}
                                    </option>
                                </select>
                            </div>                   
                            <div class="col-span-3 ">
                                <label for="ruc" class=" text-xs font-medium text-gray-700">Numero</label>
                                <div class="flex items-center space-x-2">
                                    <input v-model="personas.ruc" type="text" id="ruc"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs" placeholder="Ingrese el numero">
                                    <PrimaryButton type="button"
                                        @click="findCliente"
                                        class="mt-1">
                                        Buscar
                                    </PrimaryButton>
                                </div>
                            </div>
                            <div class="col-span-6">
                                <label for="razon_social" class=" text-xs font-medium text-gray-700">Razon social</label>
                                <input v-model="personas.razon_social" type="text" id="razon_social"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs" placeholder="Ingrese el razon social">
                            </div>
                            <div class="col-span-6">
                                <label for="direccion" class=" text-xs font-medium text-gray-700">Direccion</label>
                                <input v-model="personas.direccion" type="text" id="direccion"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs" placeholder="Ingrese el direccion">
                            </div>
                            <div class="col-span-2">
                                <label for="tipo_sunat" class=" text-xs font-medium text-gray-700">Tipo Sunat</label>
                                <select v-model="personas.tipo_sunat" id="tipo_sunat" 
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs">
                                    <option disabled value="">-- Selecciona una opción --</option>
                                    <option v-for="option in tiposSunat" :key="option.value" :value="option.value">
                                        {{ option.label }}
                                    </option>
                                </select> 
                            </div>
                            <div class="col-span-2">
                                <label for="contacto" class=" text-xs font-medium text-gray-700">Contacto</label>
                                <input v-model="personas.contacto" type="text" id="contacto"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs" placeholder="Ingrese el contacto">
                            </div>
                            <div class="col-span-2">
                                <label for="correo" class=" text-xs font-medium text-gray-700">Correo</label>
                                <input v-model="personas.correo" type="email" id="correo"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs" placeholder="Ingrese el correo">
                            </div>
                        </div>                    
                        <!-- Footer -->
                        <div class="px-4 py-3 border-t flex justify-end space-x-2">
                            <SecondaryButton @click="closeModal">Cerrar</SecondaryButton>
                            <PrimaryButton type="submit">Agregar</PrimaryButton>
                        </div>
                    </form>
                 </div>                
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
import Swal from 'sweetalert2';
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
    editado: 0,
    estado_activo: 1,
});

const error = ref('');
const TipoDocumento = ref({ ...categoriesStore.globals.tipo_documentos });
const tiposSunat = ref({ ...categoriesStore.globals.tipo_sunat });
const emit = defineEmits(['close', 'submit']);

function closeModal() {
    emit('submit', personas.value);
    emit('close');
}
async function addCliente() {
    try {
        const response = await axios.post(`${route('proveedor.store')}`, personas.value);  
        if (response.status === 201) { 
            personas.value = response.data.data;
            emit('submit', personas.value);
        }else{
            //console.error('Error al agregar el elemento:', error);
            alert('Error al agregar el elemento:', response.data);
        }
    } catch (err) {
        console.log('Error al agregar el elemento:', err);
        if (err.response.status === 422) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `<strong>${err.response.data.message}</strong>`,
                confirmButtonText: 'Aceptar',
            });
            emit('submit', personas.value);
        } else {
            error.value = err.response?.data?.message || 'Ocurrió un error';
        }
    }
}

const responseMessage = ref('');
async function findCliente() {
    try {
        const response = await axios.post(`${route('proveedor.find')}`, personas.value);
        if (response.status === 200 && Object.keys(response.data).length > 0) {
            personas.value = response.data;
            responseMessage.value = '';
        }else{
            responseMessage.value = 'Cliente no encontrado';
            personas.value.razon_social = '';
            personas.value.direccion = '';
            personas.value.contacto = '';
            personas.value.correo = '';
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Ocurrió un error';
    }
}

async function findPasajero() {
    try {
        const response = await axios.post(`${route('pasajero.find')}`, personas.value);
        if (response.status === 200) {
            personas.value = response.data;
        }else{
            alert('Error al agregar el elemento:', response.data);
        }
    } catch (err) {
        error.value = err.response?.data?.message || 'Ocurrió un error';
    }
}


</script>
