<template>
  <div class="fixed inset-0 flex justify-center items-start bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mt-10">
      <h2 class="text-xl font-semibold mb-1 text-gray-800">
        {{ mode === 'edit' ? 'Editar servicio id ' + id : 'Crear servicio id ' + id }}
      </h2>
      <p v-if="responseMessage" class="alert alert-success text-sm text-green-600">
        {{ responseMessage }}
      </p>
      
      <div class="space-y-2 mt-1">
        <label class="block text-sm font-medium text-gray-700">
          observacion
        </label>
        <textarea
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          name="observacion" rows="3" v-model="form.observacion" @input="emitChange" placeholder="ingrese observacion">
        </textarea>

        <label class="block text-sm font-medium text-gray-700">
          estatus
        </label>
        <select v-model="form.estatus" @change="emitChange"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          :class="{
            'p-2 font-medium rounded-full border-rounded text-gray-900 text-left': true,
            'bg-yellow-400': form.estatus == 0,
            'bg-green-500': form.estatus == 1,
            'bg-red-400': form.estatus == 2 || form.estatus == 3,
          }">
          <option value="0" class="bg-yellow-600 text-white">PENDIENTE</option>
          <option value="1" class="bg-green-600 text-white">CONFIRMADA</option>
          <option value="2" class="bg-red-600 text-white">CANCELADA</option>
          <option value="3" class="bg-red-600 text-white">XPASAJERO</option>
        </select>
      </div>

      <!-- Botones de acción -->
      <div class="flex justify-end gap-3 mt-4">
        <button @click="updateStatus" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          {{ mode === 'edit' ? 'Actualizar' : 'Guardar' }}
        </button>

        <button type="button" @click="emit('cerrar')"
          class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, reactive, watch } from 'vue';
  import axios from "axios";

  const props = defineProps({
    id: { type: [String, Number], default: null },
    nroDia: { type: [String, Number], required: true },
    servicio: { type: Object }, // ahora recibe objeto
    mode: { type: String, default: "create" },
  })

  const responseMessage = ref('');
  const emit = defineEmits(['guardar', 'cerrar'])

  // copia local reactiva
  const form = reactive({
    estatus: '0',
    observacion: ''
  })

  // cuando cambia el servicio, sincronizamos el form
  watch(() => props.servicio, (nuevo) => {
    console.log('Servicio cambiado:', nuevo);
    if (nuevo) {
      form.estatus = nuevo.estatus
      form.observacion = nuevo.observacion
    }
  },
    { immediate: true }
  )

  async function updateStatus() {
    if (props.mode === 'create') {
        props.servicio.estatus = form.estatus
        props.servicio.observacion = form.observacion

        emit('guardar', props.servicio)
      return;
    }else {    
      const res = await axios.patch(route('pasajero_servicio.update', props.id), // id del recurso
        {
          nro_dia: props.nroDia,
          cotizacion_id: props.servicio.cotizacion_id,
          nro_orden: props.servicio.nro_orden,
          observacion: form.observacion,
          estatus: form.estatus
        }
      )
      responseMessage.value = res.data.message ?? 'Guardado correctamente.'
      setTimeout(() => {
        responseMessage.value = ''
        // mutamos el objeto original (reactivo)
        props.servicio.estatus = form.estatus
        props.servicio.observacion = form.observacion

        emit('guardar', props.servicio)
      }, 1000)
    }
  }
</script>