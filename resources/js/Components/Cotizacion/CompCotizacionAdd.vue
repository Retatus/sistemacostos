<template>
    <div class="container mx-auto">
        <form @submit.prevent="submitCotizacion">
            <div class="grid grid-cols-6 gap-6 w-full p-5">
                <!-- Primera fila -->
                <div hidden class="col-span-1">
                    <label for="proveedor_id" class="block text-sm font-medium text-gray-700">Cliente Id</label>
                    <input v-model="Cotizacion.proveedor_id" type="text" id="proveedor_id" name="proveedor_id"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Cliente id">
                </div>
                <div class="col-span-1">
                    <label for="cliente_nro_doc" class="block text-sm font-medium text-gray-700">Cliente nro doc.</label>
                    <input v-model="Cotizacion.cliente_nro_doc" type="text" id="cliente_nro_doc" name="cliente_nro_doc"
                        required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Cliente nro doc.">
                </div>
                <div class="col-span-4">
                    <label for="proveedor_razon_social" class="block text-sm font-medium text-gray-700">Cliente nombre</label>
                    <input v-model="Cotizacion.proveedor_razon_social" type="text" id="proveedor_razon_social" name="proveedor_razon_social"
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
                    <input v-model="Cotizacion.file_nro" disabled type="text" id="file_nro" required="true" neme="file_nro"
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
                        <option disabled value="0">-- Selecciona una opción --</option>
                        <option v-for="option in sTipoComprobante" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1 ">
                    <Datepicker label="Fecha" :modelValue="Cotizacion.fecha" @update:modelValue="Cotizacion.fecha = $event" :disabled="true" />
                </div>
                <div class="col-span-1">
                    <label for="nro_pasajeros" class="block text-sm font-medium text-gray-700">Nro de Pax</label>
                    <input v-model="Cotizacion.nro_pasajeros" type="text" id="nro_pasajeros" required="true"
                        class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Nro de Pax" readonly>
                </div>
                <div class="col-span-1">
                    <label for="nro_ninio" class="block text-sm font-medium text-gray-700">Niño</label>
                    <ContadorInput v-model="Cotizacion.nro_ninio" id="nro_ninio" placeholder="0" :required="true" @accion-realizada="manejarAccion"/>                    
                </div>
                <div class="col-span-1">
                    <label for="nro_adulto" class="block text-sm font-medium text-gray-700">Adulto</label>
                    <ContadorInput v-model="Cotizacion.nro_adulto" id="nro_adulto" placeholder="0" :required="true" @accion-realizada="manejarAccion"/>                    
                </div>
                <div class="col-span-1">
                    <label for="nro_estudiante" class="block text-sm font-medium text-gray-700">Estudiante</label>
                    <ContadorInput v-model="Cotizacion.nro_estudiante" id="nro_estudiante" placeholder="0" :required="true"@accion-realizada="manejarAccion"/>                    
                </div>
                <!-- Cuarta fila -->
                <div class="col-span-1">
                    <label for="idioma" class="block text-sm font-medium text-gray-700">Idioma</label>
                    <select v-model="Cotizacion.idioma_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="idioma">
                        <option disabled value="0">-- Selecciona una opción --</option>
                        <option v-for="option in sIdioma" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label for="mercado" class="block text-sm font-medium text-gray-700">Mercado</label>
                    <select v-model="Cotizacion.mercado_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="mercado">
                        <option disabled value="0">-- Selecciona una opción --</option>
                        <option v-for="option in sMercado" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-4 ">
                    <label for="destino_turistico_id" class="block text-sm font-medium text-gray-700">Destino Turistico</label>
                    <select v-model="Cotizacion.destino_turistico_id" @change="ListaCategoriaProveedor"
                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm" id="destino_turistico_id">
                        <option disabled value="0">-- Selecciona una opción --</option>
                        <option v-for="option in DestinoTuristico" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <!-- Quinta fila -->
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <PrimaryButton type="button" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        @click="agregarDetalleDatosPasajero">
                        Datos del pax
                    </PrimaryButton>
                </div>
                <div class="col-span-1 ">
                    <label for="pais_id" class="block text-sm font-medium text-gray-700">Pais</label>
                    <select v-model="Cotizacion.pais_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        id="pais_id">
                        <option disabled value="0">-- Selecciona una opción --</option>
                        <option v-for="option in sPais" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="col-span-1 ">
                    <Datepicker label="Fecha Inicio" :modelValue="Cotizacion.fecha_inicio" @update:modelValue="Cotizacion.fecha_inicio = $event" @fecha-cambiada="manejarCambioFecha" :emitirEventoCambio="true"/>
                </div>
                <div class="col-span-1">
                    <Datepicker label="Fecha Fin" :modelValue="Cotizacion.fecha_fin" @update:modelValue="Cotizacion.fecha_fin = $event" :disabled="true"/>
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
                        <option disabled value="0">-- Selecciona una opción --</option>
                        <option v-for="option in EstadoCotizacion" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>                
                <div class="col-span-6">
                    <!-- <ul>
                        <li v-for="(item, index) in serviciosPorDia" :key="index">
                            {{ item.nombre }} - {{ item.descripcion }} - {{ item.precio }} - {{ item.moneda }} - {{ item.subtotal }}
                        </li>
                    </ul> -->
                    <div v-for="(dia, index) in serviciosPorDia" :key="index" class="day-group">
                        <div class="day-header bg-black  text-slate-300 p-2 rounded mb-2">
                            <h3>Día {{dia.nro_dia}} {{ dia.nombre  }}: {{ dia.descripcion }} {{ dia.id }}</h3>
                            <!-- {{ serviciosPorDia }} -->
                        </div>
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-900 uppercase bg-gray-50">
                                <tr className="bg-white border-b text-gray-900">
                                    <th hidden>ID</th>
                                    <!-- <th class="w-1/12 px-4 py-2">Hora</th> -->
                                    <!-- <th class="w-1/12 px-4 py-2">Categoria</th> -->
                                    <th class="w-3/12 px-4 py-2">Hora / Categoria / Servicio</th>
                                    <th class="w-2/12 px-4 py-2">Observación</th>
                                    <!-- <th class="w-1/12 px-4 py-2">Moneda</th> -->
                                    <th class="w-2/12 px-4 py-2 text-center">Moneda / Monto / Cant. / Subtotal</th>
                                    <!-- <th class="w-1/12 px-4 py-2">Cantidad</th>
                                    <th class="w-1/12 px-4 py-2">Subtotal</th> -->
                                    <th class="w-2/12 px-4 py-2">Pasajeros Asignados</th>
                                    <th class="w-1/12 px-4 py-2 text-center">status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(servicioDetalle, index) in dia.itinerario_servicios" :key="index" className="bg-white border-b text-gray-900">
                                    <td class="px-1 py-1" hidden>
                                        <input v-model="servicioDetalle.itinerario_servicio_id" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
                                    </td>
                                    <!-- <td class="px-1 py-1">
                                    </td> -->
                                    <!-- {{ servicioDetalle.nro_orden }} -->
                                    <td class="px-1 py-1">
                                        <div class="flex space-x-2">
                                            <div class="w-2/12">
                                                <InputHora v-model="servicioDetalle.pasajero_servicios.hora" />
                                            </div>
                                            <div class="w-3/12">
                                                <select v-model="servicioDetalle.proveedor_categoria_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs">
                                                    <option disabled value="0">-- Selecciona una opción --</option>
                                                    <option v-for="option in sCategoriaProveedor" :key="option.value" :value="option.value">
                                                        {{ option.label }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="w-7/12">
                                                <select v-model="servicioDetalle.servicio_id"  class="mt-1 w-full border-gray-300 rounded-md shadow-sm text-xs" @change="handleChange(dia.nro_dia, index)">
                                                    <option disabled value="0">-- Selecciona una opción --</option>
                                                    <option v-for="item in servicios" :key="item.value" :value="item.value">
                                                        {{ item.label }}
                                                    </option>
                                                    <option value='__add_new__'>➕ Agregar nuevo...</option>
                                                </select>
                                            </div>
                                        </div>                                        
                                    </td>
                                    <td class="px-1 py-1">
                                        <textarea v-model="servicioDetalle.pasajero_servicios.observacion" name="observacion" class="mt-1 w-full border-gray-300 text-pink-900 italic text rounded-md shadow-sm text-sm"
                                            placeholder="Observación del Servicio" rows="2">
                                        </textarea>
                                    </td>
                                    <td class="px-1 py-1">
                                        <div class="flex space-x-1 justify-between">                                            
                                            <select v-model="servicioDetalle.pasajero_servicios.moneda" class="mt-1 w-2/6 border-gray-300 rounded-md shadow-sm text-xs">
                                                <option value="USD">USD</option>
                                                <option value="PEN">PEN</option>
                                            </select>
                                            <div class="flex space-x-1 w-4/6">
                                                <input 
                                                    type="text"
                                                    v-model="servicioDetalle.pasajero_servicios.monto"
                                                    @input="handleMontoInput($event, dia.id, servicioDetalle.id)"
                                                    @blur="formatMonto(dia.id, servicioDetalle.id)"
                                                    class="monto-input mt-1 w-full border-gray-300 rounded-md shadow-sm text-right text-xs"
                                                />                                                
                                                <input
                                                    type="number"
                                                    v-model="servicioDetalle.pasajero_servicios.cantidad_pasajeros"
                                                    min="1"
                                                    @input="calcularSubtotal(dia.id, servicioDetalle.id)"
                                                    class="pasajeros-input mt-1 w-full border-gray-300 rounded-md shadow-sm text-right text-xs"
                                                />                                                
                                                <input 
                                                    type="text" 
                                                    :value="calcularSubtotalDisplay(dia.id, servicioDetalle.id)" 
                                                    readonly 
                                                    disabled="true" 
                                                    class="subtotal-input mt-1 w-full border-gray-300 rounded-md shadow-sm text-right text-xs"
                                                />
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-1 py-1 text-sm">
                                        <AsignarPasajerosServicio
                                            :pasajeros-disponibles="PasajerosReducido"
                                            v-model="servicioDetalle.pasajero_servicios.pasajerosAsignados"
                                            :servicio="servicioDetalle.pasajero_servicios"
                                        />
                                    </td>
                                    <td class="px-1 py-1 text-sm">
                                        <div class="flex space-x-2">
                                            <div class="w-2/3">
                                                <select v-model="servicioDetalle.pasajero_servicios.estatus" class="border-gray-300 rounded-md shadow-sm text-xs">
                                                    <option value="0">PENDIENTE</option>
                                                    <option value="1">CONFIRMADA</option>
                                                    <option value="2">CANCELADA</option>
                                                    <option value="3">XPASAJERO</option>
                                                </select>
                                            </div>
                                            <div class="w-1/3 flex justify-between">
                                                <button @click="agregarDetalle(dia.nro_dia, index, dia.id)" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                                <button @click="eliminarDetalle(dia.nro_dia, index)" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                    <!-- </td>
                                    <td scope="col" className="px-1 py-1 font-medium text-gray-900"> -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="showInput">
                            <input v-model="newItem" placeholder="Nuevo ítem" />
                            <button @click="addItem">Agregar</button>
                        </div>
                    </div>

                    <div class="totales-section">
                        <h3>Totales por Moneda</h3>
                        <ul>
                            <li v-for="(total, moneda) in totalesPorMoneda" :key="moneda">
                            {{ moneda }}: {{ total.toFixed(2) }}
                            </li>
                        </ul>
                        <p>Total General: {{ calcularTotalGeneral.toFixed(2) }}</p>
                    </div>

                    <ServicioDetalle v-if="listaServicioDetalle.length > 0 || listaServicioDetalle.length != null"
                        :Lista_servicio_detalle = "listaServicioDetalle" 
                        :Lista_servicio_x_dia = "ListaServicioPasajeroTemp"
                        :Lista_Pasajeros = Cotizacion.pasajeros
                        v-model="contador"/>
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
                    <PrimaryButton type="submit" class="mt-2 uppercase bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" >
                        {{ Accion }}
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
    <PasajeroModal v-if="Cotizacion.pasajeros != null "
        :isModalVisible="showModal"
        :ListaPasajeros = Cotizacion.pasajeros
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
import { ref, watch, reactive, computed, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import ContadorInput from '@/ComponentModal/ContadorInput.vue';
import PrimaryButton from '../PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Datepicker from '@/Components/Datepicker.vue'; // Importa el componente
import ServicioDetalle from '@/Components/ServicioDetalle/CompServicioDetalleAdd.vue';
import PasajeroModal from '@/Pages/Pasajero/CompModalPasajero.vue';
import ClienteModal from '@/Components/Proveedor/CompModalProveedor.vue';
import getCotizacionInicial from '@/models/cotizacionModel.js';
import getPersonaInicial from '@/models/personaModel.js';
import { useCategoriesStore } from '@/Stores/categories';
import { validateNumberInput } from '@/Utils/validators';
import calcularDiferenciaDias from '@/Utils/calculos';
import AsignarPasajerosServicio from '@/Components/AsignarPasajerosServicio.vue';
import InputHora from "@/Components/InputHora.vue";

import { de, te } from 'date-fns/locale';

const categoriesStore = useCategoriesStore();

// Definir las props
const props = defineProps({
    Accion: {
        type: String,
        required: true,
    },
    Cotizacion: {
        type: Object,
        required: true,
    },
    Lista_destinos_turistico: {
        type: Object,
        required: true,
    },
});

const esEdicion = computed(() => props.Accion === 'edit');

// const esHoraValida = ref(true);

const sTipoComprobante = ref([...categoriesStore.globals.tipo_comprobantes]);
const sPais = ref([...categoriesStore.globals.pais]);
const sIdioma = ref([...categoriesStore.globals.idioma]);
const sMercado = ref([...categoriesStore.globals.mercado]);
const sCategoriaProveedor = ref([...categoriesStore.globals.proveedor_categories]);

const servicios = ref([])


const axiosServicios = async () => {
    try {
        const response = await axios.post(`${route('servicio')}/servicioList`, {proveedor_id: null});
        servicios.value = response.data
    } catch (error) {
        console.error('Error al recuperar usuarios:', error)
    }
}

const serviciosPorDia = ref([])

onMounted(() => {
  axiosServicios();
})

// Variables reactivas
const error = ref('');
const ultimaAccion = ref('');
const showModal = ref(false);
const showModalProveedor = ref(false);
const DestinoTuristico = props.Lista_destinos_turistico
const fechaActual = ref(new Date());
const ListaServicioPasajeroTemp = reactive([]);
const listaServicioDetalle = ref([]);

const EstadoCotizacion = ref([
    { value: '0', label: 'PENDIENTE' },
    { value: '1', label: 'CONFIRMADA' },
    { value: '2', label: 'CANCELADA' },
]);

// Timer para controlar el delay
let emptyInputTimeout = null;

// Variables para el cotizacion y detalle temporal
//const Cotizacion = reactive(getCotizacionInicial());
const Cotizacion = reactive(props.Cotizacion); // || reactive(getCotizacionInicial());



// Cotizacion.file_nro = props.Correlativo;
Cotizacion.fecha = esEdicion.value ? new Date(Cotizacion.fecha) : fechaActual.value;
Cotizacion.fecha_inicio = esEdicion.value ? new Date(Cotizacion.fecha_inicio) : fechaActual.value;
Cotizacion.fecha_fin = esEdicion.value ? new Date(Cotizacion.fecha_fin) : fechaActual.value;

const pasajero = ref(getPersonaInicial());

const errorFecha = ref("");
const PasajerosReducido = computed(() =>
  Cotizacion.pasajeros.map(p => ({
    get id() { return p.id },
    set id(val) { p.id = val },
    get temp_id() { return p.temp_id },
    set temp_id(val) { p.temp_id = val },
    get nombre() { return p.nombre },
    set nombre(val) { p.nombre = val },
    get tipo_pasajero_id() { return p.tipo_pasajero_id },
    set tipo_pasajero_id(val) { p.tipo_pasajero_id = val },
  }))
)

if (esEdicion.value) {
    serviciosPorDia.value = Cotizacion.pasajeros_servicios_agrupados;
    listaServicioDetalle.value = calcularMontoTotalXCategoria(Cotizacion.destinos_turisticos);
    agregarServicioPasajeroTemp();
    //calcularVenta();
}


// Observa cambios en `nro_pasajeros` y ejecuta `calcularVenta`
watch(() => Cotizacion.nro_pasajeros, (newNroPasajeros) => {
  agregarServicioPasajeroTemp();
  calcularVenta();
});

const showInput = ref(false)
const newItem = ref('')


function handleChange(indiceDia, indiceServicio) {
    const servicioDetalle = serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio];
  if (servicioDetalle.servicio_id == '__add_new__') {
    showInput.value = true
    servicioDetalle.servicio_id = '0'
  }
}

function addItem() {
  if (newItem.value.trim()) {
    items.value.push(newItem.value.trim())
    newItem.value = ''
    showInput.value = false
  }
}


function agregarServicioPasajeroTemp() {
    const nuevaLista = Cotizacion.destinos_turisticos.itinerario_destinos.map(servicio => {
        return {
            nro_dia: servicio.nro_dia,
            itinerario_destinos: PasajerosReducido.value.map(pasajero => ({
                pasajero,
                servicio: '',
                itinerario_servicios: [...servicio.itinerario_servicios]
            }))
        };
    });
  

    ListaServicioPasajeroTemp.splice(0, ListaServicioPasajeroTemp.length, ...nuevaLista);

    Cotizacion.destino_turistico_detalle = serviciosPorDia.value; // ListaServicioPasajeroTemp;
}

async function recuperarValorModal(persona) {
    showModalProveedor.value = false;
    Cotizacion.proveedor_id = persona.id;
    Cotizacion.proveedor_razon_social = persona.razon_social;
    const nroDoc = document.getElementById('cliente_nro_doc');
    nroDoc.value = persona.ruc;
    Cotizacion.cliente_nro_doc = persona.ruc;
}

//#region SECCION CALCULAR SUBTOTAL Y TOTAL DE LA NUEVA LOGICA DE SERVICIOS POR DIA

// Métodos para manejar montos (igual que antes)
const handleMontoInput = (event, diaId, servicioId) => {
  const dia = serviciosPorDia.value.find(d => d.id === diaId)
  const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)
  
  if (servicio) {
    let value = event.target.value.replace(/[^0-9.]/g, '')
    const parts = value.split('.')
    if (parts.length > 2) value = parts[0] + '.' + parts.slice(1).join('')
    if (parts.length === 2) value = parts[0] + '.' + parts[1].slice(0, 2)
    
    servicio.pasajero_servicios.monto = value
    calcularSubtotal(diaId, servicioId)
  }
}

