<template>
    <Modal :show="isModalVisible" maxWidth="90" closeable @close="closeModal">
        <template #default>
            <div class="p-4">
                <!-- Header -->
                <div class="flex justify-between px-4 py-3 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">{{ Titulo }} </h2>
                    <select v-model="props.SelectValueCategoria" class="mt-1 w-1/2 border-gray-300 rounded-md shadow-sm">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in ProveedorCategoria" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                    <label class="text-lg font-semibold text-gray-700">Detalle {{ Titulo.toLocaleLowerCase() }}</label>
                </div>    
                <!-- Body -->
                <div class="overflow-x-auto p-5 border-b">
                    <div v-for="diaData in data" :key="diaData.dia">
                        <h2>Día {{ diaData.dia }}</h2>
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-900 uppercase bg-gray-50">
                                <tr class="bg-gray-100">
                                <th class="w-1/6 px-4 py-2 text-sm font-medium">Nombre</th>
                                <th class="w-1/6 px-4 py-2 text-sm font-medium">Pasajero</th>
                                <th class="w-3/6 px-4 py-2 text-sm font-medium">Servicio</th>
                                <th class="w-1/6 px-4 py-2 text-sm font-medium">Estatus</th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr v-for="detalle in diaData.detalle" :key="detalle.pasajero.id" className="bg-white border-b text-gray-900">
                                <td class="px-4 py-2 text-sm">
                                    <input v-model="detalle.pasajero.nombre" type="text" required="true"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                </td>
                                    <td class="px-4 py-2 text-sm">
                                        <select v-model="detalle.pasajero.tipo_pasajero_id"
                                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                            <option disabled value="">-- Selecciona una opción --</option>
                                            <option v-for="option in TipoPasajero" :key="option.value"
                                                :value="option.value">
                                                {{ option.label }}
                                            </option>
                                        </select>
                                    </td>
                                <td class="px-4 py-2 text-sm">
                                    <select @change="handleSelectChange($event.target.value)" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option disabled value="">-- Selecciona una opción --</option>
                                        <option v-for="servicio in detalle.pasajeroServicio.filter(s => s.proveedor_categoria_id == SelectValueCategoria)" 
                                                :key="servicio.id" :value="servicio.monto">
                                            {{ servicio.observacion }} - ${{ servicio.monto }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <select v-model="detalle.pasajero.clase_id"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option disabled value="">-- Selecciona una opción --</option>
                                        <option v-for="option in Clase" :key="option.value" :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- Footer -->
                <div class="px-4 py-3 border-t flex justify-end space-x-2">
                    <SecondaryButton @click="closeModal">Cerrar</SecondaryButton>
                    <PrimaryButton type="submit">Agregar</PrimaryButton>
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
    const categoriesStore = useCategoriesStore();

    const props = defineProps({
        Titulo: {
            type: String,
            required: true,
        },
        SelectValueCategoria: {
            type: String,
            required: true,
        },
        isModalVisible: {
            type: Boolean,
            required: true
        },
        Lista_servicio_x_dia: {
            type: Array,
            required: true,
        }
    })

    console.log("objeto pasajero servicio ", props.Lista_servicio_x_dia);

    const data = ref(props.Lista_servicio_x_dia);

    const ProveedorCategoria = ref({ ...categoriesStore.globals.proveedor_categories });
    const TipoDocumento = ref({ ...categoriesStore.globals.tipo_documentos });
    const TipoPasajero = ref({ ...categoriesStore.globals.tipo_pasajeros });
    const TipoClase = ref({ ...categoriesStore.globals.servicio_clases });

    const Clase = ref([
        { value: '1', label: 'PROVISIONAL' },
        { value: '2', label: 'CONFORMADO' },
    ]);

    const emit = defineEmits(['close', 'update']);

    function closeModal() {
        emit('close');
    }

    // Maneja el cambio del select
    const handleSelectChange = (monto) => {
        console.log("Monto seleccionado:", monto);
    };
</script>
