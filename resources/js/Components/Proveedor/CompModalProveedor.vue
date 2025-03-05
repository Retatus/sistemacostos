<template>
    <Modal :show="isModalVisible" maxWidth="70" closeable @close="closeModal">
        <template #default>
            <div class="p-1">
                <!-- Header -->
                <div class="px-4 py-3 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">Agregar persona</h2>
                </div>
                <!-- Body -->
                <form @submit.prevent="addCliente">
                    <div class="grid grid-cols-5 gap-4 w-full p-5">
                        <!-- Primera fila -->
                        <div class="col-span-2">
                            <label for="tipo_documento" class=" text-sm font-medium text-gray-700">Tipo Documento</label>                            
                            <select v-model="personas.tipo_documento_id" id="tipo_documento"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm">
                                <option disabled value="">-- Selecciona una opción --</option>
                                <option v-for="option in TipoDocumento" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="ruc" class=" text-sm font-medium text-gray-700">Numero</label>
                            <input v-model="personas.ruc" type="text" id="ruc"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el numero">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                            <PrimaryButtonBuscar type="button"
                                class="mt-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"> 
                                Buscar
                            </PrimaryButtonBuscar>
                        </div>                                               
                    </div>
                    <div class="grid grid-cols-1 gap-4 w-full p-5">
                        <!-- Primera fila -->
                        <div class="col-span-1 ">
                            <label for="razon_social" class=" text-sm font-medium text-gray-700">Razon social</label>
                            <input v-model="personas.razon_social" type="text" id="razon_social"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el razon social">
                        </div>
                        <div class="col-span-1 ">
                            <label for="direccion" class=" text-sm font-medium text-gray-700">Direccion</label>
                            <input v-model="personas.direccion" type="text" id="direccion"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el direccion">
                        </div>
                    </div> 
                    <div class="grid grid-cols-3 gap-4 w-full p-5">
                        <div class="col-span-1">
                            <label for="tipo_sunat" class=" text-sm font-medium text-gray-700">Tipo Sunat</label>
                            <select v-model="personas.tipo_sunat" id="tipo_sunat" 
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option disabled value="">-- Selecciona una opción --</option>
                                <option v-for="option in tiposSunat" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select> 
                        </div>
                        <div class="col-span-1 ">
                            <label for="contacto" class=" text-sm font-medium text-gray-700">Contacto</label>
                            <input v-model="personas.contacto" type="text" id="contacto"
                                class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el contacto">
                        </div>
                        <div class="col-span-1 ">
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
import PrimaryButtonBuscar from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    ListaTipoDocumento: { 
        type: Object,
        required: true, 
    },
    ListaTipoSunat: { 
        type: Object,
        required: true, 
    },
    isModalVisible: { 
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
    proveedor_categoria_id: 11,//cliente
    estado_activo: 1,
});

const TipoDocumento = ref({ ...props.ListaTipoDocumento });
const tiposSunat = ref({ ...props.ListaTipoSunat });
const emit = defineEmits(['close', 'submit']);

function closeModal() {
    // resetFormData(); // Limpiar los datos al cerrar el modal
    // validationError.value = ''; // Limpiar mensajes de error
    emit('close');
}

async function addCliente() {
    try {
        const response = await axios.post(`${route('proveedor.store')}`, personas.value);  
        debugger;  
        console.log('Elemento agregado:', response.data);            
        if (response.status === 201) {        
            props.isModalVisible = false;
            // Swal.fire({
            //     title: 'Registro exitoso',
            //     html: `Este elemento <strong>${personas.value.razon_social}</strong> agregado correctamente.`,
            //     icon: 'success',
            //     timer: 2000,
            //     showConfirmButton: false,
            // }); 
            emit('submit', response.data);
        }else{
            //console.error('Error al agregar el elemento:', error);
            alert('Error al agregar el elemento:', response.data);
        }

    } catch (err) {
        error.value = err.response?.data?.message || 'Ocurrió un error';
    }
}


</script>
