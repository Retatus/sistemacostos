<template>
  <div class="flex justify-between items-center gap-4 mt-5 mb-5 px-5">
      <!-- Mostrar el total de registros -->
      <span>Total de registros : {{ localPaginate.total }}</span>

      <!-- Controles de paginación -->
      <div v-if="localPaginate.last_page > 1" class="flex items-center gap-4">
          <!-- Botón "Anterior" -->
          <SecondaryButton 
              @click="changePage(localPaginate.current_page - 1)"
              :disabled="localPaginate.current_page === 1"
              :class="{ 'opacity-50 cursor-not-allowed': localPaginate.current_page === 1 }">
              Anterior
          </SecondaryButton>

          <!-- Información de la página actual -->
          <span>Página {{ localPaginate.current_page }} de {{ localPaginate.last_page }}</span>

          <!-- Botón "Siguiente" -->
          <SecondaryButton 
              @click="changePage(localPaginate.current_page + 1)"
              :disabled="localPaginate.current_page === localPaginate.last_page"
              :class="{ 'opacity-50 cursor-not-allowed': localPaginate.current_page === localPaginate.last_page }">
              Siguiente
          </SecondaryButton>
      </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue';
import { router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

// Props: Recibe los datos de paginación
const props = defineProps({
  paginate: {
      type: Object,
      required: true,
  },
  paginatedDataKey: {
      type: String,
      required: true,
  },
});

// Emit para actualizar los datos en el padre
const emit = defineEmits(['update:data']);

// Clonar `paginate` para evitar problemas de reactividad
const localPaginate = ref({ ...props.paginate });
const pageData = ref(localPaginate.value.data);

// Observa cambios en la paginación y emite los datos actualizados
watch(() => props.paginate, (newPaginate) => {
  localPaginate.value = { ...newPaginate };
  pageData.value = localPaginate.value.data;
  emit('update:data', pageData.value);
}, { deep: true });

// Función para cambiar de página
function changePage(page) {
  if (page > 0 && page <= localPaginate.value.last_page) {
      router.get(window.location.pathname, { page }, {
          preserveScroll: true,
          preserveState: true,
          onSuccess: (pageResponse) => {
              const updatedData = pageResponse.props[props.paginatedDataKey];
              localPaginate.value = { ...updatedData };
              pageData.value = updatedData.data;
              emit('update:data', pageData.value);
          },
      });
  }
}
</script>
