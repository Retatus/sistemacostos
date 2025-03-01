<template>
    <div class="container mx-auto">  
        <form @submit.prevent="submitDestinoTuristico">
            <div class="grid grid-cols-6 gap-6 w-full p-5">
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="costo_total" class="block text-sm font-medium text-gray-700">&nbsp;</label>
                </div>
                <div class="col-span-4">
                    <label for="proveedor_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <input v-model="cotizacion.proveedor_id" @input="handleInput1" type="text" id="proveedor_id" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Cliente">
                </div>
                <div class="col-span-1 ">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button"
                        class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="agregarDetalle">
                        Nuevo
                    </PrimaryButton>
                </div>
            <!-- </div>
            <div class="grid grid-cols-6 gap-6 w-full p-5"> -->
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="file_nro" class="block text-sm font-medium text-gray-700">Nro file</label>
                    <input v-model="cotizacion.file_nro" disabled type="text" id="file_nro" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Nro file">
                </div>
                <div class="col-span-4">
                    <label for="file_nombre" class="block text-sm font-medium text-gray-700">Nombre de file</label>
                    <input v-model="cotizacion.file_nombre" @input="handleInput1" type="text" id="file_nombre" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Nombre de file">
                </div>
                <div class="col-span-1 ">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button"
                        class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="agregarDetalle">
                        Nuevo
                    </PrimaryButton>
                </div>
            <!-- </div>
            
            <div class="grid grid-cols-6 gap-6 w-full p-5"> -->
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="comprobante_id" class="block text-sm font-medium text-gray-700">Tipo comprobante</label>
                    <select v-model="cotizacion.comprobante_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="comprobante_id">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in TipoComprobante" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1 ">
                    <label for="fecha" class=" text-sm font-medium text-gray-700">Fecha</label>
                    <input v-model="cotizacion.fecha" disabled type="text" id="fecha"
                            class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese la Fecha">
                </div>
                <div class="col-span-1">
                    <label for="nro_pasajeros" class="block text-sm font-medium text-gray-700">Nro de Pax</label>
                    <input 
                        v-model="cotizacion.nro_pasajeros" 
                        type="text" 
                        id="nro_pasajeros" 
                        required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" 
                        placeholder="Nro de Pax"
                        readonly>
                </div>
                <div class="col-span-1">
                    <label for="nro_ninio" class="block text-sm font-medium text-gray-700">Niño</label>
                    <ContadorInput
                        v-model="numeroNinos"
                        id="nro_ninio"
                        placeholder="0"
                        :required="true"
                    />                      
                </div>
                <div class="col-span-1">
                    <label for="nro_adulto" class="block text-sm font-medium text-gray-700">Adulto</label> 
                    <ContadorInput
                        v-model="numeroAdultos"
                        id="nro_adulto"
                        placeholder="0"
                        :required="true"
                    />                   
                    
                </div>
                <div class="col-span-1">
                    <label for="nro_estudiante" class="block text-sm font-medium text-gray-700">Estudiante</label>
                    <ContadorInput
                        v-model="numeroEstudiantes"
                        id="nro_estudiante"
                        placeholder="0"
                        :required="true"
                    />  
                </div>
            <!-- </div>
            <div class="grid grid-cols-6 gap-6 w-full p-5"> -->
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="idioma" class="block text-sm font-medium text-gray-700">Idioma</label>
                    <select v-model="cotizacion.idioma" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="idioma">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in Idioma" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="mercado" class="block text-sm font-medium text-gray-700">Mercado</label>
                    <select v-model="cotizacion.mercado" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="mercado">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in Mercado" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-4 ">
                    <label for="destino_turistico_id" class="block text-sm font-medium text-gray-700">Destino Turistico</label>
                    <select v-model="cotizacion.destino_turistico_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="destino_turistico_id">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in DestinoTuristico" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
            <!-- </div>
            <div class="grid grid-cols-6 gap-6 w-full p-5"> -->
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button"
                        class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="agregarDetalle">
                        Datos del pax
                    </PrimaryButton>
                </div>
                <div class="col-span-1 ">
                    <label for="pais_id" class="block text-sm font-medium text-gray-700">Pais</label>
                    <select v-model="cotizacion.pais_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="pais_id">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in Pais" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1 ">
                    <Datepicker 
                        label="Ingrese la Fecha Inicio"
                        v-model="cotizacion.fecha_inicio" 
                    />
                </div>
                <div class="col-span-1">
                    <Datepicker 
                        label="Ingrese la Fecha Fin" 
                        v-model="cotizacion.fecha_fin" 
                    />
                </div>
                <div class="col-span-1">
                    <label for="nro_dias" class="block text-sm font-medium text-gray-700">Dias</label>
                    <input v-model="cotizacion.nro_dias" type="text" id="nro_dias" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Dias">
                </div>
                <div class="col-span-1">
                    <label for="estado_cotizacion" class="block text-sm font-medium text-gray-700">Estado cotizacion</label>
                    <input v-model="cotizacion.estado_cotizacion" type="text" id="estado_cotizacion" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Estado cotizacion">
                </div>
            <!-- </div>
            <div class="grid grid-cols-6 gap-4 w-full p-5"> -->
                <div class="col-span-6">
                    <!-- <DestinioTuristicoDetalle
                        :Lista_destino_turistico_detalle = "cotizacion.destino_turistico_detalle"
                        :Lista_proveedor_categorias = "ProveedorCategorias" 
                        :Lista_itinerarios = "Itinerarios"
                        :Lista_proveedor = "Proveedores" 
                        :Lista_servicio="Servicios" 
                        @actualizarMontoPadre="actualizarTotalHijo" /> -->
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 w-full p-5">
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="costo_parcial" class="block text-sm font-medium text-gray-700">C. Parcial</label>
                    <input v-model="cotizacion.costo_parcial" @input="handleInput1" type="text" id="costo_parcial" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="C. Parcial">
                </div>
                <div class="col-span-1 ">
                    <label for="descuento_estudiante" class=" text-sm font-medium text-gray-700">Desc. Estudiante</label>
                    <input v-model="cotizacion.descuento_estudiante" @input="handleInput" type="text" id="descuento_estudiante"
                        class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Desc. Estudiante">
                </div>
                <div class="col-span-1">
                    <label for="descuento_ninio" class="block text-sm font-medium text-gray-700">Descuento Niño</label>
                    <input v-model="cotizacion.descuento_ninio" type="text" id="descuento_ninio" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Descuento Niño">
                </div>
                <div class="col-span-1">
                    <label for="costo_total" class="block text-sm font-medium text-gray-700">Costo Total</label>
                    <input v-model="cotizacion.costo_total" type="text" id="costo_total" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Costo Total">
                </div>
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <!-- Botón para agregar el ítem -->
                    <PrimaryButton type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">Registrar</PrimaryButton>
                    <button type ="button" @click="mostrarConsola()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>                                    
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import ContadorInput from '@/ComponentModal/ContadorInput.vue';
import DestinioTuristicoDetalle from '@/Components/DestinoTuristicoDetalle/CompDestinoTuristicoDetalleAdd.vue';
import PrimaryButton from '../PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Datepicker from '@/Components/Datepicker.vue'; // Importa el componente

