<template>
  <div class="space-y-3">

    <!-- CATEGORÍA -->
    <div class="space-y-1">
      <header-label
        label="Categoría"
        :id="modelValue.proveedor_categoria_id"
      />

      <select
        v-model="local.proveedor_categoria_id"
        @change="onCategoriaChange"
        :disabled="loadingProveedores"
        class="custom-select w-full px-3 py-2 text-sm border rounded-lg"
        :class="loadingProveedores ? 'bg-gray-50 border-gray-200' : 'border-gray-300'"
      >
        <option disabled value="0">Seleccionar categoría</option>
        <option
          v-for="c in categorias"
          :key="c.value"
          :value="c.value"
        >
          {{ c.label }}
        </option>
      </select>

      <loading-text
        v-if="loadingProveedores"
        text="Cargando proveedores..."
      />
    </div>

    <!-- PROVEEDOR -->
    <div class="space-y-1">
      <header-label
        label="Proveedor"
        :id="local.proveedor_id"
      />

      <select
        v-model="local.proveedor_id"
        @change="onProveedorChange"
        :disabled="loadingServicios"
        class="custom-select w-full px-3 py-2 text-sm border rounded-lg"
        :class="loadingServicios ? 'bg-gray-50 border-gray-200' : 'border-gray-300'"
      >
        <option disabled value="0">
          {{ proveedores.length ? 'Seleccionar proveedor' : 'Seleccione una categoría' }}
        </option>

        <option
          v-for="p in proveedores"
          :key="p.value"
          :value="p.value"
        >
          {{ p.label }}
        </option>
      </select>

      <loading-text
        v-if="loadingServicios"
        text="Cargando servicios..."
      />
    </div>

    <!-- SERVICIO -->
    <div class="space-y-1">
      <header-label
          label="Servicio"
          :id="local.servicio_id"
        />
      <div class="flex justify-between items-center">
        <!-- <button
          type="button"
          class="text-xs text-gray-500 hover:text-gray-700"
          @click="limpiarServicio"
        >
          Limpiar
        </button> -->
      </div>

      <select
        v-model="local.servicio_id"
        @change="onServicioChange"
        :disabled="!local.proveedor_id || servicios.length === 0"
        class="custom-select w-full px-3 py-2 text-sm border rounded-lg"
        :class="(!local.proveedor_id || servicios.length === 0)
          ? 'bg-gray-50 border-gray-200'
          : 'border-gray-300'"
      >
        <option disabled value="0">
          {{ servicios.length ? 'Seleccionar servicio' : 'Seleccione proveedor' }}
        </option>

        <option
          v-for="s in servicios"
          :key="s.value"
          :value="s.value"
        >
          {{ s.label || s.nombre }}
        </option>

        <option value="__add_new__" class="text-green-700 font-medium">
          ➕ Agregar nuevo servicio
        </option>
      </select>
    </div>

    <!-- BOTÓN -->
    <button
      type="button"
      @click="$emit('guardar', { proveedor_categoria_id: local.proveedor_categoria_id, proveedor_id: local.proveedor_id, servicio_id: local.servicio_id })" 
      :disabled="guardando"
      class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg"
    >
      {{ guardando ? 'Guardando...' : 'Aplicar cambios' }}
    </button>

  </div>
</template>

<script setup>
import { reactive, watch } from 'vue'

import HeaderLabel from '@/Components/Cotizacion/HeaderLabel.vue'
import LoadingText from '@/Components/Cotizacion/LoadingText.vue'

const props = defineProps({
  modelValue: { type: Object, required: true },

  categorias: { type: Array, default: () => [] },
  proveedores: { type: Array, default: () => [] },
  servicios: { type: Array, default: () => [] },

  loadingProveedores: Boolean,
  loadingServicios: Boolean,
  guardando: Boolean
})

const emit = defineEmits([
  'update:modelValue',
  'change-categoria',
  'change-proveedor',
  'change-servicio',
  'guardar'
])

const local = reactive({ ...props.modelValue })

watch(
  () => props.modelValue,
  v => Object.assign(local, v),
  { deep: true }
)

watch(
  local,
  v => emit('update:modelValue', v),
  { deep: true }
)

function onCategoriaChange() {
  emit('change-categoria', local.proveedor_categoria_id)
}

function onProveedorChange() {
  emit('change-proveedor', local.proveedor_id )
}

function onServicioChange() {
  emit('change-servicio', local.servicio_id)
}

function limpiarServicio() {
  local.servicio_id = 0
}
</script>
