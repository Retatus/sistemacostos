<template>
    <div class="container mx-auto">
        <form @submit.prevent="submitProveedor">
            <div class="grid grid-cols-3 gap-4 w-full p-5">
                <!-- Primera fila -->
                <div class="col-span-1 ">
                    <label for="nombre" class=" text-sm font-medium text-gray-700">Nombre</label>
                    <input v-model="destinoTuristico.nombre" type="text" id="nombre"
                        class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el Programa">
                </div>
                <div class="col-span-2 ">
                    <label for="descripcion" class=" text-sm font-medium text-gray-700">Descripcion</label>
                    <textarea v-model="destinoTuristico.descripcion" type="textarea" id="descripcion" required="true"
                        class="mt-1   w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Ingrese la Descripcion"></textarea>
                </div>

                <!-- Segunda fila -->
                <div class="col-span-1">
                    <label for="pais" class="block text-sm font-medium text-gray-700">Pais</label>
                    <select v-model="destinoTuristico.pais" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="pais">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in Pais" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="nro_dias" class="block text-sm font-medium text-gray-700">Nro dias</label>
                    <input v-model="destinoTuristico.dias" type="text" id="nro_dias" disabled
                        class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el Programa">
                </div>

                <div class="col-span-1 ">
                    <label for="estado_activo" class="block text-sm font-medium text-gray-700">Estado Activo</label>
                    <div class="flex items-center space-x-2">
                        <select v-model="destinoTuristico.estado_activo" id="estado_activo"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option disabled value="">-- Selecciona una opción --</option>
                            <option v-for="option in estadoActivo" :key="option.id" :value="option.id">
                                {{ option.nombre }}
                            </option>
                        </select>
                        <PrimaryButton type="button"
                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                            @click="agregarDetalle">
                            Agregar
                        </PrimaryButton>
                    </div>
                </div>

                <div class="col-span-3">
                    <DestinioTuristicoDetalle
                        :Lista_destino_turistico_detalle = "destinoTuristico.destino_turistico_detalle"
                        :Lista_proveedor_categorias = "ProveedorCategorias" 
                        :Lista_itinerarios = "Itinerarios"
                        :Lista_proveedor = "Proveedores" 
                        :Lista_servicio="Servicios" 
                        @actualizarMontoPadre="actualizarTotalHijo" />
                </div>

                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="costo_total" class="block text-sm font-medium text-gray-700">Costo total</label>
                    <input v-model="destinoTuristico.costo_total" @input="handleInput1" type="text" id="costo_total" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Costo total">
                </div>
                <div class="col-span-1 ">
                    <label for="margen" class=" text-sm font-medium text-gray-700">Margen</label>
                    <div class="flex items-center space-x-2">
                        <select id="  margen" class="w-full border-gray-300 rounded-md shadow-sm">
                            <!-- <option disabled value="">-- Selecciona una opción --</option> -->
                            <option v-for="option in descuentoTipo" :key="option.id" :value="option.id">
                                {{ option.nombre }}
                            </option>
                        </select>
                        <input v-model="destinoTuristico.margen" @input="handleInput" type="text" id="margen"
                            class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el Margen monto">
                    </div>
                </div>
                <div class="col-span-1">
                    <label for="venta" class="block text-sm font-medium text-gray-700">Venta</label>
                    <input v-model="destinoTuristico.venta" type="text" id="venta" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Venta">
                </div>
            </div>
            <!-- Botón para agregar el ítem -->
            <PrimaryButton type="button" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">Registrar</PrimaryButton>
            <button type ="button" @click="mostrarConsola()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
              </button>                        
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import DestinioTuristicoDetalle from '@/Components/DestinoTuristicoDetalle/CompDestinoTuristicoDetalleAdd.vue';
import PrimaryButton from '../PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

// Definir las props
const props = defineProps({
    Lista_paises: {
        type: Object,
        required: true,
    },
    Lista_itinerarios: {
        type: Object,
        required: true,
    },
    Lista_proveedor_categorias: {
        type: Object,
        required: true,
    },
    Lista_proveedor: {
        type: Object,
        required: true,
    },
    Lista_servicio: {
        type: Object,
        required: true,
    },
});

// Variables reactivas
const error = ref('');
const Pais = ref([...props.Lista_paises]);
const Itinerarios = ref([...props.Lista_itinerarios]);
const ProveedorCategorias = ref([...props.Lista_proveedor_categorias]);
const Proveedores = ref([...props.Lista_proveedor]);
const Servicios = ref([...props.Lista_servicio]);