const formatMonto = (diaId, servicioId) => {
  const dia = serviciosPorDia.value.find(d => d.id === diaId)
  const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)
  
  if (servicio) {
    let monto = parseFloat(servicio.pasajero_servicios.monto) || 0
    servicio.pasajero_servicios.monto = monto.toFixed(2)
    calcularSubtotal(diaId, servicioId)
  }
}

// Calcular subtotal cuando cambia monto o cantidad
const calcularSubtotal = (diaId, servicioId) => {
  const dia = serviciosPorDia.value.find(d => d.id === diaId)
  const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)
  
  if (servicio) {
    const monto = parseFloat(servicio.pasajero_servicios.monto) || 0
    const cantidad = servicio.pasajero_servicios.cantidad_pasajeros || 1
    servicio.pasajero_servicios.subtotal = monto * cantidad
  }
}

// Mostrar subtotal formateado
const calcularSubtotalDisplay = (diaId, servicioId) => {
//   const dia = serviciosPorDia.value.find(d => d.id === diaId)
//   const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)
  return 0 // servicio ? (servicio.pasajero_servicios.subtotal || 0).toFixed(2) : '0.00'
}

// Computed: Totales por moneda (ahora usa subtotal)
const totalesPorMoneda = computed(() => {
  const resultado = {}
  
//   serviciosPorDia.value.forEach(dia => {
//     dia.itinerario_servicios.forEach(servicio => {
//       const moneda = servicio.pasajero_servicios.moneda
//       const subtotal = parseFloat(servicio.pasajero_servicios.subtotal) || 0
      
//       resultado[moneda] = (resultado[moneda] || 0) + subtotal
//     })
//   })
  
  return resultado
})

