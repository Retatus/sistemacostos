<template>
  <div
    class="table-grid table-row"
    :style="{ backgroundColor: servicio.id === null ? '#f8fafc' : '' }"
  >
    <div>
      {{ servicio.orden }}
      <br>
      {{ servicio.hora }}
    </div>

    <div>
      [{{ servicio.servicio?.servicio_detalles?.proveedor_categoria_id }}]
      {{ servicio.servicio?.servicio_detalles?.proveedor_categoria?.nombre }}
    </div>

    <div>
      [{{ servicio.proveedor_id }}]
      {{ servicio.servicio?.proveedor?.razon_social }}
    </div>

    <div class="table-description">
      [{{ servicio.servicio_id }}]
      {{ servicio.servicio?.servicio_detalles?.descripcion }}
    </div>

    <div class="table-description">
      {{ servicio.observacion }}
    </div>

    <div>
      {{ servicio.moneda }}
      {{ servicio.monto }}
    </div>

    <div>
      <input
        type="text"
        v-model="servicio.precio_unitario"
        readonly
        class="table-number"
      />
    </div>

    <div>
      <select
        v-model="servicio.precio_id"
        @change="actualizarPrecioUnitario"
      >
        <option value="">Seleccione precio</option>

        <option
          v-for="p in servicio?.servicio?.precios"
          :key="p.id"
          :value="p.id"
        >
          {{ p.tipo_costo }}
          - {{ p.monto }}
        </option>
      </select>
    </div>

    <div>
      <input
        type="number"
        v-model="servicio.cantidad"
        min="1"
      />
    </div>

    <div class="table-number">
      {{
        (
          Number(servicio.cantidad || 0) *
          Number(servicio.precio_unitario || 0)
        ).toFixed(2)
      }}
    </div>

    <div class="table-action">
      <button @click="$emit('remove')">
        Eliminar
      </button>
    </div>
  </div>
</template>

<script setup>;
const props = defineProps({
  servicio: Object,
});

const emit = defineEmits(['remove']);

const actualizarPrecioUnitario = (evento) => {
  const {servicio} = props;
  
  const precioSeleccionado = props.servicio.servicio.precios.find(
    p => p.id === Number(evento.target.value)
  )
  
  if (precioSeleccionado) {
    servicio.precio_unitario = precioSeleccionado.monto
    servicio.servicio.precio_id = precioSeleccionado.id
    servicio.tipo_costo_id = precioSeleccionado.tipo_costo_id
    servicio.tipo_habitacion_id = precioSeleccionado.tipo_habitacion_id
    servicio.servicio.moneda = precioSeleccionado.moneda
    servicio.total = precioSeleccionado.monto * props.servicio.cantidad
  }
}
</script>
