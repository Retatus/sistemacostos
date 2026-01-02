<template>
  <div class="text-sm leading-tight rounded p-3 bg-red-300/10 border border-red-300">

    <!-- Header -->
    <div class="flex items-center justify-between mb-1 text-xs">
      <span class="font-semibold text-gray-700">
        Distribución habitaciones
      </span>

      <button type="button" @click="restaurar" class="text-gray-500 hover:text-gray-800 text-xs"
        title="Restaurar sugerencia automática">
        🔄 Restaurar
      </button>
    </div>

    <!-- Tabla -->
    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-100 text-[10px] uppercase tracking-wide text-gray-600">
          <th class="px-1 py-1 text-left">Tipo</th>
          <th class="px-1 py-1 text-center">Cap</th>
          <th class="px-1 py-1 text-right">Precio</th>
          <th class="px-1 py-1 text-center">Cant</th>
          <th class="px-1 py-1 text-right">Subtotal</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="h in seleccion" :key="h.tipo" class="border-b hover:bg-gray-50">
          <td class="px-1 py-1 capitalize text-xs text-gray-600">
            {{ h.tipo }}
          </td>

          <td class="px-1 py-1 text-center text-xs text-gray-600">
            {{ h.capacidad }}
          </td>

          <td class="px-1 py-1 text-xs text-gray-600 text-right">
            {{ h.moneda }} {{ h.precio.toFixed(2) }}
          </td>

          <td class="px-1 py-1 text-center">
            <div class="inline-flex items-center gap-1 text-xs text-gray-600">
              <button type="button" @click="disminuir(h)" class="w-5 h-5 rounded text-xs hover:bg-red-100">
                -
              </button>

              <span class="w-4 text-center">
                {{ h.cantidad }}
              </span>

              <button type="button" @click="aumentar(h)" class="w-5 h-5 rounded text-xs hover:bg-red-100">
                +
              </button>
            </div>
          </td>

          <td class="px-1 py-1 text-right font-semibold">
            {{ h.moneda }} {{ (h.precio * h.cantidad).toFixed(2) }}
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Alerta -->
    <div v-if="faltaCapacidad"
      class="mt-1 px-2 py-1 text-[11px] bg-yellow-100 border border-yellow-300 text-yellow-800 rounded">
      ⚠ Capacidad {{ capacidadTotal }} / {{ pasajeros }} pasajeros
    </div>

    <!-- Resumen -->
    <div class="grid grid-cols-3 gap-2 mt-2 pt-1 border-t border-dashed text-[11px]">
      <div class="flex flex-col">
        <span class="text-gray-500">Habitaciones</span>
        <span class="font-semibold text-gray-800">
          {{ cantidadHabitaciones }}
        </span>
      </div>

      <div class="flex flex-col text-center">
        <span class="text-gray-500">Total</span>
        <span class="font-semibold text-gray-800">
          S/ {{ subtotal.toFixed(2) }}
        </span>
      </div>

      <div class="flex flex-col text-right">
        <span class="text-gray-500">Unit / pax</span>
        <span class="font-semibold text-gray-800">
          S/ {{ costoUnitario.toFixed(2) }}
        </span>
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