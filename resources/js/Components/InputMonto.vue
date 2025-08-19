<template>
  <input
    ref="inputRef"
    type="text"
    v-model="displayValue"
    @input="handleInput"
    @blur="formatValue"
    @focus="handleFocus"
    placeholder="0.00"
  />
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
  modelValue: {
    type: [Number, String],
    default: 0
  }
})

const emit = defineEmits(['update:modelValue'])

const inputRef = ref(null)
const displayValue = ref('')
const lastPosition = ref(0)

// Métodos
const handleInput = (event) => {
  const { value, selectionStart } = event.target
  let newValue = value.replace(/[^0-9.]/g, '')
  
  // Manejar múltiples puntos decimales
  const parts = newValue.split('.')
  if (parts.length > 2) {
    newValue = parts[0] + '.' + parts.slice(1).join('')
  }
  
  // Limitar decimales a 2
  if (parts.length === 2) {
    newValue = parts[0] + '.' + parts[1].slice(0, 2)
  }
  
  // Guardar posición del cursor antes de actualizar
  lastPosition.value = selectionStart
  
  displayValue.value = newValue
  emitValue(newValue)
  
  // Restaurar posición del cursor después de la actualización
  nextTick(() => {
    inputRef.value.setSelectionRange(lastPosition.value, lastPosition.value)
  })
}

const handleFocus = (event) => {
  // Seleccionar todo al hacer focus o colocar cursor donde se hizo click
  if (event.target.value === '0.00') {
    event.target.select()
  } else {
    const clickPosition = event.target.selectionStart
    lastPosition.value = clickPosition
  }
}

const formatValue = () => {
  if (!displayValue.value || displayValue.value === '.') {
    displayValue.value = '0.00'
    emitValue(0)
    return
  }
  
  let numericValue = parseFloat(displayValue.value)
  if (isNaN(numericValue)) {
    numericValue = 0
  }
  
  displayValue.value = numericValue.toFixed(2)
  emitValue(numericValue)
}

const emitValue = (value) => {
  const numericValue = typeof value === 'string' ? parseFloat(value) || 0 : value
  emit('update:modelValue', numericValue)
}

// Watchers
watch(() => props.modelValue, (newVal) => {
  const numericValue = typeof newVal === 'string' ? parseFloat(newVal) || 0 : newVal
  displayValue.value = numericValue.toFixed(2)
}, { immediate: true })

// Inicialización
onMounted(() => {
  formatValue()
})
</script>

<style scoped>
input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  text-align: right;
  width: 120px;
  transition: border-color 0.3s;
}

input:focus {
  outline: none;
  border-color: #4285f4;
  box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
}
</style>