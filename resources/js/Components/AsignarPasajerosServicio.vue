<template>
  <div class="pasajero-servicio-selector flex space-x-1">
    <div class="select-container w-1/2">
      <select v-model="selectedPasajeroId" @change="addPasajeroToService" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
        <option value="" disabled selected>Selecciona un pasajero</option>
        <option
          v-for="pasajero in availablePasajeros"
          :key="pasajero.id || pasajero.temp_id"
          :value="pasajero.id || pasajero.temp_id"
        >
          {{ pasajero.nombre }}
        </option>
      </select>
    </div>

    <div class="assigned-pasajeros-list" v-if="assignedPasajerosList.length <= 2">
      <ul class="lista-horizontal text-xs">
        <li v-for="pasajero in assignedPasajerosList.filter(p => p !== null)" :key="pasajero.id || pasajero?.temp_id">
          {{ pasajero.nombre }}
          <button @click="removePasajeroFromService(pasajero.id || pasajero.temp_id)">
            &times;
          </button>
        </li>
      </ul>
    </div>
    <div v-else>
      <CustomSelect
        :assignedPasajerosList="assignedPasajerosList"
        @remove="removePasajeroFromService"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, defineProps, defineEmits } from 'vue';
import CustomSelect from '@/Components/CustomSelect.vue';

const props = defineProps({
  pasajerosDisponibles: {
    type: Array,
    required: true,
  },
  // La lista de pasajeros YA asignados a este servicio.
  // Usaremos v-model para esto.
  modelValue: {
    type: Array,
    default: () => [],
  },
  servicio: {
    type: Object,
    required: true,
  }
});

const emit = defineEmits(['update:modelValue']);

// ID del pasajero seleccionado en el <select>
const selectedPasajeroId = ref('');

// Lista de pasajeros asignados localmente a este servicio
// Inicialmente toma el valor de modelValue
const assignedPasajerosList = ref([...props.modelValue]);

// Computada para filtrar los pasajeros disponibles que aún no están asignados
const availablePasajeros = computed(() => {
  const assignedIds = new Set(assignedPasajerosList.value.filter(p => p != null).map(p => String(p.id || p.temp_id)));
  return props.pasajerosDisponibles.filter(
    (pasajero) => !assignedIds.has(String(pasajero.id || pasajero.temp_id))
  );
});

// Watcher para sincronizar modelValue con assignedPasajerosList
// Esto es crucial para que el componente padre pueda actualizar la lista de pasajeros asignados
watch(() => props.modelValue, (newVal) => {
  assignedPasajerosList.value = [...newVal];
}, { deep: true });

// Función para añadir un pasajero al servicio
const addPasajeroToService = () => {
  if (selectedPasajeroId.value) {
    const pasajeroToAdd = props.pasajerosDisponibles.find(
      (p) => (p.id || p.temp_id) === selectedPasajeroId.value
    );
    if (pasajeroToAdd) {
      assignedPasajerosList.value.push(pasajeroToAdd);
      emit('update:modelValue', assignedPasajerosList.value);
      selectedPasajeroId.value = ''; // Resetear la selección
    }
  }
};

// Función para eliminar un pasajero del servicio
const removePasajeroFromService = (pasajeroId) => {
  assignedPasajerosList.value = assignedPasajerosList.value.filter(
    (p) => (p.id || p.temp_id) !== pasajeroId
  );
  emit('update:modelValue', assignedPasajerosList.value);
};

// Limpia la selección cuando los pasajeros disponibles cambian
watch(availablePasajeros, () => {
  selectedPasajeroId.value = '';
});
</script>

<style scoped>

.lista-horizontal {
  display: flex;
  flex-wrap: wrap;      /* Permite que los elementos pasen a la siguiente línea */
  gap: 10px;            /* Espacio entre elementos */
  padding: 5px;
  margin: 0;
  list-style: none;
}

.lista-horizontal li {
  background-color: #f0f0f0;
  padding: 5px 10px;
  border-radius: 4px;
  /* flex: 1 1 150px;       O puedes usar un ancho fijo como flex: 0 0 150px; */
  text-align: center;
}


.select-container select {
  width: 100%;
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

.no-pasajeros {
  font-style: italic;
  color: #888;
  font-size: 0.7rem;
  text-align: center;
}
</style>