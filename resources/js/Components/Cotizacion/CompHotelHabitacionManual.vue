<template>
  <div class="text-xs leading-tight rounded-lg p-3 bg-gradient-to-br from-red-50/40 to-white border border-red-200 shadow-sm hover:shadow transition-shadow duration-200">

    <!-- Header compacto -->
    <div class="flex items-center justify-between mb-2 pb-1 border-b border-red-100">
      <div class="flex items-center gap-1.5">
        <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
          <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
        </div>
        <span class="font-semibold text-gray-800 text-xs">
          Distribución de Habitaciones
        </span>
      </div>

      <button type="button" @click="restaurar" 
              class="text-xs text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-2 py-1 rounded transition-colors flex items-center gap-1"
              title="Restaurar sugerencia automática">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Restaurar
      </button>
    </div>

    <!-- Tabla compacta -->
    <div class="overflow-x-auto -mx-1">
      <table class="w-full min-w-[280px]">
        <thead>
          <tr class="text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200">
            <th class="px-1.5 py-1.5 text-left font-medium">Tipo</th>
            <th class="px-1.5 py-1.5 text-center font-medium">Cap</th>
            <th class="px-1.5 py-1.5 text-right font-medium">Precio</th>
            <th class="px-1.5 py-1.5 text-center font-medium">Cant</th>
            <th class="px-1.5 py-1.5 text-right font-medium">Subtotal</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(h, index) in seleccion" :key="h.tipo" 
              :class="['border-b border-gray-100 hover:bg-gray-50/60 transition-colors', index === seleccion.length - 1 && 'border-b-0']">
            
            <!-- Tipo -->
            <td class="px-1.5 py-1.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium capitalize"
                :class="{
                  'bg-blue-100 text-blue-800': h.tipo?.includes('doble') || h.tipo?.includes('matrimonial'),
                  'bg-green-100 text-green-800': h.tipo?.includes('simple') || h.tipo?.includes('individual'),
                  'bg-purple-100 text-purple-800': h.tipo?.includes('triple'),
                  'bg-amber-100 text-amber-800': h.tipo?.includes('suite') || h.tipo?.includes('ejecutiva'),
                  'bg-gray-100 text-gray-800': !h.tipo
                }">
            {{ h.tipo || 'Sin tipo' }}
          </span>
            </td>

            <!-- Capacidad -->
            <td class="px-1.5 py-1.5 text-center">
              <div class="flex items-center justify-center gap-0.5">
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-7.644a21.09 21.09 0 01-7 1.448 21.09 21.09 0 01-7-1.448" />
                </svg>
                <span class="text-xs font-medium text-gray-700">{{ h.capacidad }}</span>
              </div>
            </td>

            <!-- Precio -->
            <td class="px-1.5 py-1.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <span class="text-[10px] font-medium"
                      :class="h.moneda === 'USD' ? 'text-blue-600' : 'text-green-600'">
                  {{ h.moneda }}
                </span>
                <span class="text-xs font-semibold text-gray-900">
                  {{ h.precio.toFixed(2) }}
                </span>
              </div>
            </td>

            <!-- Cantidad -->
            <td class="px-1.5 py-1.5 text-center">
              <div class="inline-flex items-center gap-1">
                <button type="button" @click="disminuir(h)" 
                        class="w-6 h-6 rounded-full bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-700 transition-colors flex items-center justify-center text-xs">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                  </svg>
                </button>

                <span class="w-6 text-center text-sm font-bold text-gray-900">
                  {{ h.cantidad }}
                </span>

                <button type="button" @click="aumentar(h)" 
                        class="w-6 h-6 rounded-full bg-gray-100 hover:bg-green-100 text-gray-600 hover:text-green-700 transition-colors flex items-center justify-center text-xs">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </button>
              </div>
            </td>

            <!-- Subtotal -->
            <td class="px-1.5 py-1.5 text-right">
              <div class="flex flex-col">
                <span class="text-xs font-bold text-gray-900">
                  {{ h.moneda }} {{ (h.precio * h.cantidad).toFixed(2) }}
                </span>
                <span class="text-[9px] text-gray-400">
                  {{ h.precio.toFixed(2) }} × {{ h.cantidad }}
                </span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Alerta capacidad -->
    <div v-if="faltaCapacidad" 
         class="mt-2 px-2.5 py-1.5 text-[10px] bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 text-amber-800 rounded-lg flex items-center gap-1.5">
      <div class="w-4 h-4 rounded-full bg-amber-100 flex items-center justify-center">
        <svg class="w-2.5 h-2.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
      </div>
      <span class="font-medium">Capacidad: {{ capacidadTotal }} / {{ pasajeros }} pasajeros</span>
    </div>

    <!-- Resumen compacto -->
    <div class="mt-3 pt-2 border-t border-gray-200">
      <div class="grid grid-cols-3 gap-3 text-xs">
        <!-- Habitaciones -->
        <div class="flex flex-col items-center p-1.5 bg-blue-50/50 rounded-lg">
          <div class="flex items-center gap-1 mb-0.5">
            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="text-[10px] text-gray-500">Habitaciones</span>
          </div>
          <span class="text-sm font-bold text-gray-900">{{ cantidadHabitaciones }}</span>
        </div>

        <!-- Total -->
        <div class="flex flex-col items-center p-1.5 bg-green-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Total</span>
          <span class="text-sm font-bold text-green-700">S/ {{ subtotal.toFixed(2) }}</span>
        </div>

        <!-- Unitario -->
        <div class="flex flex-col items-center p-1.5 bg-purple-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Unit/pax</span>
          <span class="text-sm font-bold text-purple-700">S/ {{ costoUnitario.toFixed(2) }}</span>
        </div>
      </div>
    </div>

    <!-- Info adicional sutil -->
    <div class="mt-2 pt-1 border-t border-dashed border-gray-100">
      <div class="flex justify-between text-[9px] text-gray-400">
        <span>Capacidad total: {{ capacidadTotal }}</span>
        <span>Faltan: {{ Math.max(0, pasajeros - capacidadTotal) }}</span>
      </div>
    </div>
