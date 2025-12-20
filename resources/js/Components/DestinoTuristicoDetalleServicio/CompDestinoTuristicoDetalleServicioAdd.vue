<template>
  <!-- Header -->
  <div class="px-4 py-3 border-b">
      <h2 class="text-lg font-semibold text-gray-700">Agregar servicio</h2>
  </div>
  <!-- Body -->
  <div class="overflow-x-auto py-0">
    <div class="grid grid-cols-8 gap-4 w-full p-5">
      <div class="col-span-1">
        <label class="block text-xs font-medium text-gray-700">Proveedor Categoria</label>
        <select v-model="selectedValueCategoria" @change="ListaCategoriaProveedor" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs">
          <option disabled value="">-- Selecciona una opción --</option>
          <option v-for="option in sProveedorCategorias" :key="option.value" :value="option.value">
          {{ option.label }}
          </option>
        </select>
      </div>
      <div class="col-span-2">
        <label class="block text-xs font-medium text-gray-700">Proveedor</label>
        <select v-model="selectedValueProveedor" @change="ListaProveedorServicio" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs">
          <option disabled value="">-- Selecciona una opción --</option>
          <option v-for="option in ListaProveedorXCategoria" :key="option.value" :value="option.value">
          {{ option.label }}
          </option>
        </select>
      </div>
      <div class="col-span-4 ">
        <label class="block text-xs font-medium text-gray-700">Servicio detalle</label>
        <select v-model="selectedValueServicio" @change="ServicioMonto" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs">
            <option disabled value="">-- Selecciona una opción --</option>
            <option v-for="option in ListaServiciosXProveedor" :key="option.value" :value="option.value" :data-moneda="option.moneda" :data-monto="option.monto">
            {{ option.label }}
            </option>
        </select>
      </div>
      <div class="col-span-1">
        <label class="block text-xs font-medium text-gray-700">&nbsp;</label>
        <PrimaryButton
          type="button"
          class="mt-1"
          @click="agregarDestinoTuristicoDetalleServicio">
          Agregar
        </PrimaryButton>
      </div>
    </div>
    <div class="px-4 py-3">
      <table className="excel-table w-full text-sm text-left rtl:text-right text-gray-500">
        <thead className="text-xs text-gray-900 uppercase bg-gray-50">
          <tr class="bg-gray-100">
            <th class="w-2/12 px-4 py-2">Categoria</th>
            <th class="w-3/12 px-4 py-2">Proveedor</th>
            <th class="w-4/12 px-4 py-2">Servicio detalle</th>
            <th class="w-1/12 px-4 py-2">Costo</th>
            <th class="w-1/12 px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in itinerarioServicios" :key="index" className="bg-white border-b text-gray-900">
            <td class="px-1">
                <select v-model="item.proveedor_categoria_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in sProveedorCategorias" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-1">
                <select v-model="item.proveedor_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in Lista_proveedor" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-1">
                <select v-model="item.servicio_id" class="w-full border-gray-300 rounded-md shadow-sm text-xs">
                  <option disabled value="">-- Selecciona una opción --</option>
                  <option v-for="option in Lista_servicio" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
            </td>
            <td class="px-1">
              <div class="relative mt-1">
                <!-- Input alineado a la derecha -->
                <input v-model="item.monto" @input="calcularTotal" type="text" required class="w-full border-gray-300 text-black font-bold rounded-md shadow-sm text-xs text-right"/>
                <!-- Span alineado a la izquierda -->
                <span :class="{ 'text-right text-green-500': item.moneda === 'USD', 'text-left text-blue-500': item.moneda === 'PEN' }" 
                class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs">{{ item.moneda }}</span>
              </div>
            </td>
            <td class="px-1 hover:text-red-700 text-center">
              <button type ="button" @click="removeItem(index)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Footer -->
  <div class="px-4 border-t text-right">
    <PrimaryButton @click="closeModal" type="button" class="mt-4 btn btn-secondary">
      Cerrar
    </PrimaryButton>
  </div>
</template>
<script setup>
import { ref, watch } from 'vue';
import PrimaryButton from '../PrimaryButton.vue';
import { defineProps, defineEmits } from 'vue';
import { useCategoriesStore } from '@/Stores/categories';
const categoriesStore = useCategoriesStore();

