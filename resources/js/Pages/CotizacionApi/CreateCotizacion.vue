<template>
  <div>
    <header class="form-header">
      <div class="badge" :class="esModoEdicion ? 'badge-edit' : 'badge-create'">
        {{ esModoEdicion ? 'Modo Edición (Autoguardado activo)' : 'Nueva Cotización' }}
      </div>
      <h1>{{ esModoEdicion ? 'Editar Cotización #' + cotizacion.id : 'Crear Nueva Cotización' }}</h1>
    </header>

    <div >
      <!-- IDENTIFICACIÓN -->
      <fieldset>
        <legend>Identificación</legend>

        <label>ID</label>
        <input type="number" name="id" v-model="cotizacion.id">

        <label>Proveedor</label>
        <input type="number" name="proveedor_id" v-model="cotizacion.proveedor_id">

        <label>Documento</label>
        <input type="text" name="proveedor_ruc" v-model="cotizacion.proveedor_ruc">

        <label>Nombre de proveedor</label>
        <input type="text" name="proveedor_razon_social" v-model="cotizacion.proveedor_razon_social" v-uppercase>

        <button type="button" @click="showModalProveedor = true"
            class="w-xs px-4 py-2.5 mt-2 bg-gradient-to-r from-sky-600 to-violet-700 text-white rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
            + Agregar Cliente
        </button>
      </fieldset>

      <!-- FILE -->
      <fieldset>
        <legend>Datos del File</legend>

        <label>Nro. File</label>
        <input type="text" name="file_nro" v-model="cotizacion.file_nro">

        <label>Nombre del File</label>
        <input type="text" name="file_nombre" v-model="cotizacion.file_nombre" v-uppercase>

        <label>Comprobante</label>
        <select name="comprobante_id" v-model="cotizacion.comprobante_id">
          <option value="" disabled>Seleccione</option>
          <option value="3">Boleta</option>
          <option value="2">Factura</option>
          <option value="1">Otros</option>
        </select>

        <label>Fecha</label>
        <input type="date" name="fecha" v-model="cotizacion.fecha">
      </fieldset>


      <!-- ESTADOS -->
      <fieldset>
        <legend>Estados</legend>

        <label>Estado Reserva</label>
        <select name="estado_reserva" v-model="cotizacion.estado_reserva">
          <option value="0">Pendiente</option>
          <option value="1">Confirmado</option>
          <option value="2">Cancelado</option>
        </select>

        <label>Estado Documentación</label>
        <select name="estado_documentacion" v-model="cotizacion.estado_documentacion">
          <option value="0">Incompleto</option>
          <option value="1">Completo</option>
        </select>

        <label>Estado Cotización</label>
        <select name="estado_cotizacion" v-model="cotizacion.estado_cotizacion">
          <option value="0">Borrador</option>
          <option value="1">Activa</option>
          <option value="2">Cerrada</option>
        </select>

        <label>Activo</label>
        <select name="estado_activo" v-model="cotizacion.estado_activo">
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
      </fieldset>


      <!-- PASAJEROS -->
      <fieldset>
        <legend>Pasajeros</legend>

        <label>Total Pasajeros</label>
        <input type="number" name="nro_pasajeros" v-model="cotizacion.nro_pasajeros">

        <label>Adultos</label>
        <input type="number" name="nro_adulto" v-model="cotizacion.nro_adulto">

        <label>Niños</label>
        <input type="number" name="nro_ninio" v-model="cotizacion.nro_ninio">

        <label>Estudiantes</label>
        <input type="number" name="nro_estudiante" v-model="cotizacion.nro_estudiante">
      </fieldset>

      <!-- DESTINO Y MERCADO -->
      <fieldset>
        <legend>Destino y Mercado</legend>

        <label>Idioma</label>
        <select name="idioma_id" v-model="cotizacion.idioma_id">
          <option value="" disabled>Seleccione</option>
          <option value="4">Italiano</option>
          <option value="3">French</option>
          <option value="2">Español</option>
          <option value="1">Inglés</option>
        </select>

        <label>Mercado</label>
        <select name="mercado_id" v-model="cotizacion.mercado_id">
          <option value="" disabled>Seleccione</option>
          <option value="1">Whatsaap</option>
          <option value="2">Recomendacion</option>
          <option value="3">Web</option>
        </select>

        <!-- DESTINO -->
        <label>Destino Turístico</label>
        <select name="destino_turistico_id" v-model="cotizacion.destino_turistico_id" @change="cargarDestino">
          <option value="0">Seleccione</option>
          <option v-for="d in destinos" :key="d.id" :value="d.id">
            {{ d.nombre }}
          </option>
        </select>

        <label>País</label>
        <select name="pais_id" v-model="cotizacion.pais_id">
          <option value="0">Seleccione</option>
          <option value="1">Perú</option>
          <option value="2">Chile</option>
        </select>
      </fieldset>

      <!-- FECHAS -->
      <fieldset>
        <legend>Fechas del Viaje</legend>

        <label>Fecha Inicio</label>
        <input type="date" name="fecha_inicio" v-model="cotizacion.fecha_inicio">

        <label>Fecha Fin</label>
        <input type="date" name="fecha_fin" v-model="cotizacion.fecha_fin">

        <label>Nro. Días</label>
        <input type="number" name="nro_dias" v-model="cotizacion.nro_dias">
      </fieldset>

      <!-- COSTOS -->
      <fieldset>
        <legend>Costos</legend>

        <label>Costo Parcial</label>
        <input type="number" step="0.01" name="costo_parcial" v-model="cotizacion.costo_parcial">

        <label>Descuento Estudiante</label>
        <input type="number" step="0.01" name="descuento_estudiante" v-model="cotizacion.descuento_estudiante">

        <label>Descuento Niño</label>
        <input type="number" step="0.01" name="descuento_ninio" v-model="cotizacion.descuento_ninio">

        <label>Descuento Otro</label>
        <input type="number" step="0.01" name="descuento_otro" v-model="cotizacion.descuento_otro">

        <label>Costo Total</label>
        <input type="number" step="0.01" name="costo_total" v-model="cotizacion.costo_total">
      </fieldset>

      <hr />     

      <PasajerosForm 
        v-model="cotizacion.pasajeros"
      />
      <!-- DIAS -->
      <DiaItem
        v-for="(dia, index) in cotizacion.dias"
        :key="index"
        :dia="dia"
        :diaIndex="index"
        @remove-servicio="removeServicio"        
      />

      <ClienteModal 
        :isModalVisibleProveedor="showModalProveedor" 
        :errorMessage="error"
        @close="showModalProveedor = false" 
        @submit="recuperarValorModal" 
      />

      <button 
        :disabled="!botonGuardarHabilitado" 
        @click="guardarCotizacionNueva"
        class="w-xs px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">                  
        Nueva Cotización
      </button>
    </div>    
  </div>
