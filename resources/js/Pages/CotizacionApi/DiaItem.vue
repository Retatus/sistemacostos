<template>
  <div>
    <strong>
      <h3>Día {{ dia.dia }} : {{ dia.nombre }}</h3>
    </strong>

    <ServicioItem
      v-for="(serv, j) in dia.servicios"
      :key="j"
      :servicio="serv"
      @remove="() => $emit('remove-servicio', { diaIndex, servIndex: j })"
    />
    
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

function agregarServicioAlItinerario(payload) {
  const { servicio, posicion, servicioReferenciaId } = payload;
  const nuevoServicio = { ...servicio };
  const servicios = props.dia.servicios;

  // Al confirmar con éxito, cerramos el modal
  mostrarModal.value = false;

  if (posicion === "inicio") {
    servicios.unshift(nuevoServicio);
    return;
  }
  if (posicion === "fin") {
    servicios.push(nuevoServicio);
    return;
  }
  const index = servicios.findIndex(item => item.id === servicioReferenciaId);
  if (index === -1) {
    servicios.push(nuevoServicio);
    return;
  }
  if (posicion === "antes") {
    servicios.splice(index, 0, nuevoServicio);
    return;
  }
  if (posicion === "despues") {
    servicios.splice(index + 1, 0, nuevoServicio);
    return;
  }
}
</script>