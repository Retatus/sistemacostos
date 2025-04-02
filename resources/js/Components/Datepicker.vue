<template>
  <div class="block text-sm font-medium text-gray-700">
    <label v-if="label" class="font-bold">{{ label }}</label>
    <VueDatePicker 
      v-model="selectedDate"
      :format-locale="es"
      :timezone="timeZone"
      :format="formatearFecha"
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

const selectedDate = ref(new Date());
const timeZone = 'America/Lima'; // Zona horaria de Lima

const props = defineProps({
  modelValue: [String, Date, null],
  label: String,
  format: {
    type: String,
    default: "dd/MM/yyyy",
  }
});

const emit = defineEmits(["update:modelValue"]);

// Función para formatear la fecha
const formatearFecha = computed(() => {
  return selectedDate.value ? format(selectedDate.value, props.format) : "";
});

// Emitir cambios al padre
const emitirCambio = () => {
  emit("update:modelValue", selectedDate.value ? format(selectedDate.value, "yyyy-MM-dd") : null);
};

</script>
