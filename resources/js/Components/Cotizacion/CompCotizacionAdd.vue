<template>
    <div class="container mx-auto">
        <form @submit.prevent="submitDestinoTuristico">
            <div class="grid grid-cols-6 gap-6 w-full p-5">
                <!-- Primera fila -->
                <div hidden class="col-span-1">
                    <label for="" class="block text-sm font-medium text-gray-700">Cliente Id</label>
                    <input v-model="Cotizacion.proveedor_id" type="text" id="proveedor_id"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Cliente id">
                </div>
                <div class="col-span-1">
                    <label for="" class="block text-sm font-medium text-gray-700">Cliente nro doc.</label>
                    <input type="text" id="cliente_nro_doc"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Cliente nro doc.">
                </div>
                <div class="col-span-4">
                    <label for="proveedor_razon_social" class="block text-sm font-medium text-gray-700">Cliente nombre</label>
                    <input v-model="Cotizacion.proveedor_razon_social" type="text" id="proveedor_razon_social"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Cliente nombre">
                </div>
                <div class="col-span-1 ">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="showModalProveedor = true">
                        Nuevo
                    </PrimaryButton>
                </div>
                <!-- Segunda fila -->
                <div class="col-span-1">
                    <label for="file_nro" class="block text-sm font-medium text-gray-700">Nro file</label>
                    <input v-model="Cotizacion.file_nro" disabled type="text" id="file_nro" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Nro file">
                </div>
                <div class="col-span-4">
                    <label for="file_nombre" class="block text-sm font-medium text-gray-700">Nombre de file</label>
                    <input v-model="Cotizacion.file_nombre" type="text" id="file_nombre"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Nombre de file">
                </div>
                <div class="col-span-1 ">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="">
                        Nuevo
                    </PrimaryButton>
                </div>
                <!-- Tercera fila -->
                <div class="col-span-1">
                    <label for="comprobante_id" class="block text-sm font-medium text-gray-700">Tipo comprobante</label>
                    <select v-model="Cotizacion.comprobante_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="comprobante_id">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in sTipoComprobante" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1 ">
                    <label for="fecha" class=" text-sm font-medium text-gray-700">Fecha</label>
                    <input v-model="Cotizacion.fecha" disabled type="text" id="fecha"
                        class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese la Fecha">
                </div>
                <div class="col-span-1">
                    <label for="nro_pasajeros" class="block text-sm font-medium text-gray-700">Nro de Pax</label>
                    <input v-model="Cotizacion.nro_pasajeros" type="text" id="nro_pasajeros" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Nro de Pax" readonly>
                </div>
                <div class="col-span-1">
                    <label for="nro_ninio" class="block text-sm font-medium text-gray-700">Niño</label>
                    <ContadorInput v-model="numeroNinos" id="nro_ninio" placeholder="0" :required="true" @accion-realizada="manejarAccion"/>                    
                </div>
                <div class="col-span-1">
                    <label for="nro_adulto" class="block text-sm font-medium text-gray-700">Adulto</label>
                    <ContadorInput v-model="numeroAdultos" id="nro_adulto" placeholder="0" :required="true" @accion-realizada="manejarAccion"/>                    
                </div>
                <div class="col-span-1">
                    <label for="nro_estudiante" class="block text-sm font-medium text-gray-700">Estudiante</label>
                    <ContadorInput v-model="numeroEstudiantes" id="nro_estudiante" placeholder="0" :required="true"@accion-realizada="manejarAccion"/>                    
                </div>
                <!-- Cuarta fila -->
                <div class="col-span-1">
                    <label for="idioma" class="block text-sm font-medium text-gray-700">Idioma</label>
                    <select v-model="Cotizacion.idioma_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="idioma">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in sIdioma" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="mercado" class="block text-sm font-medium text-gray-700">Mercado</label>
                    <select v-model="Cotizacion.mercado_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="mercado">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in sMercado" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-4 ">
                    <label for="destino_turistico_id" class="block text-sm font-medium text-gray-700">Destino Turistico</label>
                    <select v-model="Cotizacion.destino_turistico_id" @change="ListaCategoriaProveedor"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="destino_turistico_id">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in DestinoTuristico" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <!-- Quinta fila -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="agregarDetallePasajero">
                        Datos del pax
                    </PrimaryButton>
                </div>
                <div class="col-span-1 ">
                    <label for="pais_id" class="block text-sm font-medium text-gray-700">Pais</label>
                    <select v-model="Cotizacion.pais_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="pais_id">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in sPais" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1 ">
                    <Datepicker label="Fecha Inicio" v-model="Cotizacion.fecha_inicio" />
                </div>
                <div class="col-span-1">
                    <Datepicker label="Fecha Fin" v-model="Cotizacion.fecha_fin" />
                </div>
                <div class="col-span-1">
                    <label for="nro_dias" class="block text-sm font-medium text-gray-700">Dias</label>
                    <input disabled v-model="Cotizacion.nro_dias" type="text" id="nro_dias" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Dias">
                </div>
                <div class="col-span-1">
                    <label for="estado_cotizacion" class="block text-sm font-medium text-gray-700">Estado
                        Cotizacion</label>
                    <select v-model="Cotizacion.estado_cotizacion"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="estado_cotizacion">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in EstadoCotizacion" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>                
                <div class="col-span-6">
                    <ServicioDetalle
                        :Lista_servicio_detalle = "listaServicioDetalle" 
                        :Lista_servicio_x_dia = "ListaServicioPasajeroTemp"
                        :Lista_Pasajeros = pasajeros                    
                        v-model="contador" />
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6 w-full p-5">
                <!-- Sexta fila -->
                <div class="col-span-1">
                    <label for="costo_parcial" class="block text-sm font-medium text-gray-700">C. Parcial</label>
                    <input v-model="Cotizacion.costo_parcial" type="text" id="costo_parcial"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="C. Parcial">
                </div>
                <div class="col-span-1 ">
                    <label for="descuento_estudiante" class=" text-sm font-medium text-gray-700">Desc.
                        Estudiante</label>
                    <input v-model="Cotizacion.descuento_estudiante" @input="(event) => handleInput(event, 'descuento_estudiante')" type="text"
                        id="descuento_estudiante" class="w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Desc. Estudiante">
                </div>
                <div class="col-span-1">
                    <label for="descuento_ninio" class="block text-sm font-medium text-gray-700">Descuento Niño</label>
                    <input v-model="Cotizacion.descuento_ninio" @input="(event) => handleInput(event, 'descuento_ninio')" type="text" id="descuento_ninio"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Descuento Niño">
                </div>
                <div class="col-span-1">
                    <label for="descuento_otro" class="block text-sm font-medium text-gray-700">Descuento Otro</label>
                    <input v-model="Cotizacion.descuento_otro" @input="(event) => handleInput(event, 'descuento_otro')" type="text" id="descuento_otro"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="Descuento Otro">
                </div>
                <div class="col-span-1">
                    <label for="costo_total" class="block text-sm font-medium text-gray-700">Costo Total</label>
                    <input v-model="Cotizacion.costo_total" type="text" id="costo_total" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Costo Total">
                </div>
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="submit" class="mt-2">
                        Registrar
                    </PrimaryButton>
                    <button type="button" @click="mostrarConsola()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <PasajeroModal
        :isModalVisible="showModal"
        :ListaPasajeros = Cotizacion.Pasajeros
        :errorMessage="error"
        @close="showModal = false"
        @update= recalcularTotalPasajeros
    /> 
    <ClienteModal
        :isModalVisibleProveedor="showModalProveedor"
        :errorMessage="error"
        @close="showModalProveedor = false"
        @submit="recuperarValorModal"
    />   
