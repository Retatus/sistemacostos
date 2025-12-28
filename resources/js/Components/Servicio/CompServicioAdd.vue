<template>
    <div class="overflow-x-auto px-5">
      <table class="excel-table table-auto w-full text-xs text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-900 uppercase bg-gray-50">
          <tr class="bg-white border-b text-gray-900">
            <th class="min-w-[12rem] px-2 py-1">Servicio</th>
            <th class="min-w-[10rem] px-2 py-1">Servicio clase</th>
            <th class="min-w-[8rem] px-2 py-1">Tipo pasajero</th>
            <th class="min-w-[8rem] px-2 py-1">Tipo costo</th>
            <th class="min-w-[10rem] px-2 py-1">Pax min/max</th> <!-- Aumentado ancho -->
            <th class="min-w-[6rem] px-2 py-1">Cap. pax</th>
            <th class="min-w-[6rem] px-2 py-1">Moneda</th>
            <th class="min-w-[6rem] px-2 py-1">Monto</th>
            <th class="min-w-[8rem] px-2 py-1">Ubicación</th>
            <th class="min-w-[6rem] px-2 py-1">Acciones</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(item, index) in Servicio" :key="index" class="bg-white border-b text-gray-900 align-top">
            
            <!-- SERVICIO -->
            <td class="px-1 py-2">
              <select v-model="item.servicio_detalle_id" 
              class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                <option disabled value="">-- Selecciona una opción --</option>
                <option v-for="option in ListaServicioDetalle" :key="option.value" :value="option.value">
                  {{ option.label }}
                </option>
              </select>
            </td>

            <!-- SERVICIO CLASE (Solo la primera fila define la clase del servicio) -->
            <td class="px-1 py-2">
              <select v-model="item.precios[0].servicio_clase_id" 
              class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                <option disabled value="">-- Selecciona una opción --</option>
                <option v-for="option in ListaClases" :key="option.value" :value="option.value">
                  {{ option.label }}
                </option>
              </select>
            </td>

            <!-- TIPO PASAJERO -->
            <td class="px-1 py-2">
              <select v-model="item.precios[0].tipo_pasajero_id" 
              class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                <option disabled value="">-- Selecciona una opción --</option>
                <option v-for="option in ListaTipoPasajeros" :key="option.value" :value="option.value">
                  {{ option.label }}
                </option>
              </select>
            </td>

            <!-- TIPO COSTO -->
            <td class="px-1 py-2">
              <select v-model="item.precios[0].tipo_costo"
                class="w-full border-gray-300 rounded-md shadow-sm text-xs"
                @change="ajustarCampos(index)">
                <option value="UNITARIO">UNITARIO</option>
                <option value="GRUPAL">GRUPAL</option>
                <option value="HABITACION">HABITACIÓN</option>
              </select>
            </td>

            <!-- COLUMNAS REPETIBLES (RANGOS) -->
            <td colspan="4" class="p-0">
              <div v-for="(p, pIdx) in item.precios" :key="pIdx" 
                class="flex items-center gap-1 border-b last:border-b-0 px-1">
                
                <!-- PAX MIN/MAX -->
              <div class="flex gap-1 w-[10rem]">
                <input type="text"
                  v-model="p.pax_min"
                  :disabled="p.tipo_costo !== 'GRUPAL'"
                  :class="{'bg-gray-100 cursor-not-allowed': p.tipo_costo !== 'GRUPAL'}"
                  placeholder="Min"
                  class="w-full border-gray-300 rounded-md text-right text-xs" />

                <input type="text"
                  v-model="p.pax_max"
                  @input="sincronizarCapacidad(index, pIdx)"
                  :disabled="p.tipo_costo !== 'GRUPAL'"
                  :class="{'bg-gray-100 cursor-not-allowed': p.tipo_costo !== 'GRUPAL'}"
                  placeholder="Max"
                  class="w-full border-gray-300 rounded-md text-right text-xs" />
                </div>

                <!-- CAPACIDAD PAX -->
                <div class="w-[6rem]">
                  <input type="text"
                  v-model="p.capacidad_pax"
                  :disabled="p.tipo_costo === 'UNITARIO'"
                  :class="{'bg-gray-100 cursor-not-allowed': p.tipo_costo === 'UNITARIO'}"
                  placeholder="Capacidad"
                  class="w-full border-gray-300 rounded-md text-right text-xs" />
                </div>

                <!-- MONEDA -->
                <div class="w-[6rem]">
                  <select v-model="p.moneda" class="w-full border-gray-300 rounded-md text-xs">
                    <option value="USD">USD</option>
                    <option value="PEN">PEN</option>
                  </select>
                </div>

                <!-- MONTO -->
                <div class="w-[6rem]">
                  <input type="text" v-model="p.monto" 
                  @blur="formatMonto(index, pIdx)" 
                  class="w-full border-gray-300 rounded-md text-right text-xs" />
                </div>

                <!-- BOTÓN ELIMINAR RANGO (Solo si es grupal y hay más de uno) -->
                <button v-if="p.tipo_costo === 'GRUPAL' && item.precios.length > 1" 
                  type="button"
                  @click="removeRango(index, pIdx)" 
                  class="text-red-500 px-1">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                </button>
              </div>
              
              <!-- BOTÓN AGREGAR RANGO -->
              <div v-if="item.precios[0].tipo_costo === 'GRUPAL'" class="px-2 py-1 text-end">
                <button type="button" @click="addRango(index)" 
                  class="text-blue-600 text-[10px] font-bold hover:underline">
                  + AGREGAR RANGO
                </button>
              </div>
            </td>

            <!-- UBICACIÓN -->
            <td class="px-1 py-2">
              <select v-model="item.ubicacion_id" 
              class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                <option disabled value="">-- Selecciona una opción --</option>
                <option v-for="option in ListaUbicaciones" :key="option.value" :value="option.value">
                  {{ option.label }}
                </option>
              </select>
            </td>

            <!-- ACCIONES (Eliminar Servicio Completo) -->
            <td class="px-1 py-2 text-center">
              <button type="button" 
              @click="removeItem(index)" 
              class="text-red-600">
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

  // Métodos para manejar montos (igual que antes)
  const handleMontoInput = (event, indexServicio) => {
      let value = event.target.value.replace(/[^0-9.]/g, '')
      const parts = value.split('.')
      if (parts.length > 2) value = parts[0] + '.' + parts.slice(1).join('')
      if (parts.length === 2) value = parts[0] + '.' + parts[1].slice(0, 2)
      props.Servicio[indexServicio].precios[0].monto = value
  }

  const formatMonto = (indexServicio) => {
      let monto = parseFloat(props.Servicio[indexServicio].precios[0].monto) || 0
      props.Servicio[indexServicio].precios[0].monto = monto.toFixed(2)
  }

  const ajustarCampos = (index) => {
  const item = props.Servicio[index];
  
  // Al cambiar el tipo de costo, reseteamos a una sola tarifa por defecto
  // a menos que sea GRUPAL, donde permitimos múltiples.
  if (item.precios[0].tipo_costo === 'UNITARIO') {
    item.precios = [item.precios[0]]; // Nos quedamos con uno
    item.precios[0].pax_min = 1;
    item.precios[0].pax_max = 99;
    item.precios[0].capacidad_pax = 1;
    item.precios[0].tipo_costo = 'UNITARIO';
  } 
  else if (item.precios[0].tipo_costo === 'HABITACION') {
    item.precios = [item.precios[0]];
    item.precios[0].pax_min = 1;
    item.precios[0].pax_max = 99;
    item.precios[0].capacidad_pax = 2; // Default Doble
    item.precios[0].tipo_costo = 'HABITACION';
  }
  else if (item.precios[0].tipo_costo === 'GRUPAL') {
      item.precios[0].tipo_costo = 'GRUPAL';
      item.precios[0].pax_min = 1;
      item.precios[0].pax_max = 2;
      item.precios[0].capacidad_pax = 2; 
    // Mantenemos lo que tenga, permitiendo agregar más con addRango
  }
};

const addRango = (index) => {
  const item = props.Servicio[index];
  const lastP = item.precios[item.precios.length - 1];
  
  item.precios.push({
    servicio_clase_id: lastP.servicio_clase_id,
    tipo_pasajero_id: lastP.tipo_pasajero_id,
    tipo_costo: 'GRUPAL',
    pax_min: parseInt(lastP.pax_max) + 1 || 1,
    pax_max: parseInt(lastP.pax_max) + 5 || 5,
    capacidad_pax: parseInt(lastP.pax_max) + 5 || 5,
    moneda: lastP.moneda,
    monto: 0
  });
};

const removeRango = (itemIndex, precioIndex) => {
  props.Servicio[itemIndex].precios.splice(precioIndex, 1);
};

const sincronizarCapacidad = (itemIndex, precioIndex) => {
  const item = props.Servicio[itemIndex];
  if (item.precios[precioIndex].tipo_costo === 'GRUPAL') {
    item.precios[precioIndex].capacidad_pax = item.precios[precioIndex].pax_max;
  }
};
</script>


  