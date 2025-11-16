<template>
  <div class="custom-select relative w-full text-xs">
    <!-- Selector visible -->
    <div class="selected-option border rounded px-2 py-1 cursor-pointer" @click="toggleDropdown">
      {{ selectedPasajero?.nombre || 'Pasaejeros asignados' }}
      <span class="float-right">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-2 h-4 w-4 inline-block ml-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
      </span>      
    </div>

    <!-- Dropdown -->
    <div v-if="isOpen" class="dropdown absolute z-10 bg-white border mt-1 w-full max-h-40 overflow-y-auto shadow">
      <div
        v-for="pasajero in assignedPasajerosList"
        :key="pasajero.id || pasajero.temp_id"
        class="dropdown-item flex justify-between items-center px-2 py-1 hover:bg-gray-100"
      >
        <span @click="selectPasajero(pasajero)" class="cursor-pointer flex-1">
          {{ pasajero.nombre }}
        </span>
        <button
          @click.stop="removePasajeroFromService(pasajero.id || pasajero.temp_id)">
          &times;
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    assignedPasajerosList: Array,
  },
  data() {
    return {
      isOpen: false,
      selectedPasajero: null,
    };
  },
  methods: {
    toggleDropdown() {
      this.isOpen = !this.isOpen;
    },
    selectPasajero(pasajero) {
      this.selectedPasajero = pasajero;
      this.isOpen = false;
    },
    removePasajeroFromService(id) {
      this.$emit('remove', id);
    },
  },
};
</script>

<style scoped>
.custom-select {
  position: relative;
  line-height: 1rem;
}

.dropdown {
  border: 1px solid #ccc;
  border-radius: 4px;
}

.dropdown-item {
  border-bottom: 1px solid #eee;
}

.dropdown-item:last-child {
  border-bottom: none;
}
</style>