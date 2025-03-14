<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref, computed } from 'vue';
    import { router } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
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

    async function changePage(page) {
        debugger
        if(page > 0 && page <= Paginate.value.last_page){
            // Incluye los filtros actuales en la solicitud            
            const filters = {
                page: page
            };

            // Agregar categoría solo si tiene un valor válido
            if (proveedor_categoria.value) {
                filters.categoria = proveedor_categoria.value;
            }

            // Agregar búsqueda solo si tiene un valor válido
            if (ruc_razonsocial.value) {
                filters.ruc_razonsocial = ruc_razonsocial.value;
            }

            // Envía la solicitud con los filtros y la página
            router.get(window.location.pathname, filters, {
                preserveScroll: true, // Mantiene la posición del scroll
                preserveState: true,  // Mantiene los datos actuales en la vista
                onSuccess: (page) => {
                    Paginate.value = page.props.proveedors; // Asegúrate de que los datos reactivos se actualicen
                    Proveedors.value = page.props.proveedors.data; // Asegúrate de que los datos reactivos se actualicen
                }
            });
        }
    }   

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

<template>
    <AppLayout title="Dashboard">
        <template #header>
                <div class="grid grid-cols-3 gap-4 w-full">
                    <div class="col-span-1 flex justify-center items-center px-4">
                        <h2 class="text-xl mr-2 font-semibold leading-tight text-gray-800">
                            proveedor
                        </h2>
                        <Link :href="route('proveedor.create')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 btn btn-primary px-4 mr-2">
                            Nuevo
                        </Link>
                    </div>
                    <div class="col-span-1 flex justify-between items-center px-4">
                        <div class="flex w-full items-center gap-4">
                            <select v-model="proveedor_categoria"
                                class="text-xs border border-gray-300 rounded-md shadow-sm px-4 flex-1">
                                <option value="">-- Selecciona una opción --</option>
                                <option v-for="option in ProveedorCategorias" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                            <input v-model="ruc_razonsocial" type="text" placeholder="Buscar"
                                class="text-xs border border-gray-300 rounded-md shadow-sm px-4 flex-1">
                        </div>
                    </div>
                    <div class="col-span-1 flex justify-center items-right px-4"> 
                        <PrimaryButton class="btn btn-primary px-4 mr-2" @click="handleSearch">Buscar</PrimaryButton>
                        <SecondaryButton @click="handleCancel" class="mr-2">Cancelar</SecondaryButton>
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
                        <div class="flex justify-between items-center gap-4 mt-5 mb-5">
                            <span>Total de proveedores: {{ Paginate.total }}</span>

                            <div v-if="Paginate.last_page > 1" class="flex items-center gap-4">
                                <SecondaryButton @click="changePage(Paginate.current_page - 1)"
                                    :disabled="Paginate.current_page === 1">
                                    Anterior
                                </SecondaryButton>
                                <span>Página {{ Paginate.current_page }} de {{ Paginate.last_page }}</span>
                                <SecondaryButton @click="changePage(Paginate.current_page + 1)"
                                    :disabled="Paginate.current_page === Paginate.last_page">
                                    Siguiente
                                </SecondaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
