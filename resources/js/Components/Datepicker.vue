<template>
  <div class="block text-sm font-medium text-gray-700">
    <label v-if="label" class="font-bold">{{ label }}</label>
    <VueDatePicker 
      v-model="formattedDate"
      :format-locale="es"
      :format="displayFormat"
      :masks="masks"
      :disabled="disabled"
      :disabled-dates="desactivarFechas" 
      auto-apply
      @fecha-cambiada="manejarCambioFecha"
      :class="'mt-1 w-full border-gray-300 rounded-md shadow-sm'"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css';
import { es } from "date-fns/locale";
import dayjs from 'dayjs'

// Props del componente
const props = defineProps({
  modelValue: {
    type: Date,
    default: () => new Date()
  },
  label: String,
  disabled: { type: Boolean, default: false },
  emitirEventoCambio: { type: Boolean, default: false }
})

// Emit para propagar cambios hacia el padre
const emit = defineEmits(['update:modelValue', 'fecha-cambiada'])

// Función para desactivar fechas menores a hoy
const desactivarFechas = (date) => {
  const hoy = dayjs().toDate();
  //const hoy = dayjs().tz("America/Lima").toDate();
  return date <= hoy;
};
// Computed para vincular el v-model del VueDatePicker con el modelValue
const formattedDate = computed({
  get: () => props.modelValue,
  set: (value) => {
    emit('update:modelValue', value)
    if (props.emitirEventoCambio) {
      emit('fecha-cambiada', value)
    }
  }
})

// Formato visual
const displayFormat = 'dd-MM-yyyy'

// Formato para máscaras del input
const masks = {
  input: 'DD-MM-YYYY'
}

function manejarCambioFecha(nuevaFecha) {
  emit('update:modelValue', nuevaFecha)
  emit('fecha-cambiada', nuevaFecha) // Este es el evento personalizado que escucha el padre
}



</script>