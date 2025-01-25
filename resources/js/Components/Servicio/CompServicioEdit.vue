<template>
    <div class="overflow-x-auto p-5">
      <table className="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead className="text-xs text-gray-900 uppercase bg-gray-50">
          <tr class="bg-gray-100">
            <th class="w-1/24 px-4 py-2 text-sm font-medium">Monto</th>
            <th class="w-1/24 px-4 py-2 text-sm font-medium">Moneda</th>
            <th class="w-7/24 px-4 py-2 text-sm font-medium">Servicio clase</th>
            <th class="w-7/24 px-4 py-2 text-sm font-medium">Servicio detalle</th>
            <th class="w-4/24 px-4 py-2 text-sm font-medium">Ubicacion</th>
            <th class="w-2/24 px-4 py-2 text-sm font-medium">Tipo Pax</th>

            <th hidden class="px-4 py-2 text-sm font-medium">Producto</th>
            <th hidden class="px-4 py-2 text-sm font-medium">Cantidad</th>
            <th hidden class="px-4 py-2 text-sm font-medium">Precio</th>
            <th hidden class="px-4 py-2 text-sm font-medium">Total</th>
            <th colspan="2" class="w-2/24  px-4 py-2 text-sm font-medium">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items" :key="index" className="bg-white border-b text-gray-900">
            <td class="px-4 py-2 text-sm">
                <input v-model="item.monto" type="number" required="true" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="px-4 py-2 text-sm">
                <select v-model="item.moneda" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option value="DOLARES">DOLARES</option>
                  <option value="SOLES">SOLES</option>
                </select>
            </td>
            <td class="px-4 py-2 text-sm">
                <select v-model="item.servicio_clase_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaServicio_clase" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-4 py-2 text-sm">
                <select v-model="item.servicio_detalle_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaServicio_detalle" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-4 py-2 text-sm">
                <input v-model="item.ubicacion" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="px-4 py-2 text-sm">
                <select v-model="item.tipo_pax" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option value="ADULTO">ADULTO</option>
                  <option value="ESTUDIANTE">ESTUDIANTE</option>
                  <option value="NINIO">NIÑO</option>
                </select>
            </td>          
            <td hidden class="px-4 py-2 text-sm">
                <input v-model="item.estado_valido" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="px-4 py-2 text-sm hover:text-blue-700">
              <button type ="button" @click="removeItem(index)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
              </button>
            </td>
            <td class="px-4 py-2 text-sm hover:text-red-700">
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
    const props = defineProps({
      items: {
        type: Array,
        required: true,
      },
      ListaServicio_clase: {
          type: Object, 
          required: true
      } ,
      ListaServicio_detalle: {
          type: Object, 
          required: true
      } 
    })

    const emit = defineEmits(['update']); // Define el evento que vas a emitir
    
    const removeItem = (index) => {
      props.items.splice(index, 1);
      emit('update', props.items);
    }   
      
</script>


  