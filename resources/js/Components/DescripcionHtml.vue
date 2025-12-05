<template>
  <div :style="containerStyle" v-html="contenido"></div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  contenido: {
    type: String,
    default: ''
  },
  height: {
    type: String,
    default: '200px' // altura por defecto
  },
  width: {
    type: String,
    default: '100%' // ancho por defecto
  }
})

// Estilo dinámico
const containerStyle = computed(() => ({
  width: props.width,
  height: props.height,
  overflowY: 'auto',   // scroll vertical si se excede la altura
  border: '1px solid #ccc',
  padding: '10px',
  boxSizing: 'border-box',
  backgroundColor: '#fff'
}))
</script>