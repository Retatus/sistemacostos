<template>
  <div :style="editorStyle">
    <textarea ref="editorElement"></textarea>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  width: {
    type: String,
    default: '100%'
  },
  height: {
    type: String,
    default: '150px'
  }
})

const emit = defineEmits(['update:modelValue'])

const editorElement = ref(null)
let editorInstance = null

// Estilo dinámico con scroll vertical
const editorStyle = computed(() => ({
  width: props.width,
  height: props.height,
  overflowY: 'auto',   // activa scroll vertical
  border: '1px solid #ccc',
  padding: '5px',
  boxSizing: 'border-box'
}))

onMounted(() => {
  ClassicEditor
    .create(editorElement.value, {
      toolbar: [
        'heading',        // Encabezados
        '|',
        'bold', 'italic', // 'underline', 'strikethrough', // Estilos básicos
        '|',
        'link', 'blockQuote', // Enlaces y citas
        '|',
        'bulletedList', 'numberedList', // 'todoList', // Listas
        '|',
        'insertTable', 'imageUpload', // Tablas e imágenes
        '|',
        'undo', 'redo' // Deshacer / Rehacer
      ]
    })
    .then(editor => {
      editorInstance = editor
      editor.setData(props.modelValue)

      editor.model.document.on('change:data', () => {
        emit('update:modelValue', editor.getData())
      })
    })
    .catch(error => console.error(error))
})

onBeforeUnmount(() => {
  if (editorInstance) {
    editorInstance.destroy().catch(err => console.error(err))
  }
})
</script>
