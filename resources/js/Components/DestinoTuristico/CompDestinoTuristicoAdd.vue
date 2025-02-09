<template>
    <div class="container mx-auto">
      <form @submit.prevent="submitProveedor">
        <div class="grid grid-cols-3 gap-4 w-full p-5">
            <!-- Primera fila -->
            <div class="col-span-1 ">
                <label for="nombre" class=" text-sm font-medium text-gray-700">Programa</label>
                <input v-model="destinoTuristico.nombre" type="text" id="nombre" class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el Programa">
            </div>
            <div class="col-span-2 ">
                <label for="descripcion" class=" text-sm font-medium text-gray-700">Descripcion</label>
                <textarea v-model="destinoTuristico.descripcion" type="textarea" id="descripcion" required="true" class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese la Descripcion"></textarea>
            </div>

            <!-- Segunda fila -->
            <div class="col-span-1">
                <label for="pais" class="block text-sm font-medium text-gray-700">Pais</label>
                <select v-model="destinoTuristico.tipo_sunat" id="tipo_sunat" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <!-- <option v-for="options in tiposSunat" :key="options.id" :value="options.id">
                    {{ options.nombre }}
                    </option> -->
                </select>  
            </div>
            <div class="col-span-1">
                <label for="nro_dias" class="block text-sm font-medium text-gray-700">Nro dias</label>  
                <select v-model="destinoTuristico.nro_dias" id="nro_dias" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <!-- <option v-for="options in tiposDocumento" :key="options.id" :value="options.id">
                    {{ options.nombre }}
                    </option> -->
                </select>     
            </div>
            <div class="col-span-1">
                <label for="estado_activo" class="block text-sm font-medium text-gray-700">Estado Activo</label>
                <select v-model="destinoTuristico.estado_activo" id="estado_activo" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in estadoActivo" :key="option.id" :value="option.id">
                    {{ option.nombre }}
                    </option>
                </select>
            </div>  
            <div class="col-span-3">
                <PrimaryButton 
                    type="button"
                    class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    @click="agregarDetalle"
                    >
                    Agregar
                </PrimaryButton>
                <DestinioTuristicoDetalle
                    :Lista_destino_turistico_detalle="destinoTuristico.destino_turistico_detalle"
                    :Lista_proveedor_categorias="ProveedorCategorias"
                    :Lista_proveedor="Proveedor"
                    :Lista_servicio_clase="ServicioClases" 
                    :Lista_servicio_detalle="ServicioDetalles"   
                    @update="updateDetalles"
                />   
            </div>
              
<!-- Tercera fila -->
            <div class="col-span-1">
                <label for="costo_total" class="block text-sm font-medium text-gray-700">Costo total</label>
                <input v-model="destinoTuristico.costo_total" type="text" id="costo_total" required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Costo total">
            </div>
            <div class="col-span-1 ">
                <label for="ruc" class=" text-sm font-medium text-gray-700">Margen</label>
                <div class="flex items-center space-x-2">
                    <select v-model="destinoTuristico.descuento_tipo" id="  descuento_tipo" class="w-full border-gray-300 rounded-md shadow-sm">
                        <!-- <option disabled value="">-- Selecciona una opción --</option> -->
                        <option v-for="option in descuentoTipo" :key="option.id" :value="option.id">
                        {{ option.nombre }}
                        </option>
                    </select>
                    <input v-model="destinoTuristico.ruc" type="text" id="ruc" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el Margen monto">      
                </div>
            </div>            
            <div class="col-span-1">
                <label for="venta" class="block text-sm font-medium text-gray-700">Venta</label>
                <input v-model="destinoTuristico.venta" type="text" id="venta" required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Venta">
            </div>                    
        </div>
        <!-- Botón para agregar el ítem -->  
        <PrimaryButton type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">Registrar</PrimaryButton>
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
        Lista_proveedor_categorias: {
            type: Object,
            required: true,
        },
        Lista_proveedor: {
            type: Object,
            required: true,
        },
        Lista_servicio_clase: {
            type: Object,
            required: true,
        },
        Lista_servicio_detalle: {
            type: Object,
            required: true,
        },
    });

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
        dias: '1',
        costo_total: '0.00',
        descuento_tipo: '1',
        descuento_estudiante: '0.00',
        descuento_ninio: '0.00',
        descuento_otros: '0.00',
        margen: '',
        venta: '0.00',
        estado_activo: '1',

        destino_turistico_detalle: [],
    });  

    const destinoTuristicoDetalle = ref({
        nro_dia: '',
        nombre: 'asda',
        descripcion: '',
        estado_activo: '',
        destino_turistico_id: '', 

        destino_turistico_detalle_servicio: [],
    });
    
    // Variables reactivas
    const error = ref('');
    const ProveedorCategorias = ref([...props.Lista_proveedor_categorias]);
    const Proveedor = ref([...props.Lista_proveedor]);
    const ServicioDetalles = ref([...props.Lista_servicio_detalle]);
    const ServicioClases = ref([...props.Lista_servicio_clase]);    

    function updateDetalles(nuevosDetalles) {
        destinoTuristicoDetalle.value = nuevosDetalles;
    }
    
    function agregarDetalle() {
        destinoTuristico.value.destino_turistico_detalle.push({ ...destinoTuristicoDetalle.value });
        destinoTuristicoDetalle.value = {
            nro_dia: destinoTuristico.value.destino_turistico_detalle.length + 1,
            nombre: '',
            descripcion: '',
            estado_activo: '',
            destino_turistico_id: '', 

            destino_turistico_detalle_servicio: [],
        };
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