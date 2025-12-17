<template>
  <div class="fixed inset-0 flex justify-center items-start bg-black bg-opacity-50 z-50">
    <!-- @submit.prevent EVITA QUE LA PAGINA SE RECARGUE -->
    <form @submit.prevent="categorySaveUpdate"
          class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mt-10">

      <h2 class="text-xl font-semibold mb-1 text-gray-800">
        {{ mode === 'edit' ? 'Editar Status' : 'Crear Status' }}
      </h2>

        <template>
          <div v-if="responseMessage" class="alert alert-success">
            {{ responseMessage }}
          </div>
        </template>
        <div>                    
            <label class="block text-sm font-medium text-gray-700">
              observacion
            </label>
            
            <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              name="observacion"
              rows="3"             
              v-model="localServicio.observacion"
              @input="emitChange"
              placeholder="ingrese observacion">
            </textarea> 
            
            <label class="block text-sm font-medium text-gray-700">
              status
            </label>
            <select v-model="localServicio.estatus"
              @input="emitChange"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :class="{
                  'p-2 font-medium rounded-full border-rounded text-gray-900 text-left': true,
                  'bg-yellow-400': localServicio.estatus == 0,
                  'bg-green-500': localServicio.estatus == 1,
                  'bg-red-400': localServicio.estatus == 2 || localServicio.estatus == 3,
              }"
              >
              <option value="0" class="bg-yellow-600 text-white">PENDIENTE</option>
              <option value="1" class="bg-green-600 text-white">CONFIRMADA</option>
              <option value="2" class="bg-red-600 text-white">CANCELADA</option>
              <option value="3" class="bg-red-600 text-white">XPASAJERO</option>
            </select>
            <InputError class="mt-2" />                            
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
  import {ref, watch, reactive, computed, toRef } from "vue";
  import InputError from '@/Components/InputError.vue';
  import { Link, useForm, usePage } from '@inertiajs/vue3';
  
  const props = defineProps({
    nroDia: { type: Number, default: 1 },
    pasajeroServicio: { type: Object }, // ahora recibe objeto
    mode: { type: String, default: "create" },
  });

  const responseMessage = ref('');
  const emit = defineEmits(["close", 'update:pasajeroServicio']);

  // Copia reactiva local
  const localServicio = reactive({ ...props.pasajeroServicio })

  // Emitir cambios cada vez que se edite
  function emitChange() {
    emit('update:pasajeroServicio', { ...localServicio })
  }

  const initialValues = reactive({
    id: 1,
    nro_dia: props.nroDia,
    cotizacion_id: localServicio.cotizacion_id,
    nro_orden: localServicio.nro_orden,
    observacion: localServicio.observacion,
    estatus: localServicio.estatus
  })

  const form = useForm(initialValues)

  watch(localServicio, (nuevo) => {
    form.cotizacion_id = nuevo.cotizacion_id
    form.nro_orden     = nuevo.nro_orden
    form.observacion   = nuevo.observacion
    form.estatus       = nuevo.estatus
  }, { deep: true })

  const categorySaveUpdate = () => {
    form.patch(route('pasajero_servicio.update', initialValues), {
      onSuccess: (res) => {
        responseMessage.value = res?.props?.message ?? 'Guardado correctamente.'
        setTimeout(() => {
          responseMessage.value = ''
          closeModal();
        }, 2000)
      },
      onError: () => {
        responseMessage.value = 'Error al guardar los datos.'
      }
    })
  }  

  const closeModal = () => emit("close");

  // Mantener sincronía si el padre cambia desde fuera
  watch(() => props.pasajeroServicio, (newVal) => {
    Object.assign(localServicio, newVal)
  })

</script>

