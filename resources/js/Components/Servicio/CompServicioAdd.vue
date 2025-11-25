<template>
    <div class="overflow-x-auto px-5">
      <table className="excel-table w-full text-xs text-left rtl:text-right text-gray-500">
        <thead className="text-xs text-gray-900 uppercase bg-gray-50">
          <tr class="bg-white border-b text-gray-900">
            <th class="w-1/12 px-4 py-2">Monto</th>
            <th class="w-1/12 px-4 py-2">Moneda</th>
            <th class="w-3/12 px-4 py-2">Servicio clase</th>
            <th class="w-4/12 px-4 py-2">Servicio detalle</th>
            <th class="w-1/12 px-4 py-2">Ubicacion</th>
            <th class="w-2/12 px-4 py-2">Tipo pasajero</th>
            <th class="w-1/12 px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in Servicio" :key="index" className="bg-white border-b text-gray-900">
            <td class="px-1">
                <input v-model="item.precios[0].monto" type="number" required="true" class="w-full border-gray-300 rounded-md shadow-sm text-xs text-end" />
            </td>
            <td class="px-1">
                <select v-model="item.precios[0].moneda" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option value="DOLARES">DOLARES</option>
                  <option value="SOLES">SOLES</option>
                </select>
            </td>
            <td class="px-1">
                <select v-model="item.precios[0].servicio_clase_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaClases" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-1">
                <select v-model="item.servicio_detalle_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaServicioDetalle" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-1">
                <select v-model="item.ubicacion_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaUbicaciones" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-1">
                <select v-model="item.precios[0].tipo_pasajero_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaTipoPasajeros" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>          
            <td hidden class="px-1">
                <input v-model="item.estado_valido" type="text" class="w-full border-gray-300 rounded-md shadow-sm text-xs" />
            </td>
            <td class="px-1 hover:text-red-700 text-center">
              <button type ="button" @click="removeItem(index)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <button @click.prevent="addItem">Agregar Ítem</button> -->
    </div>
  </template>
<script setup>
  import { ref } from 'vue';
  import { useCategoriesStore } from '@/Stores/categories';

  // resources/js/app.js o main.js
  import '../../../css/excelTable.css';

  const categoriesStore = useCategoriesStore();

    const props = defineProps({
      Servicio: {
        type: Array,
        required: true,
      },
      ListaServicioDetalle: {
          type: Object, 
          required: true
      }
    })

    const ListaClases = ref({ ...categoriesStore.globals.servicio_clases });
    const ListaUbicaciones = ref({ ...categoriesStore.globals.ubicaciones });
    const ListaTipoPasajeros = ref({ ...categoriesStore.globals.tipo_pasajeros });

    const emit = defineEmits(['update']); // Define el evento que vas a emitir
    
    const removeItem = (index) => {
      props.Servicio.splice(index, 1);
      emit('update', props.Servicio);
    }   
      
</script>


  