</template>

<script setup>
import { ref, onMounted, watch, watchEffect, computed  } from "vue";
import Swal from "sweetalert2";
import {
  getCotizacionEmpty,
  getDestino,
  getDestinoSelect,
  guardarCotizacion,
  getCotizacionById,
  //actualizarCotizacion
} from "@/Api/cotizacionApi";

import DiaItem from "@/Pages/CotizacionApi/DiaItem.vue";
import PasajerosForm from "@/Pages/CotizacionApi/PasajerosForm.vue";
import { calcularDiferenciaDias, calcularFechaFin } from '@/Utils/calculos.js';
import ClienteModal from '@/Components/Proveedor/CompModalProveedor.vue';
import DialogModal from "@/Components/DialogModal.vue";

const props = defineProps({
  id: [String, Number]
});

const cotizacionId = props.id ?? null;

const cotizacion = ref({
  destino_id: null,
  dias: [],
  pasajeros: [],
});

const destinos = ref([]);
const esModoEdicion = computed(() => !!cotizacion.value.id)

const botonGuardarHabilitado = computed(() => {
  return !esModoEdicion.value && cotizacion.value.dias?.length > 0
})

// 🔥 cargar encabezado vacío
const loadData = async () => {
  const [
    //categoriasRes,
    cotizacionRes,
    destinosSelectRes
  ] = await Promise.all([
    // api.get('/categorias'),
    getCotizacionEmpty(),
    getDestinoSelect()
  ])
  //state.categorias = categoriasRes.data
  cotizacion.value = cotizacionRes.data
  destinos.value = destinosSelectRes.data
}