</template>

<script setup>
import { ref, watch, reactive, computed } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import ContadorInput from '@/ComponentModal/ContadorInput.vue';
import PrimaryButton from '../PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Datepicker from '@/Components/Datepicker.vue'; // Importa el componente
import ServicioDetalle from '@/Components/ServicioDetalle/CompServicioDetalleAdd.vue';
import PasajeroModal from '@/Pages/Pasajero/CompModalPasajero.vue';
import ClienteModal from '@/Components/Proveedor/CompModalProveedor.vue';
import { useCategoriesStore } from '@/Stores/categories';
const categoriesStore = useCategoriesStore();

// Definir las props
const props = defineProps({
    Correlativo: {
        type: String,
        required: true,
    },
    Lista_destinos_turistico: {
        type: Object,
        required: true,
    },
});

const sTipoComprobante = ref([...categoriesStore.globals.tipo_comprobantes]);
const sPais = ref([...categoriesStore.globals.pais]);
const sIdioma = ref([...categoriesStore.globals.idioma]);
const sMercado = ref([...categoriesStore.globals.mercado]);

// Variables reactivas
const error = ref('');
const ultimaAccion = ref('');
const showModal = ref(false);
const showModalProveedor = ref(false);
const DestinoTuristico = ref([...props.Lista_destinos_turistico]);
const Correlativo = ref(props.Correlativo);
const fechaActual = ref(new Date().toISOString().slice(0, 10));

