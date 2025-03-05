<template>
  <div class="flex items-center">
    <button type="button" @click="decrementar" class="mt-1 p-2 bg-gray-200 rounded-l-md hover:bg-gray-300">
      -
    </button>

    <!-- Input -->
    <input
      v-model="localValue"
      type="text"
      :id="id"
      :required="required"
      class="mt-1 block w-full border-gray-300 shadow-sm text-center"
      :placeholder="placeholder"
      readonly
    />

    <!-- Botón para incrementar -->
    <button type="button" @click="incrementar" class="mt-1 p-2 bg-gray-200 rounded-r-md hover:bg-gray-300">
      +
    </button>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

// Definir las props
const props = defineProps({
  modelValue: {
    type: Number,
    required: true,
  },
  id: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
});

// Emitir eventos para actualizar el valor en el componente padre y notificar la acción realizada
const emit = defineEmits(['update:modelValue', 'accion-realizada']);

// Variable local para manejar el valor del input
const localValue = ref(props.modelValue);

// Método para incrementar
const incrementar = () => {
  localValue.value++;
  emit('update:modelValue', localValue.value);
  emit('accion-realizada', { accion: 'incremento', id: props.id }); // Emitir la acción y el id
};

// Método para decrementar
const decrementar = () => {
  if (localValue.value > 0) {
    localValue.value--;
    emit('update:modelValue', localValue.value);
    emit('accion-realizada', { accion: 'decremento', id: props.id }); // Emitir la acción y el id
  }
};

// Observar cambios en la prop `modelValue` para sincronizar el valor local
watch(
  () => props.modelValue,
  (newValue) => {
    localValue.value = newValue;
  }
);
</script>