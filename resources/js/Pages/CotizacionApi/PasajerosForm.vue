<template>
  <div class="pasajeros-container">

    <h3>Pasajeros</h3>
    <button type="button" class="btn-add" @click="addPasajero">
      + Agregar pasajero
    </button>

    <table class="tabla-pasajeros">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>A. Paterno</th>
          <th>A. Materno</th>
          <th>Tipo Doc</th>
          <th>Nro Doc</th>
          <th>País</th>
          <th>Tipo Pasajero</th>
          <th>Clase</th>
          <th>Activo</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(p, index) in pasajeros" :key="index">

          <td>{{ index + 1 }}</td>

          <td>
            <input v-model="p.nombre" type="text" v-uppercase/>
          </td>

          <td>
            <input v-model="p.apellido_paterno" type="text" v-uppercase/>
          </td>

          <td>
            <input v-model="p.apellido_materno" type="text" v-uppercase/>
          </td>

          <td>
            <select v-model="p.documento_tipo_id">
              <option value="1">DNI</option>
              <option value="2">Pasaporte</option>
            </select>
          </td>

          <td>
            <input v-model="p.documento_numero" type="text" />
          </td>

          <td>
            <select v-model="p.pais_id">
              <option value="1">Perú</option>
              <option value="2">España</option>
            </select>
          </td>

          <td>
            <select v-model.number="p.tipo_pasajero_id">
              <option value='3'>Adulto</option>
              <option value='2'>Niño</option>
              <option value='1'>Estudiante</option>
            </select>
          </td>

          <td>
            <select v-model="p.clase_id">
              <option value="1">Económica</option>
              <option value="2">Business</option>
            </select>
          </td>

          <td>
            <select v-model="p.estado_activo">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </td>

          <td>
            <button type="button" class="btn-delete" @click="removePasajero(index)">
              🗑
            </button>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => []
  }
})

console.log('PasajerosForm - props.modelValue:', props.modelValue)

const emit = defineEmits(['update:modelValue'])

const pasajeros = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

function addPasajero() {
  const nuevo = {
    pasajero_index: pasajeros.value.length,
    nombre: "",
    apellido_paterno: "",
    apellido_materno: "",
    documento_tipo_id: 1,
    documento_numero: "",
    pais_id: 1,
    documento_file: null,
    temp_file_name: null,
    temp_file_preview: null,
    tipo_pasajero_id: 3,
    clase_id: 1,
    cotizacion_id: null,
    estado_activo: 1
  }

  pasajeros.value = [...pasajeros.value, nuevo]
}

function removePasajero(index) {
  const copia = [...pasajeros.value]
  copia.splice(index, 1)
  pasajeros.value = copia
}
</script>

<style scoped>
.tabla-pasajeros {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 15px;
}

.tabla-pasajeros th,
.tabla-pasajeros td {
  border: 1px solid #ccc;
  padding: 6px;
  text-align: left;
}

.tabla-pasajeros input,
.tabla-pasajeros select {
  width: 100%;
  padding: 4px;
  box-sizing: border-box;
}

.btn-add {
  padding: 8px 12px;
  background: #2d8cf0;
  color: white;
  border: none;
  cursor: pointer;
}

.btn-delete {
  padding: 4px 8px;
  background: #d9534f;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