const EstadoCotizacion = ref([
    { value: '1', label: 'PENDIENTE' },
    { value: '2', label: 'CONFIRMADA' },
    { value: '3', label: 'CANCELADA' },
]);

// Timer para controlar el delay
let emptyInputTimeout = null;

const estadoActivo = ref([
    { id: '1', nombre: 'ACTIVO' },
    { id: '0', nombre: 'DESACTIVO' }
]);

// Variables para el cotizacion y detalle temporal
const Cotizacion = ref({
    proveedor_id: '',
    proveedor_razon_social: '',
    file_nro: Correlativo.value,
    file_nombre: '',    
    comprobante_id: '',
    fecha: fechaActual.value,
    nro_pasajeros: 0,
    nro_ninio: 0,
    nro_adulto: 0,
    nro_estudiante: 0,
    idioma_id: '',
    mercado_id: '',
    destino_turistico_id: '',
    pais_id: '',
    fecha_inicio: fechaActual.value,
    fecha_fin: fechaActual.value,
    nro_dias: 1,
    estado_cotizacion: '',
    costo_parcial: 0,
    descuento_estudiante: 0,
    descuento_ninio: 0,
    descuento_otro: 0,
    costo_total: 0,
    estado_activo: 1,

    Pasajeros: [],
    Servicios: [],
    PasajeroServicio: [],
});

const pasajeroTemp = ref({
    id: 0,
    nombre: '',    
    apellido_paterno: '',
    apellido_materno: '',
    documento_tipo_id: '',
    documento_numero: '',
    pais_id: '',
    documento_file: '',
    temp_file_name: '',
    temp_file_preview: '',
    tipo_pasajero_id: '',
    clase_id: '',
    cotizacion_id: '',
    estado_activo: 1,
});

const pasajeroServicioTemp = ref({
    id: 0,
    pasajero_id: 0,    
    servicio_id: 0,
    estado_pasajero_servicio: 0,
});

//const ListaPasajerosTemp = reactive([{ id: 1, name: 'Juan' },{ id: 2, name: 'María' }]);
const ListaPasajerosTemp = reactive([...Cotizacion.value.Pasajeros]);
// const ListaServiciosTemp = ([...Cotizacion.value.Servicios]);
// const ListaServiciosTemp = [
//     { id: 'A', name: 'Servicio A' },
//     { id: 'B', name: 'Servicio B' }
// ];

// Observar cambios en el store
watch(() => Cotizacion.value.Pasajeros, (newVal) => {
    console.log("nuevo pasajero ", newVal);
    ListaPasajerosTemp.splice(0, ListaPasajerosTemp.length, ...newVal);

}, { deep: true });

// Computed reactivo para que cambie cuando cotizacion.nro_pasajeros cambie
const contador = computed(() => Cotizacion.value.nro_pasajeros);

// Observa cambios en `nro_pasajeros` y ejecuta `calcularVenta`
watch(() => Cotizacion.value.nro_pasajeros, (newValue) => {
  console.log("Nuevo valor de nro_pasajeros:", newValue);
  agregarServicioPasajeroTemp();
  calcularVenta();
});


const ListaServicioPasajeroTemp = reactive([]);

