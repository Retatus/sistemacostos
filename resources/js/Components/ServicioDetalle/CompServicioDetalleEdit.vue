<template>
  <div class="overflow-x-auto py-0">
    <div class="py-1">
      <table className="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead className="text-xs text-gray-900 uppercase bg-gray-50">
          <tr class="bg-gray-100">
            <th class="w-2/6 px-4 py-2">Servicio (edit)</th>
            <th class="w-1/6 px-4 py-2">Nro Pasajero</th>
            <th class="w-1/6 px-4 py-2">Costo</th>
            <th class="w-1/6 px-4 py-2">Nro Servicio/Pasajero</th>
            <th colspan="2" class="w-1/6 px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="Lista_servicio_detalle.length > 0" v-for="(item, index) in Lista_servicio_detalle" :key="index" className="bg-white border-b text-gray-900">
            <td class="px-4 py-2 text-sm">
                <select v-model="item.categoria" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in categoriesStore.globals.proveedor_categories" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-4 py-2 text-sm">
                <input :value="modelValue" 
                @input="$emit('update:modelValue', $event.target.value)"
                  type="text" required="true" 
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="px-4 py-2 text-sm">
                <input v-model="item.total_monto" type="text" required="true" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="px-4 py-2 text-sm">
                <input v-model="item.cantidad" type="text" required="true" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="px-4 py-2 text-sm hover:text-red-700 text-center">
              <button type ="button" v-if="Number(Lista_Pasajeros.length) > 0" @click="showModalDetalle(index)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                </svg>
              </button>
            </td>
            <td class="px-4 py-2 text-sm hover:text-red-700 text-center">
              <button type ="button" v-if="Number(Lista_Pasajeros.length) > 0" @click="showModalEdit(index)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <PasajeroDetalleModal
    :Titulo = "selectedLabel"
    :SelectValueCategoria = "selectedValue_Categoria.toString()"
    :isModalVisible="isModalVisibleDetalle"
    :ListaPasajeros = Lista_Pasajeros
    :Lista_servicio_x_dia = "Lista_servicio_x_dia"
    @close="isModalVisibleDetalle = false"        
  />  
  <PasajeroEditModal
    :Titulo = "selectedLabel"
    :SelectValueCategoria = "selectedValue_Categoria.toString()"
    :isModalVisible="isModalVisibleEdit"
    :ListaPasajeros = Lista_Pasajeros
    @close="isModalVisibleEdit = false"        
    />   
</template>
<script setup>
import PasajeroDetalleModal from '@/Pages/Pasajero/CompModalPasajeroDetalleServicio.vue';
import PasajeroEditModal from '@/Pages/Pasajero/CompModalPasajeroEditServicio.vue';
import { defineProps, defineEmits } from 'vue';
import { ref, watch, toRefs } from 'vue';
import { useCategoriesStore } from '@/Stores/categories';
const categoriesStore = useCategoriesStore();

const emit = defineEmits(['update']);  // Define evento para actualizar
const props = defineProps({ 
    Lista_servicio_detalle: {
      type: Array,
      required: true,
    },
    Lista_servicio_x_dia: {
      type: Array,
      required: true,
    },
    Lista_Pasajeros: {
      type: Array,
      required: true,
    },
    modelValue: {
      type: Number, 
      required: true, 
    }
  });

  const indice = ref(0);
  const isModalVisibleDetalle = ref(false);
  const isModalVisibleEdit = ref(false);

  const selectedLabel = ref('');
  const selectedValue_Categoria = ref('');

  const removeItem = (index) => {
    props.Lista_destino_turistico_detalle_servicio.splice(index, 1);
    emit('update', props.Lista_destino_turistico_detalle_servicio);      
  }   
  
  function showModalDetalle(index) {
    indice.value = index;
    selectedValue_Categoria.value = props.Lista_servicio_detalle[index].categoria;
    selectedLabel.value = categoriesStore.globals.proveedor_categories.find(option => option.value === selectedValue_Categoria.value).label;
    isModalVisibleDetalle.value = true;
  }

  function closeModalDetalle() {
    isModalVisibleDetalle.value = false;
  }

  function showModalEdit(index) {
    indice.value = index;
    isModalVisibleEdit.value = true;
  }  

  function closeModalEdit() {
    isModalVisibleEdit.value = false;
  }

</script>


  