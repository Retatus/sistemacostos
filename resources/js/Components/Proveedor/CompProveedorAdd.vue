<template>
    <div class="container mx-auto">
      <form @submit.prevent="submitProveedor">
        <div class="grid grid-cols-3 gap-4 w-full p-5">
            <!-- Primera fila -->
            <div class="col-span-1 ">
                <label for="ruc" class=" text-sm font-medium text-gray-700">RUC</label>
                <div class="flex items-center space-x-2">
                    <input v-model="proveedor.ruc" type="text" id="ruc" class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese el RUC">
                    <button @click.prevent="showModal">Agregar</button>            
                </div>
            </div>
            <div class="col-span-2 ">
                <label for="razon-social" class=" text-sm font-medium text-gray-700">Razón Social</label>
                <input v-model="proveedor.razon_social" type="text" id="razon-social" required="true" class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese la Razón Social">
            </div>

            <!-- Segunda fila -->
            <div class="col-span-1">
                <label for="direccion" class="block text-sm font-medium text-gray-700">Direccion</label>
                <input v-model="proveedor.direccion" type="text" id="direccion" required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Direccion">
            </div>
            <div class="col-span-1">
                <label for="tipo_comprobante" class="block text-sm font-medium text-gray-700">Tipo Comprobante</label>  
                <select v-model="proveedor.tipo_comprobante" id="tipo_comprobante" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="options in tiposDocumento" :key="options.id" :value="options.id">
                    {{ options.nombre }}
                    </option>
                </select>     
            </div>
            <div class="col-span-1">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                <input v-model="proveedor.correo" type="email" id="correo" required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Correo">
            </div>

            <!-- Tercera fila -->
            <div class="col-span-1">
                <label for="tipo_sunat" class="block text-sm font-medium text-gray-700">Tipo Sunat</label>
                <select v-model="proveedor.tipo_sunat" id="tipo_sunat" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="options in tiposSunat" :key="options.id" :value="options.id">
                    {{ options.nombre }}
                    </option>
                </select>  
            </div>
            <div class="col-span-1">
                <label for="contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                <input v-model="proveedor.contacto" type="text" id="contacto" required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Contacto">
            </div>
            <div class="col-span-1">
                <label for="proveedor_categoria_id" class="block text-sm font-medium text-gray-700">Proveedor Categoria</label>           
                <select v-model="proveedor.proveedor_categoria_id" @change="CategoryListUpdate" id="proveedor_categoria_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in proveedorcategorias" :key="option.value" :value="option.value">
                    {{ option.label }}
                    </option>
                </select>
            </div>  
            <div class="col-span-1">
                <label for="estado_activo" class="block text-sm font-medium text-gray-700">Estado Activo</label>
                <select v-model="proveedor.estado_activo" id="estado_activo" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in estadoActivo" :key="option.id" :value="option.id">
                    {{ option.nombre }}
                    </option>
                </select>
            </div>                
        </div>
        <PrimaryButton 
            type="button"
            class="mt-2 ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            @click="agregarDetalle"
            >
            Agregar
        </PrimaryButton>

        <Servicio
            :items="proveedor.detalles"
            :ListaServicio_clase="ServicioClases" 
            :ListaServicio_detalle="ServicioDetalles"   
            
        />

        <!-- Botón para agregar el ítem -->  
        <PrimaryButton type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">Registrar</PrimaryButton>
      </form>
    </div>
</template>
  
<script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import Servicio from '../Servicio/CompServicioAdd.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    
    // Definir las props
    const props = defineProps({
        proveedorcategorias: {
            type: Object,
            required: true,
        },
        ListaServicio_clase: {
            type: Object,
            required: true,
        },
        ListaServicio_detalle: {
            type: Object,
            required: true,
        },
    });

    const tiposDocumento = ref([
        { id: '00', nombre: 'OTROS' },
        { id: '01', nombre: 'FACTURA' },
        { id: '02', nombre: 'RECIBO POR HONORARIOS' },
        { id: '03', nombre: 'BOLETA' },
    ]);

    const tiposSunat = ref([
        { id: '2', nombre: 'AGENTE PERCEPCION' },
        { id: '1', nombre: 'AGENTE PERCEPCION' }, 
        { id: '0', nombre: 'AGENTE RETENCION' }
    ]);

    const estadoActivo = ref([
        { id: '1', nombre: 'ACTIVO' }, 
        { id: '0', nombre: 'DESACTIVO' }
    ]);
    
    // Variables reactivas
    const showModal = ref(false);
    const error = ref('');
    const ServicioDetalles = ref([...props.ListaServicio_detalle]);
    const ServicioClases = ref([...props.ListaServicio_clase]);
    
    // Variables para el proveedor y detalle temporal
    const proveedor = ref({
        ruc: '',
        razon_social: '',
        direccion: '',
        tipo_comprobante: '',
        correo: '',
        tipo_sunat: '',
        contacto: '',
        estado_activo: '1',
        proveedor_categoria_id: '',
        
        detalles: [],
    });
    
    const detalleTemporal = ref({
        monto: '',
        moneda: 'DOLARES',
        servicio_clase_id: '',
        ubicacion: '',
        tipo_pax: 'ADULTO',
        servicio_detalle_id: '',
        estado_activo: '1',
    });

    async function CategoryListUpdate() {
        alert("CategoryListUpdate");
        try {     
            const data = {
                proveedor_categoria_id: proveedor.value.proveedor_categoria_id,
            }     
            const response = await axios.post(`${route('serviciodetalle')}/serviceCategory`, data);   
            if (response.status === 200) {
                console.log('Elemento agregado:', response.data);            
                ServicioDetalles.value = response.data;
            }   
            
        } catch (error) {
            console.error('Error al actualizar los datos:', error);
        }        
    };
    
    function updateDetalles(nuevosDetalles) {
        // detalleTemporal.value = nuevosDetalles;
    }
    
    function agregarDetalle() {
        // Agrega el detalle temporal a la lista de detalles
        proveedor.value.detalles.push({ ...detalleTemporal.value });
        // Limpia el detalle temporal
        detalleTemporal.value = {
            monto: '',
            moneda: 'DOLARES',
            servicio_clase_id: '',
            ubicacion: '',
            tipo_pax: 'ADULTO',
            servicio_detalle_id: '',
            estado_activo: '1',
        };
    }
  
    async function submitProveedor() {
        try {
            console.log(proveedor.value);
            const response = await axios.post(route('proveedor_servicio.store'), proveedor.value);

            if (response.status === 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.data.message,
                    confirmButtonText: 'Aceptar',
                }).then(() => {
                    window.location.href = route('proveedor'); // Redirige después de cerrar el modal.
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
            console.error('Error al registrar el proveedor:', err);
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