// Timer para controlar el delay
let emptyInputTimeout = null;

const descuentoTipo = ref([
    { id: '1', nombre: '%' },
    { id: '0', nombre: 'MONTO' }
]);

const estadoActivo = ref([
    { id: '1', nombre: 'ACTIVO' },
    { id: '0', nombre: 'DESACTIVO' }
]);

// Variables para el destinoTuristico y detalle temporal
const destinoTuristico = ref({
    nombre: '',
    descripcion: '',
    pais: '',
    dias: '0',
    costo_total: '0.00',
    margen: '10',
    venta: '0.00',
    estado_activo: '1',

    destino_turistico_detalle: [],
});

const destinoTuristicoDetalle = ref({
    nro_dia: '1',
    itinerario: '',
    nombre: '',
    descripcion: '',
    estado_activo: '',
    destino_turistico_id: '',

    destino_turistico_detalle_servicio: [],
});

const mostrarConsola = () => {
    console.log(destinoTuristico.value);
}

// Función para validar el input (solo números y un punto decimal permitido)
const validateInput = (value) => {
  const validValue = value.replace(/[^0-9.]/g, ""); // Remover caracteres no numéricos
  // Permitir máximo un punto decimal
  const decimalParts = validValue.split(".");
  if (decimalParts.length > 2) {
    return `${decimalParts[0]}.${decimalParts[1]}`;
  }
  return validValue;
};

// Función para calcular el monto de la venta
const calcularVenta = () => {
    const costoTotal = destinoTuristico.value.costo_total;
    const margen = destinoTuristico.value.margen
    const porcentaje = margen / 100;
    const venta = costoTotal + costoTotal * porcentaje;
    destinoTuristico.value.venta = venta;
};



const handleInput = (event) => {
  // Validar y actualizar el margen
  const validatedValue = validateInput(event.target.value);
  destinoTuristico.value.margen = validatedValue;

  // Limpiar cualquier temporizador existente
  if (emptyInputTimeout) {
    clearTimeout(emptyInputTimeout);
  }

  // Si el input está vacío, esperar 1 segundo antes de asignar "0"
  if (!validatedValue) {
    emptyInputTimeout = setTimeout(() => {
      destinoTuristico.value.margen = "0";
      calcularVenta(validatedValue);
    }, 1000); // 1000 ms = 1 segundo
  } else {
    // Calcular venta si el valor es válido
    calcularVenta(validatedValue);
  }
};

// Función para actualizar el total general del Padre
const actualizarTotalHijo = () => {
    destinoTuristico.value.costo_total = destinoTuristico.value.destino_turistico_detalle.reduce((suma, detalle) => {
        return (
            suma +
            detalle.destino_turistico_detalle_servicio.reduce(
                (sumaServicios, servicio) => sumaServicios + parseFloat(servicio.costo || 0),
                0
            )
        );
    }, 0);
    destinoTuristico.value.dias = destinoTuristico.value.destino_turistico_detalle.length;
    calcularVenta();
};

function agregarDetalle() {
    destinoTuristico.value.destino_turistico_detalle.push({ ...destinoTuristicoDetalle.value });
    destinoTuristicoDetalle.value = {
        nro_dia: destinoTuristico.value.destino_turistico_detalle.length + 1,
        itinerario: '',
        nombre: '',
        descripcion: '',
        estado_activo: '',
        destino_turistico_id: '',

        destino_turistico_detalle_servicio: [],
    };

    destinoTuristico.value.dias = destinoTuristico.value.destino_turistico_detalle.length;
}

async function submitProveedor() {
    try {
        console.log(destinoTuristico.value);
        const response = await axios.post(route('proveedor_servicio.store'), destinoTuristico.value);

        if (response.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.data.message,
                confirmButtonText: 'Aceptar',
            }).then(() => {
                window.location.href = route('destinoTuristico'); // Redirige después de cerrar el modal.
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Error al agregar el elemento. ${response.data.message}`,
                confirmButtonText: 'Aceptar',
            });
        }
    } catch (err) {
        console.error('Error al registrar el destinoTuristico:', err);
        const errorMessage = err.response?.data?.message || 'Ocurrió un error inesperado';

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            confirmButtonText: 'Aceptar',
        });

        // Asigna el mensaje de error a la variable "error" si es necesario.
        error.value = errorMessage;
    }
}
</script>