const props = defineProps({
    Lista_proveedor: {
      type: Object,
      required: true,
    },
    Lista_servicio: {
      type: Object,
      required: true,
    },
    itinerarioServicios: {
      type: Array,
      required: true,
    },
  });

  const sProveedorCategorias = ref([...categoriesStore.globals.proveedor_categories]);

  const emit = defineEmits(['close', 'update', 'actualizarTotal']); // Define el evento que vas a emitir

  const ListaServiciosXProveedor = ref("");
  const ListaProveedorXCategoria = ref("");

  const selectedValueCategoria = ref("");
  const selectedValueProveedor = ref("");
  const selectedValueServicio = ref("");
  const selectedValueServicioMoneda = ref("");
  const selectedValueServicioMonto = ref("");
  const selectedValueServicioObservacion = ref("");

  const destinoTuristicoDetalleServicio = ref({
    nro_orden: props.itinerarioServicios.length > 0 ? props.itinerarioServicios[props.itinerarioServicios.length - 1].nro_orden + 1 : 1,
    proveedor_categoria_id: '',
    proveedor_id: '',
    servicio_id: '',
    itinerario_destino_id: '',
    observacion: '',
    moneda: '',
    monto: 0.00,
  });

  // Sincronizar los valores individuales con el objeto principal
  watch([selectedValueCategoria, selectedValueProveedor, selectedValueServicio, selectedValueServicioMoneda, selectedValueServicioMonto, selectedValueServicioObservacion],
    ([categoriaTemp, proveedorTemp, servicioTemp, monedaTemp, costoTemp, observacionTemp]) => {
      destinoTuristicoDetalleServicio.value.proveedor_categoria_id = categoriaTemp;
      destinoTuristicoDetalleServicio.value.proveedor_id = proveedorTemp;
      destinoTuristicoDetalleServicio.value.servicio_id = servicioTemp;
      destinoTuristicoDetalleServicio.value.moneda = monedaTemp;
      destinoTuristicoDetalleServicio.value.monto = costoTemp;
      destinoTuristicoDetalleServicio.value.observacion = observacionTemp;
    }
  );

  function agregarDestinoTuristicoDetalleServicio() {
    props.itinerarioServicios.push({ ...destinoTuristicoDetalleServicio.value });
      // Reiniciar los valores individuales y el objeto
      // selectedValueCategoria.value = '';
      // selectedValueProveedor.value = '';
      // selectedValueServicio.value = '';
    // destinoTuristicoDetalleServicio.value = {
    //     nro_orden: destinoTuristicoDetalleServicio.value.nro_orden + 1,
    //     proveedor_categoria_id: '',
    //     proveedor_id: '',
    //     servicio_id: '',
    //     itinerario_destino_id: '',
    //     observacion: '',
    //     moneda: '',
    //     monto: 0.00,
    // };
    calcularTotal();
  }

  function closeModal() {
      emit('close');
  }

  const removeItem = (index) => {
    props.itinerarioServicios.splice(index, 1);
    emit('update', props.itinerarioServicios);
    calcularTotal();
  }

  function ServicioMonto() {
    const selectElement = event.target;
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const moneda = selectedOption.getAttribute('data-moneda');
    const monto = selectedOption.getAttribute('data-monto');
    selectedValueServicioMoneda.value = moneda;
    selectedValueServicioMonto.value = monto;
    selectedValueServicioObservacion.value = selectElement.options[selectElement.selectedIndex].label;
  };

  const calcularTotal = () => {
    const total = props.itinerarioServicios.reduce((
      suma, destinoTuristicoDetalleServicio) => suma + parseFloat(destinoTuristicoDetalleServicio.monto || 0), 0 );
    emit("actualizarTotal", total); // Emitir el total al componente Hijo
  };
  async function ListaCategoriaProveedor() {
      try {
          const data = {
              proveedor_categoria_id: destinoTuristicoDetalleServicio.value.proveedor_categoria_id,
          }
          const response = await axios.post(`${route('proveedor')}/proveedorList`, data);
          if (response.status === 200) {
              ListaProveedorXCategoria.value = response.data;
          }
      } catch (error) {
          console.error('Error al actualizar los datos:', error);
      }
  };

  async function ListaProveedorServicio() {
      try {
          const data = {
            proveedor_id: destinoTuristicoDetalleServicio.value.proveedor_id,
          }
          const response = await axios.post(`${route('servicio')}/servicioList`, data);
          if (response.status === 200) {
              //console.log('Listado de servicios:', response.data);
              ListaServiciosXProveedor.value = response.data;
          }
      } catch (error) {
          console.error('Error al actualizar los datos:', error);
      }
  };
</script>