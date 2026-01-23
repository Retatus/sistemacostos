<template>
  <div class="text-xs leading-tight rounded-lg p-3 bg-gradient-to-br from-blue-50/40 to-white border border-blue-200 shadow-sm hover:shadow transition-shadow duration-200">

    <!-- Header -->
    <div class="flex items-center justify-between mb-2 pb-1 border-b border-blue-100">
      <div class="flex items-center gap-1.5">
        <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
          <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7h8m-8 4h8m-8 4h8m-2 4H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v6" />
          </svg>
        </div>
        <span class="font-semibold text-gray-800 text-xs">
          Transporte recomendado
        </span>
      </div>

      <button type="button" @click="restaurar"
        class="text-xs text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-2 py-1 rounded transition-colors flex items-center gap-1"
        title="Restaurar sugerencia automática">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
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
          <tr v-if="seleccion" class="border-b border-gray-100 hover:bg-gray-50/60 transition-colors">

            <!-- Tipo -->
            <td class="px-1.5 py-1.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium capitalize"
                :class="{
                    'bg-blue-100 text-blue-800': seleccion.tipo?.includes('confort') || seleccion.tipo?.includes('matrimonial'),
                    'bg-green-100 text-green-800': seleccion.tipo?.includes('estandar') || seleccion.tipo?.includes('individual'),
                    'bg-purple-100 text-purple-800': seleccion.tipo?.includes('familiar'),                   
                    'bg-gray-100 text-gray-800': !seleccion.tipo
                  }">
                {{ seleccion.tipo }}
              </span>
            </td>

            <!-- Capacidad -->
            <td class="px-1.5 py-1.5 text-center">
              <div class="flex items-center justify-center gap-0.5">
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-7.644a21.09 21.09 0 01-7 1.448 21.09 21.09 0 01-7-1.448" />
                </svg>
                <span class="text-xs font-medium text-gray-700">{{ seleccion.min }}–{{ seleccion.max }}</span>
              </div>
            </td>

            <!-- Precio -->
            <td class="px-1.5 py-1.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <span class="text-[10px] font-medium"
                  :class="seleccion.moneda === 'USD' ? 'text-blue-600' : 'text-green-600'">
                  {{ seleccion.moneda }}
                </span>
                <span class="text-xs font-semibold text-gray-900">
                  {{ Number(seleccion.precio).toFixed(2) }}
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
                  {{ seleccion.cantidad }}
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
                  {{ seleccion.moneda }} {{ Number(subtotal).toFixed(2) }}
                </span>
                <span class="text-[9px] text-gray-400">
                  {{ detalleMultiplicador }}
                </span>
              </div>
            </td>
          </tr>

          <tr v-else>
            <td colspan="4" class="text-center py-3 text-gray-400 text-xs">
              No hay transporte adecuado para {{ pasajeros }} pasajeros
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <!-- Resumen -->
    <div v-if="seleccion" class="mt-3 pt-2 border-t border-gray-200">
      <div class="grid grid-cols-3 gap-3 text-xs">
        <!-- Pasajeros -->
        <div class="flex flex-col items-center p-1.5 bg-blue-50/50 rounded-lg">
          <div class="flex items-center gap-1 mb-0.5">
            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="text-[10px] text-gray-500 mb-0.5">Pasajeros</span>
          </div>
          <span class="text-sm font-bold text-gray-900">{{ pasajeros }}</span>
        </div>

        <!-- Total -->
        <div class="flex flex-col items-center p-1.5 bg-green-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Total</span>
          <span class="text-sm font-bold text-green-700">{{ seleccion.moneda }} {{ Number(subtotal).toFixed(2) }}</span>
        </div>

        <!-- Unitario -->
        <div class="flex flex-col items-center p-1.5 bg-purple-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Unit/pax</span>
          <span class="text-sm font-bold text-purple-700">{{ seleccion.moneda }} {{ Number(costoUnitario).toFixed(2) }}</span>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  pasajeros: { type: Number, required: true },
  transportesDisponibles: { type: Array, required: true }
})

const emit = defineEmits(['update'])

/*
  transportesDisponibles=[
    { tipo: 'Taxi', min: 1, max: 2, precio: 25, moneda: 'USD' },
    { tipo: 'Minivan', min: 3, max: 6, precio: 40, moneda: 'USD' },
    { tipo: 'Sprinter', min: 7, max: 12, precio: 60, moneda: 'USD' }
  ]
*/

const seleccion = ref(null)

// -----------------------------------------------------
// 1. Sugerencia automática (similar a habitaciones)
// -----------------------------------------------------
function calcularSugerenciaAutomatica() {
  const pax = props.pasajeros

  // Filtrar transportes que soporten ese número de pasajeros
  let candidatos = props.transportesDisponibles.filter(
    t => pax >= t.min && pax <= t.max
  )

  if (!candidatos.length) {
    seleccion.value = null
    emit('update', null)
    return
  }

  // Ordenar por capacidad mínima (similar a ordenar por capacidad)
  candidatos.sort((a, b) => a.min - b.min)

  // Elegir el más adecuado
  seleccion.value = {
    ...candidatos[0],
    cantidad: 1 // por consistencia con habitaciones
  }

  emit('update', seleccion.value)
}

// -----------------------------------------------------
// 2. Cálculos derivados (similar a habitaciones)
// -----------------------------------------------------
const subtotal = computed(() => {
  if (!seleccion.value) return 0
  return seleccion.value.precio * seleccion.value.cantidad
})

const costoUnitario = computed(() => {
  if (!seleccion.value || !props.pasajeros) return 0
  return subtotal.value / props.pasajeros
})

// -----------------------------------------------------
// 3. Modificación manual (similar a habitaciones)
// -----------------------------------------------------
function aumentar() {
  if (!seleccion.value) return
  seleccion.value.cantidad++
  emit('update', seleccion.value)
}

function disminuir() {
  if (!seleccion.value) return
  if (seleccion.value.cantidad > 1) {
    seleccion.value.cantidad--
    emit('update', seleccion.value)
  }
}

// -----------------------------------------------------
// 4. Restaurar sugerencia automática
// -----------------------------------------------------
function restaurar() {
  calcularSugerenciaAutomatica()
}

// -----------------------------------------------------
// 5. Watch: recalcular automáticamente
// -----------------------------------------------------
watch(
  () => [props.pasajeros, props.transportesDisponibles],
  calcularSugerenciaAutomatica,
  { immediate: true }
)
</script>
