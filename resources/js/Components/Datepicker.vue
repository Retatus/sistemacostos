<template>
  <div class="block text-sm font-medium text-gray-700">
    <label v-if="label" class="font-bold">{{ label }}</label>
    <VueDatePicker 
      :modelValue="selectedDate"
      :format-locale="es"
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
import dayjs from "dayjs";  // Usamos dayjs
import utc from "dayjs/plugin/utc"; // Plugin para UTC
import timezone from "dayjs/plugin/timezone"; // Plugin para zonas horarias

dayjs.extend(utc);
dayjs.extend(timezone);

// Props y valores iniciales
const props = defineProps({
  modelValue: [String, Date, null],
  label: String,
  disabled: { type: Boolean, default: false },
});

const emit = defineEmits(["update:modelValue"]);

// Variables reactivas
const selectedDate = ref(props.modelValue ? dayjs(props.modelValue).toDate() : new Date());
//const selectedDate = ref(props.modelValue ? dayjs(props.modelValue).tz("America/Lima").toDate() : new Date());

// Función para desactivar fechas menores a hoy
const desactivarFechas = (date) => {
  const hoy = dayjs().toDate();
  //const hoy = dayjs().tz("America/Lima").toDate();
  return date <= hoy;
};

// Computed para formatear la fecha en dd-MM-yyyy
const formatearFecha = computed(() => {
  return selectedDate.value ? dayjs(selectedDate.value).format("DD-MM-YYYY") : "";
  //return selectedDate.value ? dayjs(selectedDate.value).tz("America/Lima").format("DD-MM-YYYY") : "";
});

// Emitir cambios con formato correcto
const emitirCambio = (newValue) => {
  selectedDate.value = dayjs(newValue).toDate();
  emit("update:modelValue", dayjs(newValue).format("YYYY-MM-DD"));
  // selectedDate.value = dayjs(newValue).tz("America/Lima").toDate();
  // emit("update:modelValue", dayjs(newValue).tz("America/Lima").format("YYYY-MM-DD"));
};
</script>
