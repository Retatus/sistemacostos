<template>
    <AppLayout title="Dashboard">
        <template #header>
            <!-- Header compacto tipo navbar -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between h-auto sm:h-16 px-3 sm:px-4 py-3 sm:py-0 bg-white border-b border-gray-200 gap-3 sm:gap-0">
                
                <!-- Izquierda: Título con icono -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-semibold text-gray-900">Proveedores</h2>
                        <p class="text-xs text-gray-500 hidden md:block">Gestión de proveedores</p>
                    </div>
                </div>

                <!-- Centro: Filtros compactos en línea -->
                <div class="w-full sm:w-auto sm:flex-1 max-w-2xl">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                        <!-- Select compacto -->
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <select 
                                v-model="proveedor_categoria"
                                class="w-full pl-9 pr-4 py-2 text-xs border border-gray-300 rounded-lg bg-white hover:border-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition-colors appearance-none cursor-pointer"
                            >
                                <option value="" class="text-gray-400">Todas las categorías</option>
                                <option 
                                v-for="option in ProveedorCategorias" 
                                :key="option.value" 
                                :value="option.value"
                                class="text-gray-700"
                                >
                                {{ option.label }}
                                </option>
                            </select>
                        </div>

                        <!-- Input búsqueda compacto -->
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input 
                                v-model="ruc_razonsocial" 
                                type="search" 
                                placeholder="RUC o Razón Social..."
                                class="w-full pl-9 pr-4 py-2 text-xs border border-gray-300 rounded-lg bg-white hover:border-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition-colors placeholder:text-gray-400"
                                @keyup.enter="handleSearch"
                            >
                        </div>

                        <!-- Botones compactos -->
                        <div class="flex items-center space-x-2">
                            <button 
                                @click="handleCancel"
                                class="flex items-center justify-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors"
                            >
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="hidden sm:inline">Limpiar</span>
                            </button>
                            
                            <button 
                                @click="handleSearch"
                                class="flex items-center justify-center px-3 py-2 text-xs font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-600 rounded-lg hover:from-blue-700 hover:to-blue-800 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all shadow-sm"
                            >
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline">Buscar</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Derecha: Botón Agregar -->
                <div class="w-full sm:w-auto">
                    <Link 
                        :href="route('proveedor.create')" 
                        class="flex items-center justify-center w-full sm:w-auto px-4 py-2 text-xs sm:text-sm font-medium text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-offset-1 transition-all shadow-sm"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="hidden md:inline">Agregar Proveedor</span>
                        <span class="md:hidden">Agregar</span>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="relative overflow-y-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope='col' className='px-6 py-3'>
                                        ruc
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        razon_social
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        direccion
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        tipo_comprobante
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        correo
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        tipo_sunat
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        contacto
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        cliente
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        estado_activo
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        proveedor_categoria
                                    </th>
                                    <th colspan="2" scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="proveedor in documentosConTipoTexto" className="bg-white border-b text-gray-900">
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.ruc }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.razon_social }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.direccion }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.tipo_documento_nombre }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.correo }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.tipo_sunat_nombre }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.contacto }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.es_cliente }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.estado_activo }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium'>
                                        {{ proveedor.categoria.nombre }}
                                    </td>                                    
                                    <td class="px-4 py-2 text-sm hover:text-blue-700">
                                        <Link :href="route('proveedor.edit', proveedor)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </Link>
                                    </td>
                                    <td class=" px-4 py-2 text-sm hover:text-red-700">
                                        <button @click="onDeleteConfirm(proveedor)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                       <!-- Componente de paginación -->
                       <Pagination :paginate="Paginate" :paginatedDataKey="'proveedors'" @update:data="Proveedors = $event" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref, computed } from 'vue';
    import { router } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import Pagination from '@/Components/Pagination.vue';
    import { useCategoriesStore } from '@/Stores/categories';
    const categoriesStore = useCategoriesStore();
    
    const Page = usePage();
    const Paginate = ref(Page.props.proveedors);
    const Proveedors = ref(Page.props.proveedors.data);
    const ProveedorCategorias = ref(Page.props.proveedorcategorias);

    // Campos del formulario (reactivos)
    const proveedor_categoria = ref('');
    const ruc_razonsocial = ref('');

    console.log(ProveedorCategorias);

    const tiposDocumento = ref([...categoriesStore.globals.tipo_comprobantes]);
    const tiposSunat = ref([...categoriesStore.globals.tipo_sunat]);

    const esCliente = ref([
        { id: '1', nombre: 'CLIENTE' }, 
        { id: '0', nombre: 'PROVEEDOR' }
    ]);

    const estadoActivo = ref([
        { id: '1', nombre: 'ACTIVO' }, 
        { id: '0', nombre: 'DESACTIVO' }
    ]);

    const documentosConTipoTexto = computed(() => {
        return Proveedors.value.map((doc) => {
            const tipoComprobante = tiposDocumento.value.find((tipoComprobante) => tipoComprobante.value == doc.tipo_comprobante);
            const tipoSunat = tiposSunat.value.find((tipoSunat) => tipoSunat.value == doc.tipo_sunat);
            const escliente = esCliente.value.find((escliente) => escliente.id == doc.escliente);
            const estadoactivo = estadoActivo.value.find((estadoactivo) => estadoactivo.id == doc.estado_activo);
            return {
            ...doc,
            tipo_documento_nombre: tipoComprobante ? tipoComprobante.label : 'Desconocido',
            tipo_sunat_nombre: tipoSunat ? tipoSunat.label : 'Desconocido',
            es_cliente: escliente ? escliente.nombre : 'Desconocido',
            estado_activo: estadoactivo ? estadoactivo.nombre : 'Desconocido',
            };
        });
    });

    const handleSearch = async () => {
        try {
            // Datos a enviar en la petición
            const parameters = {
                proveedor_categoria: proveedor_categoria.value,
                ruc_razonsocial: ruc_razonsocial.value,
            };

            // Petición POST usando axios
            //const response = await axios.post(route('proveedor.indexProveedor'), parameters);
            const response = await axios.get(route('proveedor'), {params: parameters});

            // Manejo de la respuesta
            if (response.status === 200) {
                Proveedors.value = response.data.proveedors.data;  
                Paginate.value = response.data.proveedors;
            }
        } catch (error) {
            console.error('Error en la búsqueda:', error);
            alert('Ocurrió un error al realizar la búsqueda. Por favor, intenta nuevamente.');
        }
    };

    const handleCancel = () => {
        window.location.href = route('proveedor');
    };

    const onDeleteConfirm = (proveedor) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${proveedor.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('proveedor.destroy', proveedor), {
                onSuccess: (page) => {
                    Proveedors.value = page.props.proveedors;
                    Swal.fire('Eliminado', 'El elemento ha sido eliminado con éxito.', 'success');
                },
            });
            }
        });
    };

</script>
