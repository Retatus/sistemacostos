<template>
  <div class="block text-sm font-medium text-gray-700">
    <label v-if="label" class="font-bold">{{ label }}</label>
    <VueDatePicker 
      :modelValue="selectedDate"
      :format-locale="es"
      :timezone="timeZone"
      :format="formatearFecha"
      :disabled="disabled"
      :disabled-dates="desactivarFechas" 
      auto-apply
      @update:modelValue="emitirCambio"
      :class="'mt-1 w-full border-gray-300 rounded-md shadow-sm'"
    />
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css';
import { es } from "date-fns/locale";
import { format } from "date-fns"; // Importamos la función format de date-fns



// Props y valores iniciales
const props = defineProps({
  modelValue: [String, Date, null], // modelValue está vinculado a v-model
  label: String,
  format: {
    type: String,
    default: "dd-MM-yyyy",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

// Emisor para v-model
const emit = defineEmits(["update:modelValue"]);

// Variables reactivas
const selectedDate = ref(props.modelValue || new Date()); // Inicializar con modelValue
const timeZone = "America/Lima";

// Función para desactivar fechas menores a la actual
const desactivarFechas = (date) => {
  const hoy = new Date();
  return date <= hoy; // Desactiva fechas menores a hoy
};

// Computed para formatear la fecha
const formatearFecha = computed(() => {
  return selectedDate.value ? format(selectedDate.value, props.format) : "";
});

// Emitir cambios al padre cuando se seleccione una nueva fecha
const emitirCambio = (newValue) => {
  selectedDate.value = newValue;
  emit("update:modelValue", newValue);
};
</script>