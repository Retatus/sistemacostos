<template>
  <div v-if="isOpen" class="fixed inset-0 flex justify-center items-start bg-black bg-opacity-50 z-50">
    <form @submit.prevent="categorySaveUpdate"
          class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mt-10">

      <h2 class="text-xl font-semibold mb-1 text-gray-800">
        {{ mode === 'edit' ? 'Editar Categoría' : 'Crear Categoría' }}
      </h2>

      <p v-if="responseMessage" class="text-sm text-green-600 mb-3">{{ responseMessage }}</p>

      <!-- Render dinámico de campos -->
      <div v-for="(field, index) in fields" :key="index" class="mb-3">
        <label :for="'field-' + index" class="block text-sm font-medium text-gray-700">
          {{ field.label }}
        </label>

        <input
          v-if="field.type === 'text'"
          type="text"
          v-model="form[field.name]"
          :placeholder="field.placeholder"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />

        <input
          v-else-if="field.type === 'number'"
          type="number"
          v-model="form[field.name]"
          :placeholder="field.placeholder"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />

        <select
          v-else-if="field.type === 'select'"
          v-model="form[field.name]"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
          <option v-for="option in field.options" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>

        <textarea
          v-else-if="field.type === 'textarea'"
          v-model="form[field.name]"
          :placeholder="field.placeholder"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        ></textarea>
      </div>

      <!-- Botones de acción -->
      <div class="flex justify-end gap-3 mt-4">
        <button type="submit"
          class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          {{ mode === 'edit' ? 'Actualizar' : 'Guardar' }}
        </button>

        <button type="button"
          @click="closeModal"
          class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
          Cancelar
        </button>
      </div>

    </form>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
  responseMessage: { type: String, default: '' },
  isOpen: { type: Boolean, default: false },
  fields: { type: Array, default: () => [] },
  initialValues: { type: Object, default: () => ({}) }, // ahora recibe objeto
  mode: { type: String, default: "create" },
});

const emit = defineEmits(["close", "saveupdate"]);

// Objeto form dinámico
const form = ref({});
const responseMessage = ref('');({});

const initializeForm = () => {
  form.value = {};
  props.fields.forEach(f => {
    form.value[f.name] = props.mode === "edit" && props.initialValues[f.name] !== undefined
      ? props.initialValues[f.name]
      : "";
  });
};

watch(() => [props.fields, props.initialValues, props.mode], initializeForm, { immediate: true });

let messageTimeout = null;

const categorySaveUpdate = () => {
  emit("saveupdate", { ...form.value }, (msg) => {
    // Callback de respuesta desde el padre
    responseMessage.value = msg;

    // Cerrar después de 2 segundos
    clearTimeout(messageTimeout);
    messageTimeout = setTimeout(() => {
      responseMessage.value = '';
      closeModal();
    }, 2000);
  });
}; 

// () => {
//   emit("saveupdate", { ...form.value });
//   closeModal();
// };

const closeModal = () => emit("close");
</script>

<!-- Ejemplo de uso desde el contenedor padre

<script setup>
import ModalForm from './ModalForm.vue'
import { ref } from 'vue'

const isOpen = ref(false)
const mode = ref('create')

// Campos enviados al componente
const categoryFields = [
  { name: 'nombre', label: 'Nombre', type: 'text', placeholder: 'Nombre de la categoría' },
  { name: 'descripcion', label: 'Descripción', type: 'textarea', placeholder: 'Describe la categoría' },
  { name: 'prioridad', label: 'Prioridad', type: 'number', placeholder: 'Nivel de prioridad' },
  { name: 'tipo', label: 'Tipo', type: 'select', options: [
      { value: 'general', label: 'General' },
      { value: 'especial', label: 'Especial' },
      { value: 'temporal', label: 'Temporal' }
  ] }
]

// Valores para editar
const editValues = ref({})

// Abrir modal en modo crear
const openCreate = () => {
  mode.value = 'create'
  editValues.value = {}
  isOpen.value = true
}

// Abrir modal en modo editar
const openEdit = (row) => {
  mode.value = 'edit'
  editValues.value = { ...row }
  isOpen.value = true
}

const saveUpdate = (data) => {
  console.log('Datos recibidos desde el modal:', data)
}
</script>

<template>
  <button @click="openCreate">Crear Categoría</button>

  <ModalForm
    :isOpen="isOpen"
    :fields="categoryFields"
    :initialValues="editValues"
    :mode="mode"
    @close="isOpen = false"
    @saveupdate="saveUpdate"
  />
</template>

-->