// Computed: Total general (suma de todos los subtotales)
const calcularTotalGeneral = computed(() => {
  return Object.values(totalesPorMoneda.value).reduce((sum, total) => sum + total, 0)
})

// #endregion SECCION CALCULAR SUBTOTAL Y TOTAL DE LA NUEVA LOGICA DE SERVICIOS POR DIA

function agregarDetalle(indice, index, itinerarioDestinoId = null) {
    debugger;
    const nuevoServicio = {
        id: null,
        nro_orden: '',
        servicio_id: '0',
        itinerario_destino_id: '0',
        proveedor_categoria_id: '0',
        proveedor_id: '0',
        servicio: {
            id: '',
            proveedor_id: '0',
            servicio_detalle_id: '0',
            ubicacion_id: '0',
            estado_activo: '1',
            precios: []
        },
        pasajero_servicios: {
            id: null,
            cotizacion_id: Cotizacion.id,
            itinerario_servicio_id: '',
            itinerario_destino_id: itinerarioDestinoId,
            hora: '21:00',
            pasajerosAsignados: [],
            observacion: '',
            moneda: 'USD',
            monto: 0,
            cantidad_pasajeros: 1,
            subtotal: 0,
            estatus: '0', // PENDIENTE
            estado_activo: '1'
        }
    };
    // Agregar el nuevo servicio al último día de serviciosPorDia
    if (serviciosPorDia.value.length > 0) {
        serviciosPorDia.value[Number(indice) - 1].itinerario_servicios.splice(Number(index) + 1, 0, nuevoServicio).push(nuevoServicio);
    } else {
        // Si no hay días, crear uno nuevo  
        serviciosPorDia.value.push({
            nro_dia: 1,
            itinerario_id: '',
            nombre: '',
            observacion: '',
            estado_activo: 1,
            destino_turistico_id: '',
            itinerario_servicios: [nuevoServicio]
        });
    }
}

