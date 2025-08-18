<template>
  <input
    ref="inputRef"
    type="text"
    v-model="displayValue"
    @input="handleInput"
    @blur="formatValue"
    @focus="selectAll"
    placeholder="00.00"
    :class="{ 'error': error }"
  />
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
  modelValue: {
    type: [Number, String], // Acepta ambos tipos
    default: 0
  },
  error: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])

const inputRef = ref(null)
const displayValue = ref('')

// Convertir el valor inicial
const parseInitialValue = (value) => {
  if (typeof value === 'string') {
    return parseFloat(value) || 0
  }
  return value
}

// Métodos
const handleInput = (event) => {
  let value = event.target.value.replace(/[^0-9.]/g, '')
  const decimalParts = value.split('.')
  
  if (decimalParts.length > 2) {
    value = decimalParts[0] + '.' + decimalParts.slice(1).join('')
  }
  
  if (decimalParts.length === 2) {
    value = decimalParts[0] + '.' + decimalParts[1].slice(0, 2)
  }
  
  displayValue.value = value
  // Emitir el valor como string (opcional, puedes emitir como número)
  emit('update:modelValue', value)
}

const formatValue = () => {
  if (!displayValue.value) {
    displayValue.value = '00.00'
    emit('update:modelValue', 0)
    return
  }
  
  const numericValue = parseFloat(displayValue.value) || 0
  displayValue.value = numberToFormat(numericValue)
  emit('update:modelValue', numericValue) // Emitir como número
}

const numberToFormat = (num) => {
  return num.toFixed(2).padStart(5, '0')
}

const selectAll = () => {
  inputRef.value.select()
}

// Watchers
watch(() => props.modelValue, (newVal) => {
  const numericValue = typeof newVal === 'string' ? parseFloat(newVal) || 0 : newVal
  displayValue.value = numberToFormat(numericValue)
}, { immediate: true })

// Inicialización
onMounted(() => {
  const initialValue = parseInitialValue(props.modelValue)
  displayValue.value = numberToFormat(initialValue)
})
</script>

<style scoped>
input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  text-align: right;
  width: 100px;
  transition: border-color 0.3s;
}

input.error {
  border-color: #ff4444;
  background-color: #ffeeee;
}

input:focus {
  outline: none;
  border-color: #4285f4;
  box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
}
</style>