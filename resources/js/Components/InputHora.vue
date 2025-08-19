<!-- TimeInput.vue -->
<template>
  <input
    class="time-input mt-1 w-full border-gray-300 rounded-md shadow-sm"
    :class="{ valid: isValid, invalid: showInvalid }"
    type="text"
    :value="inputValue"
    placeholder="HH:MM"
    @input="onInput"
    @blur="onBlur"
    @keydown="onKeyDown"
    @focus="$event.target.select()"
  />
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['update:modelValue']);

const inputValue = ref(props.modelValue || '');
const hasBlurred = ref(false);
const timeRegex = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/;

const isValid = computed(() => timeRegex.test(inputValue.value));
const showInvalid = computed(() => hasBlurred.value && inputValue.value !== '' && !isValid.value);

watch(() => props.modelValue, (newValue) => {
  inputValue.value = newValue || '';
});

const formatTimeInput = (value) => {
  // Limitar a máximo 4 dígitos sin contar ':'
  const digits = value.replace(/\D/g, '').substring(0, 4);
  if (digits.length === 0) return '';
  if (digits.length <= 2) return digits;

  const hours = digits.substring(0, 2);
  const minutes = digits.substring(2, 4);

  const validHours = Math.min(parseInt(hours), 23);
  const formattedHours = validHours.toString().padStart(2, '0');

  return `${formattedHours}:${minutes}`.substring(0, 5);
};

const onInput = (event) => {
  let formatted = formatTimeInput(event.target.value);
  if (formatted.length > 5) {
    formatted = formatted.substring(0, 5);
  }
  inputValue.value = formatted;
  emit('update:modelValue', formatted);
};

const onBlur = () => {
  hasBlurred.value = true;

  if (inputValue.value.length === 1) {
    inputValue.value = `0${inputValue.value}:00`;
    emit('update:modelValue', inputValue.value);
  } else if (inputValue.value.length === 2) {
    inputValue.value = `${inputValue.value}:00`;
    emit('update:modelValue', inputValue.value);
  }
};

const onKeyDown = (event) => {
  if ([8, 9, 13, 37, 38, 39, 40, 46].includes(event.keyCode)) return;

  // Solo permitir números
  if (event.keyCode < 48 || event.keyCode > 57) {
    if (event.keyCode < 96 || event.keyCode > 105) {
      event.preventDefault();
    }
  }

  // Limitar la longitud a 5 caracteres
  const currentLength = inputValue.value.length;
  const allowedKeys = [8, 37, 38, 39, 40, 46]; // borrar, flechas
  if (currentLength >= 5 && !allowedKeys.includes(event.keyCode)) {
    event.preventDefault();
  }
};
</script>

<style scoped>
/* .time-input {
  padding: 6px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 80px;
} */

/* .time-input.valid {
  border-color: green;
} */

.time-input.invalid {
  border-color: red;
}
</style>
