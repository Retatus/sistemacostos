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
                <input v-model="proveedor.razon_social" type="text" id="razon-social" class="mt-1   w-full border-gray-300 rounded-md shadow-sm" placeholder="Ingrese la Razón Social">
            </div>

            <!-- Segunda fila -->
            <div class="col-span-1">
                <label for="direccion" class="block text-sm font-medium text-gray-700">Direccion</label>
                <input v-model="proveedor.direccion" type="text" id="direccion" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Direccion">
            </div>
            <div class="col-span-1">
                <label for="tipo_comprobante" class="block text-sm font-medium text-gray-700">Tipo Comprobante</label>  
                <select v-model="proveedor.tipo_comprobante" id="tipo_comprobante" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="options in tiposDocumento" :key="options.id" :value="options.nombre">
                    {{ options.nombre }}
                    </option>
                </select>     
            </div>
            <div class="col-span-1">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                <input v-model="proveedor.correo" type="email" id="correo" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Correo">
            </div>

            <!-- Tercera fila -->
            <div class="col-span-1">
                <label for="tipo_sunat" class="block text-sm font-medium text-gray-700">Tipo Sunat</label>
                <select v-model="proveedor.tipo_sunat" id="tipo_sunat" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="options in tipoSunat" :key="options.id" :value="options.nombre">
                    {{ options.nombre }}
                    </option>
                </select>  
            </div>
            <div class="col-span-1">
                <label for="contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                <input v-model="proveedor.contacto" type="text" id="contacto" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Contacto">
            </div>
            <div class="col-span-1">
                <label for="proveedor_categoria_id" class="block text-sm font-medium text-gray-700">Proveedor Categoria</label>           
                <select v-model="proveedor.proveedor_categoria_id" id="proveedor_categoria_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in proveedorcategorias" :key="option.value" :value="option.value">
                    {{ option.label }}
                    </option>
                </select>
            </div>

            <!-- Cuarta fila -->
            <div class="col-span-1">
                <label for="servicio_detalle" class="block text-sm font-medium text-gray-700">Servicio clase</label>
                <div class="flex items-center space-x-2">
                    <select v-model="proveedor.servicio_detalle" id="servicio_detalle" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in ServiciosDetalles" :key="option.value" :value="option.value">
                    {{ option.label }}
                    </option>
                </select>
                    <button @click.prevent="showModal = true">Agregar</button>
                </div>
            </div>
            <div class="col-span-1">
                <label for="costo" class="block text-sm font-medium text-gray-700">Costo</label>
                <select v-model="proveedor.costo" id="costo" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in categoriaCostos" :key="option.value" :value="option.value">
                    {{ option.label }}
                    </option>
                </select>
            </div>
            <div class="col-span-1">
                <label for="destino" class="block text-sm font-medium text-gray-700">Destino</label>
                <select v-model="proveedor.destino" id="destino" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in categoriaDestinos" :key="option.value" :value="option.value">
                    {{ option.label }}
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
            :ListaServicio_detalle="ListaServicio_detalle"   
            @update="updateDetalles"
        />

        <!-- Botón para agregar el ítem -->  
        <PrimaryButton type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">Registrar</PrimaryButton>
      </form>
    </div>
    <ServiceDetalleModal
        :isModalVisible="showModal"
        title="Agregar Servicio"
        inputLabel="Descripcion"
        inputPlaceholder="Ingrese un nombre"
        submitButtonText="Guardar"
        :errorMessage="error"
        :defaultData="{ nombre: '' }"
        @close="showModal = false"
        @submit="addServiceClass"
    />
</template>
  
<script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    import Servicio from '../Servicio/CompServicioAdd.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import ServiceDetalleModal from '@/Components/Modal/FormModal.vue';
    
    // Definir las props
    const props = defineProps({
        proveedorcategorias: {
            type: Object,
            required: true,
        },
        categoriaCostos: {
            type: Object,
            required: true,
        },
        categoriaDestinos: {
            type: Object,
            required: true,
        },
        categoriaDistribuciones: {
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

    const tipoSunat = ref([
        { id: '2', nombre: 'AGENTE PERCEPCION' },
        { id: '1', nombre: 'AGENTE PERCEPCION' }, 
        { id: '0', nombre: 'AGENTE RETENCION' }
    ]);
    
    // Variables reactivas
    const showModal = ref(false);
    const error = ref('');
    const ServiciosDetalles = ref([...props.ListaServicio_detalle]);
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
        proveedor_categoria_id: '',
        servicio_detalle: '',
        costo: '',
        destino: '',
        detalles: [],
    });
    
    const detalleTemporal = ref({
        monto: '',
        moneda: 'dolares',
        servicio_clase_id: '',
        ubicacion: '',
        tipo_pax: 'adulto',
        servicio_detalle_id: '',
    });
    
    // Métodos
    async function addServiceClass(data) {
        try {
            const response = await axios.post(`${route('serviciodetalle')}/storemodal`, data);
            console.log('Elemento agregado:', response.data);
            if (response.status === 200) {
                ServiciosDetalles.value = response.data;
                showModal.value = false;
            } else {
                alert('Error al agregar el elemento:', response.data);
            }
        } catch (err) {
            console.log('Error al agregar elemento:', err);
            error.value = err.response?.data?.message || 'Ocurrió un error';
        }
    }
    
    function updateDetalles(nuevosDetalles) {
        detalleTemporal.value = nuevosDetalles;
    }
    
    function agregarDetalle() {
        // Agrega el detalle temporal a la lista de detalles
        proveedor.value.detalles.push({ ...detalleTemporal.value });
        // Limpia el detalle temporal
        detalleTemporal.value = {
            monto: '',
            moneda: 'dolares',
            servicio_clase_id: '',
            ubicacion: '',
            tipo_pax: 'adulto',
            servicio_detalle_id: '',
        };
    }
  
    async function submitProveedor() {
        try {
            console.log(proveedor.value);
            const response = await axios.post(route('proveedor_servicio.store'), proveedor.value);
            alert(response.data.message);
        } catch (error) {
            console.error('Error al registrar el proveedor:', error);
        }
    }  
</script>
  
  