function agregarServicioPasajeroTemp() {    
    if (ListaServicioPasajeroTemp.length > 0) {
        ListaServicioPasajeroTemp.length = 0;
    }
    const jsonServicio = destinoTuristicoDetalleServicio.value;
    jsonServicio.forEach((servicio) => {
        console.log("dia ", servicio.nro_dia);
        const servicioXdia = {
            dia : servicio.nro_dia,
            detalle : []
        }
        ListaPasajerosTemp.forEach(pasajero => {
            console.log("pasajero ", pasajero.nombre);
            const pasajeroServicio = {    
                pasajero,
                servicio_detalle: []
            };
            servicio.destino_turistico_detalle_servicio.forEach((servicioDetalle) => { 
                console.log("servicio ", servicioDetalle.observacion);
                console.log("servicio ", servicioDetalle);

                pasajeroServicio.servicio_detalle.push(servicioDetalle);                            
            });
            servicioXdia.detalle.push(pasajeroServicio);
        });

        ListaServicioPasajeroTemp.push(servicioXdia);
    });
    Cotizacion.value.PasajeroServicio = ListaServicioPasajeroTemp;
}

const numeroAdultos = ref(0);
const numeroNinos = ref(0);
const numeroEstudiantes = ref(0);

const errorFecha = ref("");
const pasajeros = ref([...Cotizacion.value.Pasajeros]);
const listaServicioDetalle = ref([...Cotizacion.value.Servicios]);
const destinoTuristicoDetalleServicio = ref([]);
const minFechaFin = ref(Cotizacion.value.fecha_inicio);

async function recuperarValorModal(valor) {
    console.log('recuperarValorModal ', valor);
    showModalProveedor.value = false;
    Cotizacion.value.proveedor_id = valor.id;
    Cotizacion.value.proveedor_razon_social = valor.nombre;
    const nroDoc = document.getElementById('cliente_nro_doc');
    nroDoc.value = valor.numero;
}
 
async function ListaCategoriaProveedor() {
    try {     
        const data = {
            destino_turistico_id: Cotizacion.value.destino_turistico_id,
        }     
        const response = await axios.post(`${route('destino_turistico')}/destinoServicios`, data);  
        if (response.status === 200) {
            console.log("se recupera desde controller", response.data); 
            calcularTotalesPorCategoria(response.data);
            destinoTuristicoDetalleServicio.value = response.data.destino_turistico_detalle;
            agregarServicioPasajeroTemp();
            calcularVenta();
        }               
    } catch (error) {
        console.error('Error al actualizar los datos:', error);
    }        
};

function calcularTotalesPorCategoria(destino) {
    const resultado = {};
    destino.destino_turistico_detalle.forEach(detalle => {
        detalle.destino_turistico_detalle_servicio.forEach(servicio => {
            const categoriaId = servicio.proveedor_categoria_id;
            const monto = parseFloat(servicio.monto) || 0;

            if (!resultado[categoriaId]) {
                resultado[categoriaId] = {
                    categoria: categoriaId,
                    total_monto: 0,
                    cantidad: 0
                };
            }
            resultado[categoriaId].total_monto += monto;
            resultado[categoriaId].cantidad += 1;
        });
    });
    listaServicioDetalle.value = Object.values(resultado);
}

// **Observar cambios en fecha_inicio**
watch(() => Cotizacion.value.fecha_inicio, (nuevaFechaInicio) => {
    console.log('uno111111111 ', nuevaFechaInicio);
    const inicio = new Date(nuevaFechaInicio);
    const fin = new Date(Cotizacion.value.fecha_fin);

    // **Actualizar fecha mínima permitida en fecha_fin**
    minFechaFin.value = nuevaFechaInicio;

    // **Si la fecha de fin es menor, actualizarla automáticamente**
    if (fin < inicio) {
        Cotizacion.value.fecha_fin = nuevaFechaInicio;
    }
    calcularDiferenciaDias();
});

// **Validar que fecha_inicio nunca sea mayor a fecha_fin**
watch([() => Cotizacion.value.fecha_inicio, () => Cotizacion.value.fecha_fin], ([inicio, fin]) => {
    console.log('dos2222222 ', inicio, fin);
    if (new Date(inicio) > new Date(fin)) {
        errorFecha.value = "La fecha de inicio no puede ser mayor que la fecha fin.";
    } else {
        errorFecha.value = "";
    }
    calcularDiferenciaDias();
});

const manejarAccion = ({ accion, id }) => {
  ultimaAccion.value = { accion, id };
  let tipo_pasajero = id === 'nro_ninio' ? '1' : id === 'nro_adulto' ? '3' : '2';
  if (accion === 'incremento') {
    agregarPasajero(tipo_pasajero);
  }else{
    eliminarPasajero(tipo_pasajero);
  }  
};

