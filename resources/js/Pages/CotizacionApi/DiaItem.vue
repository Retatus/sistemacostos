<template>
  <div>
    <strong>
      <h3>Día {{ dia.dia }} : {{ dia.nombre }}</h3>
    </strong>

    <div
      class="table-wrapper"
      :style="{ '--table-columns': tableColumns }"
    >
      <div class="table-grid table-header">
        <div>Hora</div>
        <div>Categoría</div>
        <div>Proveedor</div>
        <div>Descripción</div>
        <div>Observaciones</div>
        <div>Precio</div>
        <div>P.Unit.</div>
        <div>Precio</div>
        <div>Cant.</div>
        <div>SubTotal</div>
        <div>Acción</div>
      </div>

      <ServicioItem
        v-for="(serv, j) in dia.servicios"
        :key="serv.id ?? j"
        :servicio="serv"
        @remove="() => $emit('remove-servicio', { diaIndex, servIndex: j })"
      />
    </div>

    <hr />

    <button @click="mostrarModal = true">
      + Servicio
    </button>

    <hr />
  </div>

  <!-- CAMBIO: Se añade :isOpen y @close -->
  <ServicioModal
    :isOpen="mostrarModal"
    :itinerarioActual="itinerarioDia"
    @servicio-agregado="agregarServicioAlItinerario"
    @close="mostrarModal = false"
  />
  
</template>

<script setup>
import ServicioItem from "@/Pages/CotizacionApi/ServicioItem.vue";
import ServicioModal from "@/Pages/CotizacionApi/ModalServicios.vue";
import { ref, computed } from 'vue';

const tableColumns = `
    6rem
    10rem
    14rem
    minmax(20rem, 0.5fr)
    minmax(20rem, 0.5fr)
    10rem
    8rem
    8rem
    6rem
    8rem
    8rem
`;

const props = defineProps({
  dia: Object,
  diaIndex: Number,
});

const emit = defineEmits([
  "remove-servicio",
  "update-servicios"
]);

// CAMBIO: Definir la variable de control del modal
const mostrarModal = ref(false);

const itinerarioDia = computed(() => {
  return props.dia.servicios || [];
});

function recalcularOrdenServicios(servicios) {
  let contador = 1;

  servicios.forEach(servicio => {
    if (servicio.estado !== "eliminado") {
      servicio.orden = contador;
      contador++;
    }
  });
}

function agregarServicioAlItinerario(payload) {
  const { servicio, posicion, servicioReferenciaId } = payload;
  const nuevoServicio = { ...servicio };
  const servicios = props.dia.servicios;

  // Al confirmar con éxito, cerramos el modal
  mostrarModal.value = false;

  if (posicion === "inicio") {
    servicios.unshift(nuevoServicio);
  } 
  else if (posicion === "fin") {
    servicios.push(nuevoServicio);
  } 
  else {
    const index = servicios.findIndex(item => item.id === servicioReferenciaId);

    if (index === -1) {
      servicios.push(nuevoServicio);
    } else if (posicion === "antes") {
      servicios.splice(index, 0, nuevoServicio);
    } else if (posicion === "despues") {
      servicios.splice(index + 1, 0, nuevoServicio);
    }
  }

  // 🔥 Recalcular orden solo de los servicios activos
  recalcularOrdenServicios(servicios);
}
</script>