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

<template>
  <div class="hotel-habitaciones bg-green-300 border-green-600 p-2 rounded-md"  >

    <div class="hh-header">
      <span class="hh-title">Distribución habitaciones</span>
      <button
        type="button"
        class="hh-reset"
        @click="restaurar"
        title="Restaurar sugerencia automática"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>

      </button>
    </div>

    <table class="tabla-habitaciones">
      <thead>
        <tr>
          <th>Tipo</th>
          <th class="center">Cap.</th>
          <th class="right">Precio</th>
          <th class="center">Cant.</th>
          <th class="right">Subtotal</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="h in seleccion" :key="h.tipo">
          <td class="tipo">{{ h.tipo }}</td>
          <td class="center">{{ h.capacidad }}</td>

          <td class="right">
            S/ {{ h.precio.toFixed(2) }}
          </td>

          <td class="center">
            <div class="qty-control">
              <button type="button" @click="disminuir(h)">−</button>
              <span>{{ h.cantidad }}</span>
              <button type="button" @click="aumentar(h)">+</button>
            </div>
          </td>

          <td class="right strong">
            S/ {{ (h.precio * h.cantidad).toFixed(2) }}
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="faltaCapacidad" class="alerta">
      ⚠ Capacidad {{ capacidadTotal }} / {{ pasajeros }} pasajeros
    </div>

    <div class="resumen">
      <div>
        <span>Habitaciones</span>
        <strong>{{ cantidadHabitaciones }}</strong>
      </div>
      <div>
        <span>Total</span>
        <strong>S/ {{ subtotal.toFixed(2) }}</strong>
      </div>
      <div>
        <span>Unitario / pax</span>
        <strong>S/ {{ costoUnitario.toFixed(2) }}</strong>
      </div>
    </div>

  </div>
</template>


<style scoped>
.hotel-habitaciones {
  font-size: 0.85rem;
  line-height: 1.2;
}

.hh-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}

.hh-title {
  font-weight: 600;
  color: #333;
}

.hh-reset {
  border: none;
  background: transparent;
  cursor: pointer;
  font-size: 0.9rem;
  color: #666;
}

.hh-reset:hover {
  color: #000;
}

.tabla-habitaciones {
  width: 100%;
  border-collapse: collapse;
}

.tabla-habitaciones th {
  background: #f5f6f7;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  padding: 6px;
  border-bottom: 1px solid #ddd;
}

.tabla-habitaciones td {
  padding: 6px;
  border-bottom: 1px solid #eee;
}

.tabla-habitaciones tr:hover {
  background: #fafafa;
}

.center {
  text-align: center;
}

.right {
  text-align: right;
}

.strong {
  font-weight: 600;
}

.tipo {
  text-transform: capitalize;
}

.qty-control {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.qty-control button {
  width: 22px;
  height: 22px;
  border: 1px solid #ccc;
  background: #fff;
  cursor: pointer;
  font-size: 0.85rem;
}

.qty-control button:hover {
  background: #f0f0f0;
}

.alerta {
  margin-top: 6px;
  padding: 6px 8px;
  background: #fff3cd;
  border: 1px solid #ffeeba;
  font-size: 0.75rem;
  color: #856404;
}

.resumen {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 6px;
  margin-top: 8px;
  padding-top: 6px;
  border-top: 1px dashed #ccc;
}

.resumen div {
  display: flex;
  flex-direction: column;
  font-size: 0.75rem;
  color: #555;
}

.resumen strong {
  font-size: 0.85rem;
  color: #000;
}

</style>