const loadCotizacionEdit = async (id) => {
  const [
    cotizacionRes,
    destinosSelectRes
  ] = await Promise.all([
    getCotizacionById(id),
    getDestinoSelect()
  ]);

  cotizacion.value = cotizacionRes.data.data;   // 🔥 JSON idéntico al create
  destinos.value = destinosSelectRes.data;
  console.log("Cotización cargada para edición:", cotizacion.value);
};

// 🔥 cargar encabezado vacío
onMounted(async () => {
  if (cotizacionId) {
    await loadCotizacionEdit(cotizacionId);   // 🔥 cargar edición
  } else {
    await loadData();                         // 🔥 cargar vacío
  }
});

// 🔥 cargar destino
const cargarDestino = async () => {
  const res = await getDestino(cotizacion.value.destino_turistico_id);
  console.log("Destino cargado:", res.data.data);
  cotizacion.value.dias = res.data.data.dias;
  // cotizacion.value.destino_id = destinoId.value;
  cotizacion.value.nro_dias = res.data.data.nro_dias;
};

watch(
  () => cotizacion.value.pasajeros,
  (pasajeros) => {
    if (!pasajeros) return;

    cotizacion.value.nro_pasajeros = pasajeros.length;
    cotizacion.value.nro_adulto = pasajeros.filter(p => Number(p.tipo_pasajero_id) === 3).length;
    cotizacion.value.nro_estudiante = pasajeros.filter(p => Number(p.tipo_pasajero_id) === 1).length;
    cotizacion.value.nro_ninio = pasajeros.filter(p => Number(p.tipo_pasajero_id) === 2).length;
  },
  { deep: true }
);

watch(
  () => cotizacion.value.nro_dias,
  (nuevo) => {
    if (!cotizacion.value.fecha_inicio) return;
    cotizacion.value.fecha_fin = calcularFechaFin(cotizacion.value.fecha_inicio, nuevo);
  }
);

watchEffect(() => {

  const parcial = cotizacion.value.dias.reduce((totalDias, dia) => {

    return totalDias + dia.servicios.reduce((totalServicios, servicio) => {

      return totalServicios +
        (Number(servicio.precio_unitario || 0) *
        Number(servicio.cantidad || 0));

    }, 0);

  }, 0);
  
  const totalDescuento = Number(cotizacion.value.descuento_estudiante || 0) +
    Number(cotizacion.value.descuento_ninio || 0) +
    Number(cotizacion.value.descuento_otro || 0);

  cotizacion.value.costo_parcial = parcial.toFixed(2);
  cotizacion.value.costo_total = (parcial - totalDescuento).toFixed(2);
});

const removeServicio = async ({ diaIndex, servIndex }) => {
  const result = await Swal.fire({
    title: "¿Eliminar servicio?",
    text: `Eliminar servicio del día ${diaIndex + 1}, servicio ${servIndex + 1}`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  });

  if (result.isConfirmed) {
    cotizacion.value.dias[diaIndex].servicios.splice(servIndex, 1);
  }
};

// inicio modal proveedor
const showModalProveedor = ref(false);
const error = ref('');

async function recuperarValorModal(persona) {
  showModalProveedor.value = false;
  cotizacion.value.proveedor_id = persona.id;
  cotizacion.value.proveedor_ruc = persona.ruc;
  cotizacion.value.proveedor_razon_social = persona.razon_social;
}

// fin modal proveedor

// guardar
const guardarCotizacionNueva = async () => {
  console.log("Cotización a guardar:", cotizacion.value);
  cotizacion.value.destinos_turisticos = []; // 🔥 evitar enviar datos anidados complejos
  await guardarCotizacion(cotizacion.value);
  alert("Cotización guardada");
};
</script>