const calcularDiferenciaDias = () => {
    console.log('calcularDiferenciaDias ', Cotizacion.value.fecha_inicio, Cotizacion.value.fecha_fin);
    const inicio = new Date(Cotizacion.value.fecha_inicio);
    const fin = new Date(Cotizacion.value.fecha_fin);
    Cotizacion.value.nro_dias = Math.round((fin - inicio) / (1000 * 60 * 60 * 24));
};

// Función para calcular el total de pasajeros
const recalcularTotalPasajeros = () => {
    numeroNinos.value = contarPasajerosPorTipo('1');
    numeroEstudiantes.value = contarPasajerosPorTipo('2');
    numeroAdultos.value = contarPasajerosPorTipo('3');
};

// Función para contar pasajeros por tipo
const contarPasajerosPorTipo = (tipo) => {
    return pasajeros.value.filter((pasajero) => pasajero.tipo_pasajero_id === tipo).length || 0;
};

// Función para calcular el total de pasajeros
const calcularTotalPasajeros = () => {
    Cotizacion.value.nro_ninio = numeroNinos.value;
    Cotizacion.value.nro_adulto = numeroAdultos.value;
    Cotizacion.value.nro_estudiante = numeroEstudiantes.value;
    Cotizacion.value.nro_pasajeros = numeroAdultos.value + numeroNinos.value + numeroEstudiantes.value;
};

// Observar cambios en los valores de adultos, niños y bebés
watch([numeroAdultos, numeroNinos, numeroEstudiantes], () => {
    calcularTotalPasajeros();
});

const mostrarConsola = () => {
    console.log(Cotizacion.value);
}

// Función para calcular el monto de la venta
const calcularVenta = () => {
    const sumaTotal = listaServicioDetalle.value.reduce((acc, item) => acc + (item.total_monto * Cotizacion.value.nro_pasajeros), 0);
    const sumaDescuentos = Cotizacion.value.descuento_estudiante + Cotizacion.value.descuento_ninio + Cotizacion.value.descuento_otro;
    Cotizacion.value.costo_parcial = sumaTotal;
    Cotizacion.value.costo_total = sumaTotal - sumaDescuentos;
};

const handleInput = (event, field) => {
  const validatedValue = validateInput(event.target.value);
  Cotizacion.value[field] = Number(validatedValue);

  // Limpiar cualquier temporizador existente
  if (emptyInputTimeout) {
    clearTimeout(emptyInputTimeout);
  }

  // Si el input está vacío, esperar 1 segundo antes de asignar "0"
  if (!validatedValue) {
    emptyInputTimeout = setTimeout(() => {
      Cotizacion.value[field] = 0;
      calcularVenta(validatedValue);
    }, 1000); // 1000 ms = 1 segundo
  } else {
    // Calcular venta si el valor es válido
    calcularVenta(validatedValue);
  }
};

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

function agregarDetallePasajero() {
    pasajeros.value = Cotizacion.value.Pasajeros;
    showModal.value = true;
}

function agregarPasajero(tipoPasajero) {
    pasajeroTemp.value.tipo_pasajero_id = tipoPasajero;
    Cotizacion.value.Pasajeros.push({ ...pasajeroTemp.value });
    pasajeroTemp.value = {
        id: pasajeroTemp.value.tipo_pasajero_id.length,
        nombre: '',    
        apellido_paterno: '',
        apellido_materno: '',
        documento_tipo_id: '',
        documento_numero: '',
        pais_id: '',
        documento_file: '',
        tipo_pasajero_id: '',
        clase_id: '',
    };
}

const eliminarPasajero = (tipoPasajero) => {
    const index = Cotizacion.value.Pasajeros.findIndex(
        (pasajero) => pasajero.tipo_pasajero_id === tipoPasajero
    );
    if (index >= 0) {
        Cotizacion.value.Pasajeros.splice(index, 1);
    }
}

async function submitDestinoTuristico() {
    try {
        Swal.fire({
            title: 'Cargando...',
            text: 'Por favor, espera mientras se cargan los datos.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const response = await axios.post(route('cotizacion.store'), Cotizacion.value, {
            headers: { "Content-Type": "multipart/form-data" },
        }); 

        Swal.close();

        if (response.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.data.message,
                confirmButtonText: 'Aceptar',
            }).then(() => {
                window.location.href = route('cotizacion'); // Redirige después de cerrar el modal.
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