// Definir las props
const props = defineProps({
    Correlativo: {
        type: String,
        required: true,
    },
    Lista_tipo_comprobante: {
        type: Object,
        required: true,
    },
    Lista_destinos_turistico: {
        type: Object,
        required: true,
    },
    Lista_paises: {
        type: Object,
        required: true,
    },
});

// Variables reactivas
const error = ref('');
const TipoComprobante = ref([...props.Lista_tipo_comprobante]);
const Pais = ref([...props.Lista_paises]);
const DestinoTuristico = ref([...props.Lista_destinos_turistico]);
const Correlativo = ref(props.Correlativo);
const fechaActual = ref(new Date().toISOString().slice(0, 10));
console.log('fechaActual ', fechaActual.value);
const Idioma = ref([
    { value: '1', label: 'ENGLISH' },
    { value: '2', label: 'SPANISH' },
    { value: '3', label: 'FRENCH' },
    { value: '4', label: 'GERMAN' },
    { value: '5', label: 'ITALIAN' },
    { value: '6', label: 'PORTUGUESE' },
    { value: '7', label: 'JAPANESE' },
    { value: '8', label: 'CHINESE' },
    { value: '9', label: 'KOREAN' },
    { value: '10', label: 'RUSSIAN' },
    { value: '11', label: 'OTHER' },
]);
const Mercado = ref([
    { value: '1', label: 'WEB' },
    { value: '2', label: 'RECOMENDACION' },
    { value: '3', label: 'WHATSAAP' },
    { value: '4', label: 'ENDOCE' },
]);


// Timer para controlar el delay
let emptyInputTimeout = null;

