<template>
  <div class="block text-sm font-medium text-gray-700">
    <label v-if="label" class="font-bold">{{ label }}</label>
    <VueDatepicker 
      v-model="fechaInterna" 
      :format="formatearFecha"
      :locale="es" 
      @update:modelValue="emitirCambio"
      :class="'mt-1 w-full border-gray-300 rounded-md shadow-sm'"
    />
  </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import VueDatepicker from "vue3-datepicker";
import { es } from "date-fns/locale";
import { format } from "date-fns"; // Importamos la función format de date-fns

const props = defineProps({
  modelValue: [String, Date, null],
  label: String,
  format: {
    type: String,
    default: "dd/MM/yyyy",
  }
});

const emit = defineEmits(["update:modelValue"]);

const fechaInterna = ref(props.modelValue ? ajustarZonaHoraria(props.modelValue) : null);

function ajustarZonaHoraria(fechaString) {
    const fecha = new Date(fechaString);
    fecha.setHours(fecha.getHours() + fecha.getTimezoneOffset() / 60); // Ajuste a la hora local
    return fecha;
}
// Función para formatear la fecha
const formatearFecha = computed(() => {
  return fechaInterna.value ? format(fechaInterna.value, props.format) : "";
});

// Emitir cambios al padre
const emitirCambio = () => {
  emit("update:modelValue", fechaInterna.value ? format(fechaInterna.value, "yyyy-MM-dd") : null);
};

// Sincronizar cambios cuando cambia el prop
watch(() => props.modelValue, (newVal) => {
  fechaInterna.value = newVal ? new Date(newVal) : null;
});
</script>
