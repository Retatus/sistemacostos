<template>
  <div class="overflow-x-auto py-0 px-5">
      <table className="excel-table w-full text-xs text-left rtl:text-right text-gray-500">
        <thead className="text-xs text-gray-900 uppercase bg-gray-50">
        <tr class="bg-gray-100">
          <th class="w-1/12 px-4 py-2">Nro dias</th>
          <th class="w-3/12 px-4 py-2">Nombre</th>
          <th class="w-5/12 px-4 py-2">Descripcion</th>
          <th class="w-1/12 px-4 py-2">Observacion</th>
          <th class="w-1/12 px-4 py-2">Servicio</th>
          <th class="w-1/12 px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in Lista_destino_turistico_detalle" :key="index"
          className="bg-white border-b text-gray-900">
          <td class="px-1 ">
            <label class="mx-2 block text-xs font-medium text-gray-700">Dia {{ index + 1 }}:</label>
          </td>
          <td class="px-1">
            <select v-model="item.itinerario_id" @change="ItinerarioDescripcion(index)" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
              <option disabled value="">-- Selecciona una opción --</option>
              <option v-for="option in Lista_itinerarios" :key="option.value" :value="option.value" :data-info="option.descripcion">
                {{ option.label }}
              </option>
            </select>
          </td>
          <td class="px-1">
            <textarea v-model="item.descripcion" name="descripcion" rows="2" class="w-full border-gray-300 rounded-md shadow-sm text-xs"></textarea>
          </td>
          <td class="px-1 text-center hover:text-green-700">
            <textarea v-model="item.observacion" name="observacion" rows="2" class="w-full border-gray-300 rounded-md shadow-sm text-xs"></textarea>
          </td>
          <td class="px-1 text-center hover:text-green-700">
            <button type="button" @click="showModal(index)">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
              </svg>
            </button>
            {{ item.destino_turistico_detalle_servicio.length }}
          </td>
          <td hidden class="px-1">
            <input v-model="item.estado_valido" type="text" class="w-full border-gray-300 rounded-md shadow-sm text-xs"/>
          </td>
          <td class="px-1 hover:text-red-700 text-center">
            <button type="button" @click="removeItem(index)">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- <button @click.prevent="addItem">Agregar Ítem</button> -->
  </div>
  <Modal :show="isModalVisible" maxWidth="70" closeable @close="closeModal">
    <div class="p-4">
      <CompDestinoTuristicoDetalleServicio 
        :Lista_proveedor = "Lista_proveedor"     
        :Lista_destino_turistico_detalle_servicio = Lista_destino_turistico_detalle[indice].destino_turistico_detalle_servicio
        :Lista_servicio="Lista_servicio"
        @close="closeModal"
        @actualizarTotal="actualizarTotalNieto"
      />
    </div>
  </Modal>
</template>
<script setup>
import { ref, computed, toRefs, onMounted } from 'vue';
import Modal from '@/Components/Modal.vue';
import CompDestinoTuristicoDetalleServicio from '../DestinoTuristicoDetalleServicio/CompDestinoTuristicoDetalleServicioAdd.vue';
import { defineProps, defineEmits } from 'vue';

// resources/js/app.js o main.js
import '../../../css/excelTable.css';

const props = defineProps({
  Lista_itinerarios: {
    type: Object,
    required: true,
  },
  Lista_proveedor: {
    type: Object,
    required: true,
  },
  Lista_servicio: {
    type: Object,
    required: true,
  },
  Lista_destino_turistico_detalle: {
    type: Array,
    required: true,
  },
});

const indice = ref(0);
const isModalVisible = ref(false);

function ItinerarioDescripcion(index) {
    const selectElement = event.target;
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const descripcion = selectedOption.getAttribute('data-info');
    const nombre = selectElement.options[selectElement.selectedIndex].label;
    props.Lista_destino_turistico_detalle[index].descripcion = descripcion;   
    props.Lista_destino_turistico_detalle[index].nombre = nombre;     
};

function showModal(index) {
  indice.value = index;
  isModalVisible.value = true;
}

function closeModal() {
  isModalVisible.value = false;
}

const emit = defineEmits(['update', 'actualizarMontoPadre']);

const removeItem = (index) => {
  props.Lista_destino_turistico_detalle.splice(index, 1);
  emit('update', props.Lista_destino_turistico_detalle);
  actualizarTotalNieto();
}

const totalCosto = ref(0);
const actualizarTotalNieto = (nuevoTotal) => {
  totalCosto.value = nuevoTotal;
  // Emitir el total del Hijo al Padre
  emit("actualizarMontoPadre", totalCosto.value);
};

</script>