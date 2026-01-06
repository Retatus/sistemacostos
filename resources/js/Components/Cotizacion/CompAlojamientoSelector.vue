<template>
  <div class="fixed inset-0 flex justify-center items-start bg-black/50 z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-8 mt-12 max-h-[85vh] flex flex-col">
      <!-- Header -->
      <div class="flex justify-between items-start mb-6">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">
            🏨 Configurar Alojamiento
          </h2>
          <p class="text-sm text-gray-500 mt-1">
            Seleccione el proveedor y configure los detalles de hospedaje
          </p>
        </div>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Contenido con scroll -->
      <div class="space-y-6 flex-1 overflow-y-auto pr-2">
        <!-- 1. Selector de proveedor -->
        <div
          class="border-2 border-gray-100 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white hover:border-blue-200 transition-all duration-300">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-800">Proveedor de Alojamiento</h3>
              <p class="text-xs text-gray-500">Seleccione un hotel o proveedor de hospedaje</p>
            </div>
          </div>

          <select v-model="proveedorId"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-white">
            <option disabled value="" class="text-gray-400">Seleccione un proveedor...</option>
            <option v-for="p in proveedores" :key="p.id" :value="p.id" class="py-2 hover:bg-blue-50">
              <div class="flex justify-between items-center">
                <span class="font-medium">{{ p.razon_social }}</span>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">RUC: {{ p.ruc }}</span>
              </div>
            </option>
          </select>
        </div>

        <!-- 2. Detalles de habitaciones (si aplica) -->
        <!-- Aquí puedes agregar una sección para configurar habitaciones si es necesario -->
        <DistribucionHabitaciones v-if="habitaciones.length" 
          :pasajeros="pasajeros"
          :habitacionesDisponibles="habitaciones" 
          @update="actualizarDistribucion" 
        />

        <!-- 3. Resumen final -->
        <div v-if="resumen"
          class="border-2 border-green-100 rounded-xl p-6 bg-gradient-to-br from-green-50 to-white animate-fade-in">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <h3 class="font-bold text-gray-900 text-lg">Resumen de Alojamiento</h3>
              <p class="text-sm text-gray-500">Detalles confirmados del hospedaje</p>
            </div>
          </div>

          <!-- Grid de detalles -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                  <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div>
                  <p class="text-xs text-gray-500">Proveedor</p>
                  <p class="font-semibold text-gray-900">{{ resumen.proveedor.razon_social }}</p>
                </div>
              </div>

              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                  <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-xs text-gray-500">Dirección</p>
                  <p class="font-semibold text-gray-900 truncate">{{ resumen.proveedor.direccion }}</p>
                </div>
              </div>
            </div>

            <div class="space-y-3">
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                  <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                </div>
                <div>
                  <p class="text-xs text-gray-500">Habitaciones</p>
                  <p class="font-semibold text-gray-900">{{ resumen.totalHabitaciones }} <span
                      class="text-xs text-gray-500">unidades</span></p>
                </div>
              </div>

              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                  <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-xs text-gray-500">Costo Unitario</p>
                  <p class="font-semibold text-gray-900">S/ {{ resumen.costoUnitario }} <span
                      class="text-xs text-gray-500">por pasajero</span></p>
                </div>
              </div>
            </div>
          </div>

          <!-- Total destacado -->
          <div class="mt-6 pt-5 border-t border-green-200">
            <div class="flex justify-between items-center">
              <div>
                <p class="text-sm text-gray-500">Total del alojamiento</p>
                <p class="text-xs text-gray-400">Incluye todas las habitaciones</p>
              </div>
              <div class="text-right">
                <p class="text-2xl font-bold text-green-700">S/ {{ resumen.subtotal }}</p>
                <p class="text-xs text-gray-500">Impuestos incluidos</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Espacio adicional para scroll -->
        <div class="h-4"></div>
      </div>

      <!-- Footer con botones fijos -->
      <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
        <button type="button" @click="$emit('close')"
          class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-300 font-medium flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          Cancelar
        </button>

        <button type="button" @click="confirmar" :disabled="!resumen"
          class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 font-medium shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Confirmar Alojamiento
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import DistribucionHabitaciones from '@/Components/Cotizacion/CompHotelHabitacionManual.vue'

const props = defineProps({
  pasajeros: { type: Number, required: true },
  categoria: { type: Number, required: true } // id ciudad / categoria
})

const emit = defineEmits(['update'])

const proveedores = ref([])
const proveedorId = ref('')
const habitaciones = ref([])
const distribucion = ref(null)
const resumen = ref(null)

// --------------------------------------------------
// 1. Cargar proveedores sugeridos
// --------------------------------------------------
async function cargarProveedores() {
  const { data } = await axios.get(route('proveedor.proveedorAlojamiento'), {
    params: { categoria: props.categoria, pasajeros: props.pasajeros }
  });
  proveedores.value = data
}

// --------------------------------------------------
// 2. Cargar habitaciones del proveedor
// --------------------------------------------------
async function cargarHabitaciones(id) {
  const { data } = await axios.get(route('proveedor.proveedorHabitacion', { proveedor: id }))
  console.log('habitaciones selector', data) 
  habitaciones.value = data
}

// --------------------------------------------------
// 3. Recibir distribución del componente hijo
// --------------------------------------------------
function actualizarDistribucion(seleccion) {
  distribucion.value = seleccion

  const totalHabitaciones = seleccion.reduce(
    (sum, h) => sum + h.cantidad,
    0
  )

  const subtotal = seleccion.reduce(
    (sum, h) => sum + h.precio * h.cantidad,
    0
  )

  resumen.value = {
    proveedor: proveedores.value.find(p => p.id === proveedorId.value),
    habitaciones: habitaciones.value,
    totalHabitaciones: totalHabitaciones,
    subtotal,
    costoUnitario: subtotal / props.pasajeros
  }
  emit('update', resumen.value)
}

function confirmar() {
  emit('confirm', resumen.value)
}

// --------------------------------------------------
// 4. Watchers
// --------------------------------------------------
watch(
  () => props.pasajeros,
  cargarProveedores,
  { immediate: true }
)

watch(proveedorId, (id) => {
  if (!id) return
  cargarHabitaciones(id)
})
</script>
