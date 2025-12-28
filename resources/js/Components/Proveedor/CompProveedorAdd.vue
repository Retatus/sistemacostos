<template>
    <div class="container mx-auto">
      <form @submit.prevent="submitProveedor" class="py-5 space-y-3">
        <div class="grid grid-cols-3 gap-4 w-full px-5">
            <!-- Primera fila -->
            <div class="col-span-1 ">
                <label for="ruc" class=" text-sm font-medium text-gray-700">RUC</label>
                <div class="flex items-center space-x-2">
                    <input v-model="proveedor.ruc" type="text" id="ruc" class="mt-1 w-full border-gray-300 rounded-md shadow-sm disabled:bg-gray-100 disabled:text-gray-500" :disabled="esEdicion" placeholder="Ingrese el RUC">
                    <button @click.prevent="showModal = true">Agregar</button>            
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
                <select v-model="proveedor.tipo_comprobante" id="tipo_comprobante" 
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in sListaTipoComprobantes" :key="option.value" :value="option.value">
                        {{ option.label }}
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
                    <option v-for="option in sListaTipoSunats" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>  
            </div>
            <div class="col-span-1">
                <label for="proveedor_categoria_id" class="block text-sm font-medium text-gray-700">Proveedor Categoria</label>         
                <select v-model="proveedor.proveedor_categoria_id" @change="CategoryListUpdate" id="proveedor_categoria_id" 
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled value="">-- Selecciona una opción --</option>
                    <option v-for="option in sListaProveedorCategorias" :key="option.value" :value="option.value">
                    {{ option.label }}
                    </option>
                </select>
            </div>

            <div class="col-span-1 flex items-center space-x-2">
                <div class="w-full">
                    <label for="contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                    <input v-model="proveedor.contacto" type="text" id="contacto" required="true" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" placeholder="Contacto">
                </div>            
                <div :class="['w-full', { hidden: !esEdicion }]">
                    <label for="estado_activo" class="block text-sm font-medium text-gray-700">Estado Activo</label>
                    <select v-model="proveedor.estado_activo" id="estado_activo" 
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        <option disabled value="">-- Selecciona una opción --</option>
                        <option v-for="option in estadoActivo" :key="option.id" :value="option.id">
                        {{ option.nombre }}
                        </option>
                    </select>
                </div>
            </div>
            <div class=" col-span-3 bg-black  text-slate-300 p-2 rounded mb-2 flex justify-between items-center">
                <h3>Agregar Servicio</h3>
                <span @click="agregarDetalle(index)" class="text-sm justify-end cursor-pointer">
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>                    
                    </i> 
                </span>
            </div>              
        </div>
        <Servicio
            :Servicio="proveedor.servicios"
            :ListaServicioDetalle="ListaServicioDetalle"
        />
        <div class="flex justify-end">
            <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
            <PrimaryButton type="submit" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded">{{Accion}}</PrimaryButton>
        </div>        
      </form>
    </div>
</template>
  
<script setup>
    import { ref, toRaw, computed } from 'vue';
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import Servicio from '../Servicio/CompServicioAdd.vue';
    import PrimaryButton from '../PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import { useCategoriesStore } from '@/Stores/categories';
    const categoriesStore = useCategoriesStore();

    // Definir las props
    const props = defineProps({
        Accion: {
            type: String,
            required: true,
        },
        Proveedor: {
            type: Object, 
            default: () => ({})
        },
        ListaServicioDetalle: {
            type: Object,
            required: true,
        }
    });    
    
    // Variables reactivas
    const showModal = ref(false);
    const error = ref('');
    const ListaServicioDetalle = ref([...props.ListaServicioDetalle]);
    const sListaProveedorCategorias = ref({ ...categoriesStore.globals.proveedor_categories });
    const sListaTipoComprobantes = ref({ ...categoriesStore.globals.tipo_comprobantes });
    const sListaTipoSunats = ref({ ...categoriesStore.globals.tipo_sunat });

    const esEdicion = computed(() => props.Accion === 'edit');
    
    const estadoActivo = ref([
        { id: '1', nombre: 'ACTIVO' }, 
        { id: '0', nombre: 'INACTIVO' }
    ]);
   
    const proveedor = ref({});    
   
    // Variables para el proveedor y detalle temporal
    //proveedor.value = props.Proveedor;
    if (esEdicion.value) {        
        proveedor.value = { ...props.Proveedor };
    } else {
        proveedor.value = {
            ruc: '',
            razon_social: '',
            direccion: '',
            tipo_comprobante: 2,//factura
            correo: '',
            tipo_sunat: '',
            contacto: '',
            escliente: 0,
            editado: 0,
            estado_activo: 1,
            tipo_documento_id: 1,
            proveedor_categoria_id: '',
            
            servicios: [],
        };
    }

    const precio = ref({
        id: '',
        servicio_id: '',
        servicio_clase_id: 2, //DEFAULT TURISTA
        tipo_pasajero_id: 3, //DEFAULT ADULTO
        anio: new Date().getFullYear().toString(),
        tipo_costo: 'UNITARIO',
        pax_min: 1,
        pax_max: 90,
        capacidad_pax: 1,        
        moneda: 'USD',
        monto: 0.00,
        estado_activo: 1
    });

    const servicios = ref({
        id: '',
        proveedor_id: '',
        servicio_detalle_id: '',
        ubicacion_id: '',
        estado_activo: 1,
        precios: [precio.value],
    });
    
    async function CategoryListUpdate() {
        try {     
            const data = {
                proveedor_categoria_id: proveedor.value.proveedor_categoria_id,
            }     
            const response = await axios.post(`${route('serviciodetalle')}/serviceCategory`, data);   
            if (response.status === 200) {
                console.log('Elemento agregado:', response.data);            
                ListaServicioDetalle.value = response.data;
            }   
            
        } catch (error) {
            console.error('Error al actualizar los datos:', error);
        }        
    };
    
    // function updateDetalles(nuevosDetalles) {
    //     console.log("QUE FUE     ", nuevosDetalles);
    //     //detalleTemporal.value = nuevosDetalles;
    // }
    
    function agregarDetalle() {
        // Agregar copia plana del servicio
        proveedor.value.servicios.push({ 
            ...toRaw(servicios.value), 
            precios: [ { ...toRaw(precio.value) } ] 
        });

        // Reiniciar precio y servicio
        precio.value = {
            id: '',
            servicio_id: '',
            servicio_clase_id: 2,
            tipo_pasajero_id: 3,
            anio: new Date().getFullYear().toString(),
            tipo_costo: 'UNITARIO',
            pax_min: 1,
            pax_max: 90,
            capacidad_pax: 1,
            monto: 0.00,
            moneda: 'USD',
            estado_activo: 1
        };

        servicios.value = {
            id: '',
            proveedor_id: '',
            servicio_detalle_id: '',
            ubicacion_id: '',
            estado_activo: 1,
            precios: [ precio.value ]
        };
    }

  
    async function submitProveedor() {
        try {
            let response;
            if (!esEdicion.value) {
                proveedor.value.editado = 0;
                response = await axios.post(route('proveedor_servicio.store'), proveedor.value);
            }else {
                proveedor.value.editado = 1;
                response = await axios.patch(route('proveedor_servicio.update', { proveedor_servicio: proveedor.value.id }), proveedor.value);
            }

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
                    text: `Error al ${props.Accion} el elemento. ${response.data.message}`,
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