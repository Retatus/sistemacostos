<template>
  <div
    class="text-xs leading-tight rounded-lg p-3 bg-gradient-to-br from-blue-50/40 to-white border border-blue-200 shadow-sm hover:shadow transition-shadow duration-200"
  >
    <!-- Header -->
    <div class="flex items-center justify-between mb-2 pb-1 border-b border-blue-100">
      <div class="flex items-center gap-1.5">
        <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
          <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 7h8m-8 4h8m-8 4h8m-2 4H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v6"
            />
          </svg>
        </div>
        <span class="font-semibold text-gray-800 text-xs">
          Transporte recomendado
        </span>
      </div>

      <button
        type="button"
        @click="restaurar"
        class="text-xs text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-2 py-1 rounded transition-colors flex items-center gap-1"
        title="Restaurar sugerencia automática"
      >
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
          />
        </svg>
        Restaurar
      </button>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto -mx-1">
      <table class="w-full min-w-[280px]">
        <thead>
          <tr
            class="text-[10px] uppercase tracking-wide text-gray-500 border-b border-gray-200"
          >
            <th class="px-1.5 py-1.5 text-left font-medium">Tipo</th>
            <th class="px-1.5 py-1.5 text-left font-medium">Costo</th>
            <th class="px-1.5 py-1.5 text-center font-medium">Cap</th>
            <th class="px-1.5 py-1.5 text-right font-medium">Precio</th>
            <th class="px-1.5 py-1.5 text-center font-medium">Cant</th>
            <th class="px-1.5 py-1.5 text-right font-medium">Subtotal</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-if="seleccion"
            class="border-b border-gray-100 hover:bg-gray-50/60 transition-colors"
          >
            <!-- Tipo -->
            <td class="px-1.5 py-1.5">
              <span
                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium capitalize"
                :class="{
                  'bg-blue-100 text-blue-800': seleccion.tipo?.toLowerCase().includes('confort'),
                  'bg-green-100 text-green-800': seleccion.tipo?.toLowerCase().includes('estandar'),
                  'bg-purple-100 text-purple-800': seleccion.tipo?.toLowerCase().includes('familiar'),
                  'bg-gray-100 text-gray-800': !seleccion.tipo
                }"
              >
                {{ seleccion.tipo }}
              </span>
            </td>
            <!-- Costo -->
            <td>
              <div class="text-xs font-medium text-gray-700">
                <span class="bg-sky-100 text-sky-600 inline-flex items-center px-2 py-0.5 rounded-full text-[10px]">
                  {{ seleccion.tipo_costo?.toLowerCase() }}
                </span>                
              </div>
            </td>

            <!-- Capacidad -->
            <td class="px-1.5 py-1.5 text-center">
              <div class="flex items-center justify-center gap-0.5">
                <svg
                  class="w-3 h-3 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-7.644a21.09 21.09 0 01-7 1.448 21.09 21.09 0 01-7-1.448"
                  />
                </svg>
                <span class="text-xs font-medium text-gray-700">
                  {{ seleccion.min }}–{{ seleccion.max }}
                </span>
              </div>
            </td>

            <!-- Precio -->
            <td class="px-1.5 py-1.5 text-right">
              <div class="flex items-center justify-end gap-1">
                <span
                  class="text-[10px] font-medium"
                  :class="seleccion.moneda === 'USD' ? 'text-blue-600' : 'text-green-600'"
                >
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
                <button
                  type="button"
                  @click="disminuir"
                  class="w-6 h-6 rounded-full bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-700 transition-colors flex items-center justify-center text-xs"
                >
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                  </svg>
                </button>

                <span class="w-6 text-center text-sm font-bold text-gray-900">
                  {{ seleccion.cantidad }}
                </span>

                <button
                  type="button"
                  @click="aumentar"
                  class="w-6 h-6 rounded-full bg-gray-100 hover:bg-green-100 text-gray-600 hover:text-green-700 transition-colors flex items-center justify-center text-xs"
                >
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
            <td colspan="5" class="text-center py-3 text-gray-400 text-xs">
              No hay transporte adecuado para {{ pasajeros }} pasajeros
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Resumen -->
    <div v-if="seleccion" class="mt-3 pt-2 border-t border-gray-200">
      <div class="grid grid-cols-3 gap-3 text-xs">
        <div class="flex flex-col items-center p-1.5 bg-blue-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Pasajeros</span>
          <span class="text-sm font-bold text-gray-900">{{ pasajeros }}</span>
        </div>

        <div class="flex flex-col items-center p-1.5 bg-green-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Total</span>
          <span class="text-sm font-bold text-green-700">
            {{ seleccion.moneda }} {{ Number(subtotal).toFixed(2) }}
          </span>
        </div>

        <div class="flex flex-col items-center p-1.5 bg-purple-50/50 rounded-lg">
          <span class="text-[10px] text-gray-500 mb-0.5">Unit/pax</span>
          <span class="text-sm font-bold text-purple-700">
            {{ seleccion.moneda }} {{ Number(costoUnitario).toFixed(2) }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  pasajeros: { type: Number, required: true },
  transportesDisponibles: { type: Array, required: true },

  // Nuevos
  tipoCostoPreferido: { type: String, default: 'TRAYECTO' }, // TRAYECTO | HORA | DIA | GRUPAL
  cantidadHoras: { type: Number, default: 1 },
  cantidadDias: { type: Number, default: 1 }
})