const estadoActivo = ref([
    { id: '1', nombre: 'ACTIVO' },
    { id: '0', nombre: 'DESACTIVO' }
]);

// Variables para el cotizacion y detalle temporal
const cotizacion = ref({
    proveedor_id : '',
    file_nro : Correlativo.value,
    file_nombre : '',
    comprobante_id : '',
    fecha : fechaActual.value,
    nro_pasajeros : 0,
    nro_ninio : 0,
    nro_adulto : 0,
    nro_estudiante : 0,
    idioma : '',
    mercado : '',
    destino_turistico_id : '',
    pais_id : '',
    fecha_inicio : fechaActual.value,
    fecha_fin : fechaActual.value,
    nro_dias : '',
    estado_cotizacion : '',
    costo_parcial : '',
    descuento_estudiante : '',
    descuento_ninio : '',
    descuento_otro : '',
    costo_total : '',
    estado_activo : '',

    destino_turistico_detalle: [],
});

const destinoTuristicoDetalle = ref({
    nro_dia: 1,
    itinerario_id: '',
    nombre: '',
    observacion: '',
    estado_activo: 1,
    destino_turistico_id: '',

    destino_turistico_detalle_servicio: [],
});

const numeroAdultos = ref(0);
const numeroNinos = ref(0);
const numeroEstudiantes = ref(0);
const fechaSeleccionada = ref(null);
// Función para calcular el total de pasajeros
const calcularTotalPasajeros = () => {
    cotizacion.value.nro_ninio = numeroNinos.value;
    cotizacion.value.nro_adulto = numeroAdultos.value;
    cotizacion.value.nro_estudiante = numeroEstudiantes.value;
    cotizacion.value.nro_pasajeros = numeroAdultos.value + numeroNinos.value + numeroEstudiantes.value;
};

// Observar cambios en los valores de adultos, niños y bebés
watch([numeroAdultos, numeroNinos, numeroEstudiantes], () => {
    calcularTotalPasajeros();
});

const mostrarConsola = () => {
    console.log(cotizacion.value);
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
    const costoTotal = cotizacion.value.costo_total;
    const margen = cotizacion.value.margen
    const porcentaje = margen / 100;
    const venta = costoTotal + costoTotal * porcentaje;
    cotizacion.value.ganancia = costoTotal * porcentaje;
    cotizacion.value.venta = venta;
};



const handleInput = (event) => {
  // Validar y actualizar el margen
  const validatedValue = validateInput(event.target.value);
  cotizacion.value.margen = validatedValue;

  // Limpiar cualquier temporizador existente
  if (emptyInputTimeout) {
    clearTimeout(emptyInputTimeout);
  }

  // Si el input está vacío, esperar 1 segundo antes de asignar "0"
  if (!validatedValue) {
    emptyInputTimeout = setTimeout(() => {
      cotizacion.value.margen = 0;
      calcularVenta(validatedValue);
    }, 1000); // 1000 ms = 1 segundo
  } else {
    // Calcular venta si el valor es válido
    calcularVenta(validatedValue);
  }
};

// Función para actualizar el total general del Padre
const actualizarTotalHijo = () => {
    cotizacion.value.costo_total = cotizacion.value.destino_turistico_detalle.reduce((suma, detalle) => {
        return (
            suma +
            detalle.destino_turistico_detalle_servicio.reduce(
                (sumaServicios, servicio) => sumaServicios + parseFloat(servicio.monto || 0),
                0
            )
        );
    }, 0);
    cotizacion.value.nro_dias = cotizacion.value.destino_turistico_detalle.length;
    calcularVenta();
};

function agregarDetalle() {
    cotizacion.value.destino_turistico_detalle.push({ ...destinoTuristicoDetalle.value });
    destinoTuristicoDetalle.value = {
        nro_dia: cotizacion.value.destino_turistico_detalle.length + 1,
        itinerario_id: '',
        nombre: '',
        observacion: '',
        estado_activo: 1,
        destino_turistico_id: '',

        destino_turistico_detalle_servicio: [],
    };

    cotizacion.value.nro_dias = cotizacion.value.destino_turistico_detalle.length;
}

async function submitDestinoTuristico() {
    try {
        const response = await axios.post(route('destino_turistico.store'), cotizacion.value);

        if (response.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.data.message,
                confirmButtonText: 'Aceptar',
            }).then(() => {
                window.location.href = route('destino_turistico'); // Redirige después de cerrar el modal.
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
        console.error('Error al registrar el cotizacion:', err);
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

<style scoped>



</style>