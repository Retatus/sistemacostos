<template>
    <div class="overflow-x-auto p-5">
      <table class="min-w-full table-auto border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="w-1/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Monto</th>
            <th class="w-1/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Moneda</th>
            <th class="w-7/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Servicio clase</th>
            <th class="w-7/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Servicio detalle</th>
            <th class="w-4/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Ubicacion</th>
            <th class="w-2/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Tipo Pax</th>

            <th hidden class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Producto</th>
            <th hidden class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Cantidad</th>
            <th hidden class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Precio</th>
            <th hidden class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Total</th>
            <th colspan="2" class="w-2/24 border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items" :key="index" class="even:bg-gray-50 odd:bg-white">
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <input v-model="item.monto" type="number" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <select v-model="item.moneda" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option value="dolares">DOLARES</option>
                  <option value="soles">SOLES</option>
                </select>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <select v-model="item.servicio_clase_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaServicio_clase" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <select v-model="item.servicio_detalle_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in ListaServicio_detalle" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <input v-model="item.ubicacion" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <select v-model="item.tipo_pax" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                  <option value="adulto">ADULTO</option>
                  <option value="estudiante">ESTUDIANTE</option>
                  <option value="ninio">NIÑO</option>
                </select>
            </td>          

            <td hidden class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <input v-model="item.producto" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td hidden class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <input v-model.number="item.cantidad" type="number" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td hidden class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                <input v-model.number="item.precio" type="number" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
            </td>
            <td hidden class="border border-gray-300 px-4 py-2 text-sm text-gray-700">{{ item.cantidad * item.precio }}</td>
            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:text-blue-700">
              <button @click="removeItem(index)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h4m4 0h-4m4 0a2 2 0 01-2 2h-4a2 2 0 01-2-2h4zm4 0H7m4 0H5a2 2 0 012-2h8a2 2 0 012 2z" />
                </svg>
              </button>
            </td>
            <td class=" border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:text-red-700">
              <button @click="removeItem(index)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <button @click.prevent="addItem">Agregar Ítem</button> -->
    </div>
  </template>

<script>  
  export default {
    props: {
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
    },
    methods: {
      removeItem(index) {
        this.items.splice(index, 1);
        this.$emit('update', this.items);
      },
    },
  };
</script>
  