<template>
    <Modal :show="isModalVisible" maxWidth="90" closeable @close="closeModal">
        <template #default>
            <div class="p-4">
                <!-- Header -->
                <div class="px-4 py-3 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">Detalle pasajeros</h2>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto p-5 border-b">
                    <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead className="text-xs text-gray-900 uppercase bg-gray-50">
                            <tr class="bg-gray-100">
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Nombre</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">apellido_paterno</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">apellido_materno</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Tipo Doc</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Nro Doc</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Pais</th>
                                <th class="w-3/12 px-4 py-2 text-sm font-medium">Adjunto</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Tipo Pax</th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Clase </th>
                                <th class="w-1/12 px-4 py-2 text-sm font-medium">Acciones </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in ListaPasajeros" :key="index"
                                className="bg-white border-b text-gray-900">
                                <td class="px-4 py-2 text-sm">
                                    <input v-model="item.nombre" type="text" required="true"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <input v-model="item.apellido_paterno" type="text" required="true"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <input v-model="item.apellido_materno" type="text" required="true"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <select v-model="item.documento_tipo_id"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option disabled value="">-- Selecciona una opción --</option>
                                        <option v-for="option in TipoDocumento" :key="option.value"
                                            :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <input v-model="item.documento_numero" type="text" required="true"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <select v-model="item.pais_id"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option disabled value="">-- Selecciona una opción --</option>
                                        <option v-for="option in Pais" :key="option.value" :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <input type="file" hidden :id="'fileInput-' + index" @change="handleFileChange($event, index)" />
                                    <!-- Botón personalizado -->
                                    <div class="flex items-center space-x-2">
                                        <input v-model="item.documento_file" type="text" required="true"
                                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                        <label :for="'fileInput-' + index" class="custom-file-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                            </svg>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <select v-model="item.tipo_pasajero_id"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option disabled value="">-- Selecciona una opción --</option>
                                        <option v-for="option in TipoPax" :key="option.value" :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <select v-model="item.clase_id"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option disabled value="">-- Selecciona una opción --</option>
                                        <option v-for="option in Clase" :key="option.value" :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-sm hover:text-red-700 text-center">
                                    <button type="button" @click="removeItem(index)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Footer -->
                <div class="px-4">
                    <div class="grid grid-cols-4 gap-4 w-full p-5">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Numero de pasajeros</label> 
                            <input type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" :value='ListaPasajeros.length'/>  
                        </div>
                        <div class="col-span-1">
                            <label for = "adjuntoGeneral" class="block text-sm font-medium text-gray-700">Adjunto Doc.</label>    
                            <input type="file" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="adjuntoGeneral"/> 
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Documentacion</label> 
                            <select class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <!-- <option disabled value="">-- Selecciona una opción --</option> -->
                                <option v-for="option in EstadoDocumentacion" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select> 
                        </div>  
                        <div class="col-span-1 text-right">
                            <label for = "adjuntoGeneral" class="block text-sm font-medium text-gray-700">&nbsp;</label>  
                            <PrimaryButton @click="closeModal" type="button" class="mt-3">
                                Cerrar
                            </PrimaryButton>
                        </div>                           
                    </div> 
                </div>
            </div>
        </template>
    </Modal>
</template>

<script setup>
    import { ref, defineProps, defineEmits } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import Modal from '@/Components/Modal.vue';

    const props = defineProps({
        ListaTipoDocumento: {
            type: Object,
            required: true,
        },
        ListaPais: {
            type: Object,
            required: true,
        },
        ListaTipoPax: {
            type: Object,
            required: true,
        },
        ListaClase: {
            type: Object,
            required: true,
        },
        isModalVisible: {
            type: Boolean,
            required: true
        },
        ListaPasajeros: {
            type: Array,
            required: true
        },
    })

    const TipoDocumento = ref({ ...props.ListaTipoDocumento });
    const Pais = ref({ ...props.ListaPais });
    const TipoPax = ref({ ...props.ListaTipoPax });
    const Clase = ref({ ...props.ListaClase });

    const EstadoDocumentacion = ref([
        { value: '1', label: 'PEND' },
        { value: '2', label: 'OK' },
        { value: '3', label: 'OBS' },
    ]);

    const emit = defineEmits(['close', 'update']);

    const handleFileChange = (event, index) => {
        props.ListaPasajeros[index].documento_file = event.target.files[0].name;
    };

    function closeModal() {
        emit('close');
    }

    const removeItem = (index) => {
        props.ListaPasajeros.splice(index, 1);
        emit('update', props.ListaPasajeros);
    }
</script>
