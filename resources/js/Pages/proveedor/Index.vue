<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref, computed } from 'vue';
    import { router } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    
    const Page = usePage();
    const Paginate = ref(Page.props.proveedors);
    const Proveedors = ref(Page.props.proveedors.data);
    const ProveedorCategorias = ref(Page.props.proveedorcategorias);

    // Campos del formulario (reactivos)
    const proveedor_categoria = ref('');
    const ruc_razonsocial = ref('');

    console.log(ProveedorCategorias);

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

    const documentosConTipoTexto = computed(() => {
        return Proveedors.value.map((doc) => {
            const tipoComprobante = tiposDocumento.value.find((tipoComprobante) => tipoComprobante.id == doc.proveedor_categoria);
            const tipoSunat = tiposSunat.value.find((tipoSunat) => tipoSunat.id == doc.tipo_sunat);
            return {
            ...doc,
            tipo_documento_nombre: tipoComprobante ? tipoComprobante.nombre : 'Desconocido',
            tipo_sunat_nombre: tipoSunat ? tipoSunat.nombre : 'Desconocido',
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
                    <div class="col-span-1 bg-gray-100 flex justify-center items-center px-4">
                        <h2 class="text-xl mr-2 font-semibold leading-tight text-gray-800">
                            proveedor
                        </h2>
                        <Link :href="route('proveedor.create')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 btn btn-primary px-4 mr-2">
                            Nuevo
                        </Link>
                    </div>
                    <div class="col-span-1 bg-gray-100 flex justify-between items-center px-4">
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
                            <!-- <PrimaryButton class="btn btn-primary px-4 flex-1">Buscar</PrimaryButton> -->
                        </div>
                    </div>
                    <div class="col-span-1 bg-gray-100 flex justify-center items-right px-4"> 
                        <PrimaryButton class="btn btn-primary px-4 mr-2" @click="handleSearch">Buscar</PrimaryButton>
                        <SecondaryButton class="mr-2">Cancelar</SecondaryButton>
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
                                        estado_activo
                                    </th>
                                    <th scope='col' className='px-6 py-3'>
                                        proveedor_categoria
                                    </th>

                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="proveedor in documentosConTipoTexto" className="bg-white border-b ">
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.ruc }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.razon_social }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.direccion }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.tipo_documento_nombre }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.correo }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.tipo_sunat_nombre }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.contacto }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.estado_activo }}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{ proveedor.categoria.nombre }}
                                    </td>

                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('proveedor.edit', proveedor)">
                                            Editar
                                            </Link>
                                            <button @click="onDeleteConfirm(proveedor)">Eliminar</button>
                                        </div>
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