</div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import '../../../css/excelTable.css';

const props = defineProps({
  pasajeros: { type: Number, required: true },
  habitacionesDisponibles: { type: Array, required: true }
})

const emit = defineEmits(["update"])

/*
  habitacionesDisponibles = [
    { tipo: 'simple', capacidad: 1, precio: 100 },
    { tipo: 'doble', capacidad: 2, precio: 150 },
    { tipo: 'triple', capacidad: 3, precio: 200 }
  ]
*/

const seleccion = ref([])

// -----------------------------------------------------
// 1. Distribución automática sugerida
// -----------------------------------------------------
function calcularDistribucionAutomatica() {
  let paxRestantes = props.pasajeros
  const resultado = []

  const ordenadas = [...props.habitacionesDisponibles].sort(
    (a, b) => b.capacidad - a.capacidad
  )

  for (const hab of ordenadas) {
    const cantidad = Math.floor(paxRestantes / hab.capacidad)

    if (cantidad > 0) {
      resultado.push({
        tipo: hab.tipo,
        capacidad: hab.capacidad,
        moneda: hab.moneda,
        precio: hab.precio,
        cantidad
      })
      paxRestantes -= cantidad * hab.capacidad
    }
  }

  if (paxRestantes > 0) {
    const menor = ordenadas[ordenadas.length - 1]
    resultado.push({
      tipo: menor.tipo,
      capacidad: menor.capacidad,
      moneda: menor.moneda,
      precio: menor.precio,
      cantidad: 1
    })
  }

  seleccion.value = resultado
  emit("update", resultado)
}

// -----------------------------------------------------
// 2. Cálculo de capacidad total según selección manual
// -----------------------------------------------------
const capacidadTotal = computed(() =>
  seleccion.value.reduce((sum, h) => sum + h.capacidad * h.cantidad, 0)
)

const faltaCapacidad = computed(() =>
  capacidadTotal.value < props.pasajeros
)

const cantidadHabitaciones = computed(() =>
  seleccion.value.reduce((sum, h) => sum + h.cantidad, 0)
)
// -----------------------------------------------------
// 3. Subtotal y costo unitario
// -----------------------------------------------------
const subtotal = computed(() =>
  seleccion.value.reduce((sum, h) => sum + h.precio * h.cantidad, 0)
)

const costoUnitario = computed(() =>
  subtotal.value / props.pasajeros
)

// -----------------------------------------------------
// 4. Modificación manual
// -----------------------------------------------------
function aumentar(h) {
  h.cantidad++
  emit("update", seleccion.value)
}

function disminuir(h) {
  if (h.cantidad > 0) {
    h.cantidad--
    emit("update", seleccion.value)
  }
}

// -----------------------------------------------------
// 5. Restaurar sugerencia automática
// -----------------------------------------------------
function restaurar() {
  calcularDistribucionAutomatica()
}

// Recalcular cuando cambian pasajeros o habitaciones
watch(
  () => [props.pasajeros, props.habitacionesDisponibles],
  calcularDistribucionAutomatica,
  { immediate: true }
)
</script>