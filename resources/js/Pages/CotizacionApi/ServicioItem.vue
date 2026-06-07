<template>
  <div class="servicio-row" :style="{ backgroundColor: servicio.id === null ? '#f2f2f2' : '' }">    
    <div class="item_sm">
      <strong>Hora:</strong> {{ servicio.hora }} - {{ servicio.orden }}
    </div>

    <div class="item">
      <strong>Categoría:</strong> [{{ servicio.servicio?.servicio_detalles?.proveedor_categoria_id }}] {{ servicio.servicio?.servicio_detalles?.proveedor_categoria?.nombre }}
    </div>

    <div class="item">
      <strong>Proveedor:</strong> [{{ servicio.proveedor_id }}] {{ servicio.servicio?.proveedor?.razon_social }}
    </div>

    <div class="item">
      <strong>Servicio:</strong> [{{ servicio.servicio_id }}] {{ servicio.servicio?.servicio_detalles?.descripcion }}
    </div>

    <div class="item">
      <strong>Observación:</strong>
      <textarea v-model="servicio.observacion" rows="1" cols="30" placeholder="Ingrese observación..."></textarea>
    </div>

    <div class="item">
      <strong>Precio:</strong> [{{ servicio.precio_id }}] {{ servicio.moneda }} {{ servicio.monto }} cantidad: {{ servicio.cantidad }}
    </div>

    <div class="item">
      <strong>Precio Unitario:</strong> {{ servicio.moneda }} {{ servicio.servicio?.precio_unitario }}
      <input 
        type="text" 
        v-model="servicio.precio_unitario"
        readonly
        class="input-precio"
      />
    </div>

    <div class="item">
      <strong>Seleccionar Precio:</strong>
      <select v-model="servicio.precio_id" @change="actualizarPrecioUnitario"> <!-- @change="actualizarPrecioUnitario" -->
        <option value="">Seleccione precio</option>
        <option
          v-for="p in servicio?.servicio?.precios"
          :key="p.id"
          :value="p.id"
        >
          {{ p.tipo_costo }} - {{ p.monto }} [{{ p.tipo_costo_id }}] [{{ p.tipo_habitacion_id }}]
        </option>
      </select>
    </div>

    <div class="item_sm">
      <strong>Cantidad:</strong>
      <input type="number" v-model="servicio.cantidad" min="1" width="50px"/>
    </div>
    <div class="item_sm">
      <strong>Sub total:</strong> {{ servicio.cantidad * servicio.precio_unitario   }}
    </div>
    <div class="item_sm">
      <button @click="$emit('remove')">Eliminar</button>
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

<style scoped>
  .servicio-row {
    display: flex;
    flex-wrap: wrap;
    gap: 11px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .item_sm {
    flex: 1 1 50px;
  }

  .item {
    flex: 1 1 200px;
  }

  input {
    width: 100%;
    max-width: 80px;
  }
</style>