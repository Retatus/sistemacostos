<template>
  <div v-if="isOpen" class="modal-container">
    <div class="modal-content">
      <h2>Agregar Servicio al Itinerario</h2>

      <!-- =========================
           CATEGORÍA
      ========================== -->
      <div class="form-group">
        <label for="categoria">Categoría</label>

        <select
          id="categoria"
          v-model="categoriaSeleccionada"
        >
          <option value="">Seleccione una categoría</option>

          <option
            v-for="categoria in categorias"
            :key="categoria.id"
            :value="categoria.id"
          >
            {{ categoria.nombre }}
          </option>
        </select>
      </div>

      <!-- =========================
           PROVEEDOR
      ========================== -->
      <div class="form-group">
        <label for="proveedor">Proveedor</label>

        <select
          id="proveedor"
          v-model="proveedorSeleccionado"
          :disabled="!categoriaSeleccionada"
        >
          <option value="">Seleccione un proveedor</option>

          <option
            v-for="proveedor in proveedores"
            :key="proveedor.id"
            :value="proveedor.id"
          >
            {{ proveedor.razon_social }}
          </option>
        </select>
      </div>

      <!-- =========================
           SERVICIO
      ========================== -->
      <div class="form-group">
        <label for="servicio">Servicio</label>

        <select
          id="servicio"
          v-model="servicioSeleccionado"
          :disabled="!proveedorSeleccionado"
        >
          <option value="">Seleccione un servicio</option>

          <option
            v-for="servicio in servicios"
            :key="servicio.id"
            :value="servicio.id"
          >
            {{ servicio.servicio_detalles.descripcion }}
          </option>
        </select>
      </div>

      <!-- =========================
           POSICIÓN
      ========================== -->
      <div class="form-group">
        <label for="posicion">Agregar servicio</label>

        <select
          id="posicion"
          v-model="posicion"
        >
          <option value="inicio">Al inicio del día</option>
          <option value="fin">Al final del día</option>
          <option value="antes">Antes de...</option>
          <option value="despues">Después de...</option>
        </select>
      </div>

      <!-- =========================
           SERVICIO REFERENCIA
           SOLO SI ES ANTES/DESPUÉS
      ========================== -->
      <div
        v-if="requiereReferencia"
        class="form-group"
      >
        <label for="referencia">
          Servicio de referencia
        </label>

        <select
          id="referencia"
          v-model="servicioReferenciaId"
        >
          <option value="">
            Seleccione un servicio
          </option>

          <option
            v-for="item in itinerarioActual"
            :key="item.id"
            :value="item.id"
          >
            {{ item.nombre_servicio }}
          </option>
        </select>
      </div>

      <!-- =========================
           ACCIONES
      ========================== -->
      <div class="actions">
        <button @click="cerrarModal">
          Cancelar
        </button>

        <button @click="guardarServicio">
          Confirmar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import axios from "axios";

const emit = defineEmits([
  "close",
  "servicio-agregado"
]);

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  itinerarioActual: {
    type: Array,
    default: () => []
  }
});

const loadingCategorias = ref(false);
const loadingProveedores = ref(false);
const loadingServicios = ref(false);

const categorias = ref([]);
const proveedores = ref([]);
const servicios = ref([]);

const categoriaSeleccionada = ref("");
const proveedorSeleccionado = ref("");
const servicioSeleccionado = ref("");

const posicion = ref("fin");
const servicioReferenciaId = ref("");

function resetearFormulario() {
  categoriaSeleccionada.value = "";
  proveedorSeleccionado.value = "";
  servicioSeleccionado.value = "";
  posicion.value = "fin";
  servicioReferenciaId.value = "";
  
  // Limpia listas dependientes para evitar parpadeos de datos viejos
  proveedores.value = [];
  servicios.value = [];
}

// Escucha cuando el modal cambia de estado (abrir/cerrar)
watch(() => props.isOpen, async (nuevoValor) => {
  resetearFormulario();
  
  // Si se abre y la lista de categorías está vacía, la recarga
  if (nuevoValor && categorias.value.length === 0) {
    await cargarCategorias(); 
  }
});

function cerrarModal() {
  emit("close");
}

/**
 * =========================================================
 * COMPUTED
 * =========================================================
 */
const requiereReferencia = computed(() => {
  return (posicion.value === "antes" || posicion.value === "despues");  
});

/**
 * =========================================================
 * API
 * =========================================================
 */

/**
 * CARGAR CATEGORÍAS
 */
async function cargarCategorias() {
  try {
    loadingCategorias.value = true;
    const response = await axios.get(
      "http://127.0.0.1:8000/api/categorias"
    );
    categorias.value = response.data.categoriaproveedors;
  } catch (error) {
    console.error("Error cargando categorías", error);
  } finally {
    loadingCategorias.value = false;
  }
}

/**
 * CARGAR PROVEEDORES
 */