function eliminarDetalle(indice, index) {
    serviciosPorDia.value[Number(indice) - 1].itinerario_servicios.splice(Number(index), 1);
}
 
async function ListaCategoriaProveedor() {
    try {     
        const data = {
            destino_turistico_id: Cotizacion.destino_turistico_id,
        }     
        const response = await axios.post(`${route('destino_turistico')}/destinoServicios`, {destino_turistico_id: Cotizacion.destino_turistico_id});  
        if (response.status === 200) {
            console.log("Lista de servicios por dia", response.data);
            const servicioAxios = response.data.itinerario_destinos.map(dia => ({
                ...dia,
                itinerario_servicios: dia.itinerario_servicios.map(itinerarioServicios => ({
                    ...itinerarioServicios,
                    pasajero_servicios: {
                        id: null,
                        cotizacion_id: Cotizacion.id,
                        itinerario_servicio_id: itinerarioServicios.id,
                        itinerario_destino_id: dia.id,
                        hora: '09:00',
                        pasajerosAsignados: [],
                        observacion: '',
                        moneda: itinerarioServicios.servicio.precios[0].moneda == "DOLARES" ? 'USD' : 'PEN',
                        monto: itinerarioServicios.servicio.precios[0].monto,
                        cantidad_pasajeros: 1,
                        subtotal: itinerarioServicios.servicio.precios[0].monto * 1,
                        estatus: '0', // PENDIENTE
                        estado_activo: '1'
                    },
                }))
            }));
            
            serviciosPorDia.value = reactive(servicioAxios);

            Cotizacion.nro_dias = response.data.nro_dias;
            const fechaInicio = new Date(Cotizacion.fecha_inicio);
            fechaInicio.setDate(fechaInicio.getDate() + response.data.nro_dias);
            const fechaFina = new Date(fechaInicio);
            Cotizacion.fecha_fin = fechaFina; 
            
            listaServicioDetalle.value = calcularMontoTotalXCategoria(response.data);
            Cotizacion.destinos_turisticos.itinerario_destinos = response.data.itinerario_destinos;
            agregarServicioPasajeroTemp();
            calcularVenta();
        }               
    } catch (error) {
        console.error('Error al actualizar los datos:', error);
    }        
};

