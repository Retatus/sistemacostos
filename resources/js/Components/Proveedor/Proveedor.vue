<template>
    <div class="container mx-auto">
      <!-- <h1 class="text-2xl font-bold mb-4">Registrar Factura</h1> h-8 text-sm px-2 py-1 block -->
      <form @submit.prevent="submitFactura">
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
                <input v-model="proveedor.tipo_comprobante" type="text" id="tipo_comprobante" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Tipo Documento">
            </div>
            <div class="col-span-1">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                <input v-model="proveedor.correo" type="email" id="correo" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Correo">
            </div>

            <!-- Tercera fila -->
            <div class="col-span-1">
                <label for="tipo_sunat" class="block text-sm font-medium text-gray-700">Tipo Sunat</label>
                <input v-model="proveedor.tipo_sunat" type="text" id="tipo_sunat" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Tipo Sunat">
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
                <label for="servicio_clase" class="block text-sm font-medium text-gray-700">Servicio clase</label>
                <div class="flex items-center space-x-2">
                    <select v-model="proveedor.servicio_clase" id="servicio_clase" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in ServicioClases" :key="option.value" :value="option.value">
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
  
        <div class="mt-4">
          <!-- <p><strong>Subtotal:</strong> {{ calcularSubtotal() }}</p>
          <p><strong>Impuesto (18%):</strong> {{ calcularImpuesto() }}</p>
          <p><strong>Total:</strong> {{ calcularTotal() }}</p> -->
        </div>

        <!-- Botón para agregar el ítem -->
        
  
        <PrimaryButton type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">Registrar</PrimaryButton>
      </form>
    </div>
    <ServiceClassModal
        :isModalVisible="showModal"
        title="Agregar Servicio Clase"
        inputLabel="Nombre"
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

    import ServiceClassModal from '@/Components/Modal/FormModal.vue';
    const props = defineProps({
        proveedorcategorias: {
            type: Object, 
            required: true
        },
        categoriaCostos: {
            type: Object, 
            required: true
        },
        categoriaDestinos: {
            type: Object, 
            required: true
        } ,
        categoriaDistribuciones: {
            type: Object, 
            required: true
        } ,
        ListaServicio_clase: {
          type: Object, 
          required: true
        } ,
        ListaServicio_detalle: {
            type: Object, 
            required: true
        } 
    })

    const showModal = ref(false);
    const error = ref('');
    const ServicioClases = ref([...props.ListaServicio_clase]);

    async function addServiceClass(data) {
        try {
            const response = await axios.post(`${route('proveedor_servicio')}/storemodal`, data);    
            console.log('Elemento agregado:', response.data);            
            if (response.status === 200) {   
                ServicioClases.value = response.data;    
                showModal.value = false;
            }else{
                alert('Error al agregar el elemento:', response.data);
            }

        } catch (err) {
            console.log('Elemento agregado:', err);  
            error.value = err.response?.data?.message || 'Ocurrió un error';
        }
    }

</script>

  <script>
  import Servicio from './Servicio.vue';
  import axios from 'axios';
import PrimaryButton from '../PrimaryButton.vue';
  
  export default {
    components: { Servicio },
    data() {
      return {
        proveedor: {
            ruc: '',
            razon_social: '',
            direccion: '',
            tipo_comprobante: '',
            correo: '',
            tipo_sunat: '',
            contacto: '',
            proveedor_categoria_id: '',
            servicio_clase: '',
            costo: '',
            destino: '',

            // cliente: '',
            // fecha: '',
            detalles: [],
        },
        detalleTemporal: {
            monto: '',
            moneda: 'dolares',
            servicio_clase_id: '',
            ubicacion: '',
            tipo_pax: 'adulto',
            servicio_detalle_id: '',
        },
      };
    },



    methods: {
      updateDetalles(nuevosDetalles) {
        this.detalleTemporal = nuevosDetalles;
      },

      agregarDetalle() {
        // Agrega el detalle temporal a la lista de detalles
        this.proveedor.detalles.push({ ...this.detalleTemporal });
        // Limpia el detalle temporal
        this.detalleTemporal = { 
            monto: '',
            moneda: 'dolares',
            servicio_clase_id: '',
            ubicacion: '',
            tipo_pax: 'adulto',
            servicio_detalle_id: '',

            // producto: '',
            // cantidad: 1, 
            // precio: 0 
        };
    },
      // calcularSubtotal() {
      //   return this.proveedor.detalles.reduce((acc, item) => acc + item.cantidad * item.precio, 0);
      // },
      // calcularImpuesto() {
      //   return this.calcularSubtotal() * 0.18;
      // },
      // calcularTotal() {
      //   return this.calcularSubtotal() + this.calcularImpuesto();
      // },
      async submitFactura() {
        try {
          //const response = await axios.post('/facturas', this.proveedor);
          console.log(this.proveedor)
          debugger
          const response = await axios.post(route('proveedor_servicio.store'), this.proveedor);
          alert(response.data.message);
          debugger
          //this.proveedor = {cliente: '', fecha: '', detalles: [] }; // Reset formulario
        } catch (error) {
          console.error('Error al registrar la proveedor:', error);
        }
      },
    },
  };
  </script>
  