async function cargarProveedores() {
  if (!categoriaSeleccionada.value) {
    proveedores.value = [];
    return;
  }

  try {
    loadingProveedores.value = true;
    const response = await axios.get(
      `http://127.0.0.1:8000/api/proveedores/${categoriaSeleccionada.value}`
    );
    proveedores.value = response.data.proveedores;
  } catch (error) {
    console.error("Error cargando proveedores", error);
  } finally {
    loadingProveedores.value = false;
  }
}

/**
 * CARGAR SERVICIOS
 */
async function cargarServicios() {
  if (!proveedorSeleccionado.value) {
    servicios.value = [];
    return;
  }

  try {
    loadingServicios.value = true;
    const response = await axios.get(
      `http://127.0.0.1:8000/api/servicios/proveedor/${proveedorSeleccionado.value}`
    );
    servicios.value = response.data.servicios;
    console.log("Servicios cargados:", servicios.value);
  } catch (error) {
    console.error("Error cargando servicios", error);
  } finally {
    loadingServicios.value = false;
  }
}

/**
 * =========================================================
 * WATCHERS DE FORMULARIO
 * =========================================================
 */

/**
 * Cuando cambia categoría:
 * - limpiar proveedor
 * - limpiar servicio
 * - cargar proveedores
 */
watch(categoriaSeleccionada, async () => {
  proveedorSeleccionado.value = "";
  servicioSeleccionado.value = "";
  servicios.value = [];
  await cargarProveedores();
});

/**
 * Cuando cambia proveedor:
 * - limpiar servicio
 * - cargar servicios
 */
watch(proveedorSeleccionado, async () => {
  servicioSeleccionado.value = "";
  await cargarServicios();
});

/**
 * =========================================================
 * MOUNT
 * =========================================================
 */
onMounted(async () => {
  await cargarCategorias();
});

/**
 * =========================================================
 * GUARDAR
 * =========================================================
 */
function guardarServicio() {
  const servicio = servicios.value.find(
    item => item.id === servicioSeleccionado.value
  );

  console.log("Servicio seleccionado:", servicio);

  if (!servicio) {
    alert("Seleccione un servicio");
    return;
  }

  /**
   * Tomar primer precio disponible
   */
  const precio = servicio.precios?.[0] || null;

  const payload = {
    servicio: {
      id: null,
      servicio_id: servicio.id,
      proveedor_id: proveedorSeleccionado.value,
      orden: 0,
      hora: "00:30",
      nombre_servicio: servicio.servicio_detalles.descripcion,
      observacion: `${servicio.servicio_detalles.descripcion}`,
      tipo_costo_id: precio?.tipo_costo_id || null,
      tipo_habitacion_id: precio?.tipo_habitacion_id || null,
      precio_id: precio?.id || null,
      moneda: precio?.moneda || "USD",
      precio_unitario: precio?.monto || 0,
      cantidad: 1,
      capacidad: precio?.capacidad || 1,
      subtotal: precio?.monto || 0,
      estado_activo: 1,
      pasajeros: [],
      servicio: {
        id: servicio.id,
        proveedor_id: proveedorSeleccionado.value,
        servicio_detalles_id: servicio.servicio_detalles.id,
        ubicacion_id: servicio.ubicacion_id,
        estado_activo: servicio.estado,
        precios: servicio.precios || [],
        servicio_detalles: {
          id: servicio.servicio_detalles.id,
          descripcion: servicio.servicio_detalles.descripcion,
          proveedor_categoria_id: servicio.servicio_detalles.proveedor_categoria_id,
          proveedor_categoria: {
            id: servicio.servicio_detalles.proveedor_categoria_id,
            nombre: categorias.value.find(c => c.id === servicio.servicio_detalles.proveedor_categoria_id)?.nombre || ""
          }
        },
        proveedor: {
          id: proveedorSeleccionado.value,
          ruc: proveedores.value.find(p => p.id === proveedorSeleccionado.value)?.ruc || "",
          razon_social: proveedores.value.find(p => p.id === proveedorSeleccionado.value)?.razon_social || "",
          proveedor_categoria_id: proveedores.value.find(p => p.id === proveedorSeleccionado.value)?.proveedor_categorias || []
        },
      },
    },
    posicion: posicion.value,
    servicioReferenciaId: servicioReferenciaId.value || null
  };

  emit("servicio-agregado", payload);
}
</script>


<style scoped>
/* Fondo oscuro que cubre toda la pantalla */
.modal-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5); /* Color negro transparente */
  display: flex;
  justify-content: center; /* Centra horizontalmente */
  align-items: center; /* Centra verticalmente */
  z-index: 9999; /* Asegura que esté por encima de todo */
}

/* La caja blanca del formulario */
.modal-content {
  background-color: #ffffff;
  padding: 24px;
  border-radius: 8px;
  width: 100%;
  max-width: 500px; /* Tamaño máximo del cuadro */
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Sombra elegante */
}

/* Estilos básicos para ordenar los formularios */
.form-group {
  margin-bottom: 16px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: bold;
  margin-bottom: 6px;
}

.form-group select {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 20px;
}

.actions button {
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}
</style>