function calcularMontoTotalXCategoria(destino) {
    const resultado = {};
    destino.itinerario_destinos.forEach(detalle => {
        detalle.itinerario_servicios.forEach(servicio => {
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
    return Object.values(resultado);
}

// #region SECCION DE MANIPULACION DE FECHAS

// **Validar que fecha_inicio nunca sea mayor a fecha_fin**
watch([() => Cotizacion.fecha_inicio, () => Cotizacion.fecha_fin], ([inicio, fin]) => {
    if (new Date(inicio) > new Date(fin)) {
        errorFecha.value = "La fecha de inicio no puede ser mayor que la fecha fin.";
    } else {
        errorFecha.value = "";
    }
    Cotizacion.nro_dias = calcularDiferenciaDias(Cotizacion.fecha_inicio, Cotizacion.fecha_fin);
});

function manejarCambioFecha(fechaInicio) {
  //alert(`Seleccionaste: ${fechaInicio.toLocaleDateString('es-ES')}`)
  const nuevaFechaFin = new Date(fechaInicio)
  nuevaFechaFin.setDate(nuevaFechaFin.getDate() + Cotizacion.nro_dias - 1); // Restamos 1 porque la fecha de inicio cuenta como el primer día
  Cotizacion.fecha_fin = nuevaFechaFin
}
// #endregion SECCION DE MANIPULACION DE FECHAS

// #region SECCION INCREMENTO Y DECREMENTO DE PASAJEROS
const handleInput = (event, field) => {
  const validatedValue = validateNumberInput(event.target.value);
  Cotizacion[field] = Number(validatedValue);

  // Limpiar cualquier temporizador existente
  if (emptyInputTimeout) {
    clearTimeout(emptyInputTimeout);
  }

  // Si el input está vacío, esperar 1 segundo antes de asignar "0"
  if (!validatedValue) {
    emptyInputTimeout = setTimeout(() => {
      Cotizacion[field] = 0;
      calcularVenta(validatedValue);
    }, 1000); // 1000 ms = 1 segundo
  } else {
    // Calcular venta si el valor es válido
    calcularVenta(validatedValue);
  }
};

const tipoPasajeroPorId = {
  nro_ninio: '1',
  nro_estudiante: '2',
  nro_adulto: '3'
};

const manejarAccion = ({ accion, id }) => {
  ultimaAccion.value = { accion, id };

  const tipo_pasajero = tipoPasajeroPorId[id];
  if (!tipo_pasajero) return;

  (accion === 'incremento' ? agregarPasajero : eliminarPasajero)(tipo_pasajero);
};

const recalcularTotalPasajeros = () => {
    Cotizacion.nro_ninio = contarPasajerosPorTipo('1');
    Cotizacion.nro_estudiante = contarPasajerosPorTipo('2');
    Cotizacion.nro_adulto = contarPasajerosPorTipo('3');
};

const contarPasajerosPorTipo = (tipo) => {
    return Cotizacion.pasajeros.filter((pasajero) => pasajero.tipo_pasajero_id === tipo).length || 0;
};

// Observar cambios en los valores de adultos, niños y bebés
watch([() => Cotizacion.nro_adulto, () => Cotizacion.nro_ninio, () => Cotizacion.nro_estudiante], ([new_nro_adulto, new_nro_ninio, new_nro_estudiante]) => {
    Cotizacion.nro_pasajeros = new_nro_adulto + new_nro_ninio + new_nro_estudiante;
}, { immediate: true });

// Computed reactivo para que cambie cuando cotizacion.nro_pasajeros cambie
const contador = computed(() => Cotizacion.nro_pasajeros);

function agregarPasajero(tipoPasajero) {
    const nuevo = getPersonaInicial();
    nuevo.tipo_pasajero_id = tipoPasajero;
    nuevo.id = Cotizacion.pasajeros.length + 1;
    Cotizacion.pasajeros.push(nuevo);
}

const eliminarPasajero = (tipoPasajero) => {
    const index = Cotizacion.pasajeros.findIndex(
        (pasajero) => pasajero.tipo_pasajero_id === tipoPasajero
    );
    if (index >= 0) {
        Cotizacion.pasajeros.splice(index, 1);
    }
}

// #endregion SECCION INCREMENTO Y DECREMENTO DE PASAJEROS

const mostrarConsola = () => {
    console.log(Cotizacion);
    const jsonData = JSON.stringify(Cotizacion, null, 2);
    console.log("JSON Data:", jsonData);
}

// Función para calcular el monto de la venta
const calcularVenta = () => {
    const sumaTotal = listaServicioDetalle.value.reduce((acc, item) => acc + (item.total_monto * Cotizacion.nro_pasajeros), 0);
    const sumaDescuentos = Number(Cotizacion.descuento_estudiante) + Number(Cotizacion.descuento_ninio) + Number(Cotizacion.descuento_otro);
    Cotizacion.costo_parcial = sumaTotal;
    Cotizacion.costo_total = sumaTotal - sumaDescuentos;
};

function agregarDetalleDatosPasajero() {
    showModal.value = true;
}

async function submitCotizacion() {
    try {
        Swal.fire({
            title: 'Cargando...',
            text: 'Por favor, espera mientras se cargan los datos.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        Cotizacion.destino_turistico_detalle_monto_x_categoria = listaServicioDetalle.value;
        const response = await axios.post(route('cotizacion.store'), Cotizacion, {
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
    /* .monto-input, .pasajeros-input {
        width: 80px;
        padding: 5px;
        text-align: right;
        border: 1px solid #ccc;
        border-radius: 3px;
    } */

.subtotal {
  font-weight: bold;
  text-align: right;
  padding-right: 15px;
}

.totales-section {
  margin-top: 20px;
  padding: 15px;
  background-color: #f5f5f5;
  border-radius: 5px;
}

.totales-section h3 {
  margin-top: 0;
}

.totales-section ul {
  list-style-type: none;
  padding: 0;
}

.totales-section li {
  margin-bottom: 5px;
  font-weight: bold;
}
</style>