const emit = defineEmits(['update'])
/*  "transportesDisponibles": [
    {
      "tipo": "Minivan",
      "min": 3,
      "max": 6,
      "capacidad": 6,
      "tarifas": [
        { "tipo_costo": "GRUPAL", "precio": 180, "moneda": "USD", "precio_id": 201 },
        { "tipo_costo": "TRAYECTO", "precio": 40, "moneda": "USD", "precio_id": 202 },
        { "tipo_costo": "HORA", "precio": 25, "moneda": "USD", "precio_id": 203 },
        { "tipo_costo": "DIA", "precio": 200, "moneda": "USD", "precio_id": 204 }
      ]
    }
  ]
*/

const seleccion = ref(null)

// -----------------------------------------------------
// Elegir tarifa dentro del vehículo
// -----------------------------------------------------
function elegirTarifa(vehiculo) {
  if (!vehiculo.tarifas?.length) return null

  let tarifa = vehiculo.tarifas.find(
    t => t.tipo_costo === props.tipoCostoPreferido
  )

  if (!tarifa) {
    tarifa =
      vehiculo.tarifas.find(t => t.tipo_costo === 'GRUPAL') ||
      vehiculo.tarifas.find(t => t.tipo_costo === 'TRAYECTO') ||
      vehiculo.tarifas[0]
  }

  return tarifa
}

// -----------------------------------------------------
// Sugerencia automática
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

  const vehiculo = candidatos[0]
  const tarifa = elegirTarifa(vehiculo)

  if (!tarifa) {
    seleccion.value = null
    emit('update', null)
    return
  }

  seleccion.value = {
    tipo: vehiculo.tipo,
    min: vehiculo.min,
    max: vehiculo.max,
    capacidad: vehiculo.capacidad,

    tipo_costo: tarifa.tipo_costo,
    precio: tarifa.precio,
    moneda: tarifa.moneda,
    precio_id: tarifa.precio_id,

    cantidad: 1
  }

  emit('update', {
    ...seleccion.value,
    subtotal: subtotal.value
  })
}

// -----------------------------------------------------
// Cálculos
// -----------------------------------------------------
const subtotal = computed(() => {
  if (!seleccion.value) return 0

  const precio = seleccion.value.precio

  if (seleccion.value.tipo_costo === 'HORA') {
    return precio * props.cantidadHoras * seleccion.value.cantidad
  }

  if (seleccion.value.tipo_costo === 'DIA') {
    return precio * props.cantidadDias * seleccion.value.cantidad
  }

  return precio * seleccion.value.cantidad
})

const costoUnitario = computed(() => {
  if (!seleccion.value || !props.pasajeros) return 0
  return subtotal.value / props.pasajeros
})

const detalleMultiplicador = computed(() => {
  if (!seleccion.value) return ''

  if (seleccion.value.tipo_costo === 'HORA') {
    return `${seleccion.value.precio} × ${props.cantidadHoras} h`
  }

  if (seleccion.value.tipo_costo === 'DIA') {
    return `${seleccion.value.precio} × ${props.cantidadDias} día(s)`
  }

  return `${seleccion.value.precio} × ${seleccion.value.cantidad}`
})

// -----------------------------------------------------
// Modificación manual
// -----------------------------------------------------
function aumentar() {
  if (!seleccion.value) return
  seleccion.value.cantidad++
  emit('update', { ...seleccion.value, subtotal: subtotal.value })
}

function disminuir() {
  if (!seleccion.value) return
  if (seleccion.value.cantidad > 1) {
    seleccion.value.cantidad--
    emit('update', { ...seleccion.value, subtotal: subtotal.value })
  }
}

// -----------------------------------------------------
// Restaurar sugerencia automática
// -----------------------------------------------------
function restaurar() {
  calcularSugerenciaAutomatica()
}

// -----------------------------------------------------
// Watch
// -----------------------------------------------------
watch(
  () => [
    props.pasajeros,
    props.transportesDisponibles,
    props.tipoCostoPreferido,
    props.cantidadHoras,
    props.cantidadDias
  ],
  calcularSugerenciaAutomatica,
  { immediate: true }
)
</script>
