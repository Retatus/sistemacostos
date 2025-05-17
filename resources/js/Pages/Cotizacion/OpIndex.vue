<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 w-full">
                <div class="col-span-1">
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">Confirmado</PrimaryButton>
                </div>
                <div class="col-span-1">
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">Concluido&nbsp;</PrimaryButton>
                </div>
                <div class="col-span-1">
                    <Datepicker v-model="filterOperaciones.fecha_inicio"/>
                </div>
                <div class="col-span-1">
                    <Datepicker v-model="filterOperaciones.fecha_fin"/>
                </div>
                <div class="col-span-1">
                    <input v-model="filterOperaciones.nombre_nro_pax" type="search" placeholder="Pax ó Nro File"
                        class="mt-1 text-sm border border-gray-300 rounded-md shadow-sm px-4 w-full sm:flex-1">
                </div>
                <div class="col-span-1"> 
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">&nbsp;&nbsp;Buscar&nbsp;&nbsp;&nbsp;</PrimaryButton>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="relative overflow-y-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th hidden scope='col' className='px-6 py-3'>
                                        proveedor_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        fecha
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        file_nro
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        destino
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        estado_cotizacion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        estado_documentacion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        estado_reserva
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        file_nombre
                                    </th> 
                                    <th hidden scope='col' className='px-6 py-3'>
                                        comprobante_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        nro_pasajeros
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cotizacion in cotizacionesTexto" className="bg-white border-b ">
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.proveedor_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.fecha}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.file_nro}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.destino.nombre}}
                                    </td>
                                    <td scope="col">
                                        <div :class="{
                                            'p-2 font-medium rounded-full border-rounded text-gray-900 text-center': true,
                                            'bg-yellow-400': cotizacion.estado_cotizacion == 0,
                                            'bg-green-400': cotizacion.estado_cotizacion == 1,
                                            'bg-red-400': cotizacion.estado_cotizacion == 2
                                            }">
                                            {{cotizacion.estado_cotizacion_text}}
                                        </div>
                                    </td>
                                    <td scope="col" class="px-6 py-4 font-medium text-gray-900">
                                        <div
                                        :class="{
                                                'p-2 font-medium rounded-full border-rounded text-gray-900 text-center': true,
                                                'bg-green-400 text-gray-900': cotizacion.estado_documentacion == 1,
                                                'bg-red-400 text-gray-900': cotizacion.estado_documentacion == 0
                                            }">
                                            {{ cotizacion.estado_documentacion_text }}
                                        </div>
                                    </td>
                                    <td scope="col">
                                        <div :class="{
                                            'p-2 font-medium rounded-full border-rounded text-gray-900 text-center': true,
                                            'bg-green-400 text-gray-900': cotizacion.estado_reserva == 1,
                                            'bg-yellow-400 text-gray-900': cotizacion.estado_reserva == 0
                                            }">
                                            {{ cotizacion.estado_reserva_text }}
                                        </div>
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.file_nombre}}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.nro_pasajeros}}
                                    </td>
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.estado_activo}}
                                    </td>
                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('cotizacion.show', cotizacion)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                    <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                                </svg>
                                            </Link>
                                            <Link :href="route('cotizacion.edit', cotizacion)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </Link>
                                            <button @click="onDeleteConfirm(cotizacion)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>                                                                               
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Componente de paginación -->
                        <Pagination :paginate="Paginate" :paginatedDataKey="'cotizacions'" @update:data="cotizacions = $event" />
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
    import { ref , computed} from 'vue';
    import { router } from '@inertiajs/vue3';
    import Datepicker from '@/Components/Datepicker.vue'; 

    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import Pagination from '@/Components/Pagination.vue';

    const page = usePage();
    const Paginate = ref(page.props.cotizacions);
    const cotizacions = ref(page.props.cotizacions.data);
    const fechaActual = ref(new Date().toISOString().slice(0, 10));

    const filterOperaciones = ref({
        fecha_inicio: '',
        fecha_fin: '',
        nombre_nro_pax: ''
    });

    const estadoCotizacion = ref([
        { id: '0', nombre: 'PENDIENTE' }, 
        { id: '1', nombre: 'CONFIRMADA' },
        { id: '2', nombre: 'ANULADA' },
    ]);

    const estadoDocumento = ref([
        { id: '0', nombre: 'OBS' },
        { id: '1', nombre: 'OK' }, 
    ]);

    const estadoReserva = ref([
        { id: '0', nombre: 'WL' },
        { id: '1', nombre: 'OK' }, 
    ]);

    const handleSearch = async () => {
        try {
            // Petición POST usando axios
            //const response = await axios.post(route('cotizacion.indexProveedor'), parameters);
            const response = await axios.get(route('cotizacion.opindex'), {params: filterOperaciones.value});

            // Manejo de la respuesta
            if (response.status === 200) {
                debugger;
                cotizacions.value = response.data.cotizacions.data;  
                Paginate.value = response.data.cotizacions;
            }
        } catch (error) {
            console.error('Error en la búsqueda:', error);
            alert('Ocurrió un error al realizar la búsqueda. Por favor, intenta nuevamente.');
        }
    };

    const cotizacionesTexto = computed(() => {
        return cotizacions.value.map((doc) => {
            const estadocotizacion = estadoCotizacion.value.find((estadocotizacion) => estadocotizacion.id == doc.estado_cotizacion);
            const estadodocumento = estadoDocumento.value.find((estadodocumento) => estadodocumento.id == doc.estado_documentacion);
            const estadoreserva = estadoReserva.value.find((estadoreserva) => estadoreserva.id == doc.estado_reserva);
            return {
            ...doc,
            estado_cotizacion_text: estadocotizacion ? estadocotizacion.nombre : 'Desconocido',
            estado_documentacion_text: estadodocumento ? estadodocumento.nombre : 'Desconocido',
            estado_reserva_text: estadoreserva ? estadoreserva.nombre : 'Desconocido',
            };
        });
    });
    
    const onDeleteConfirm = (Cotizacion) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${Cotizacion.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('cotizacion.destroy', Cotizacion), {
                onSuccess: (page) => {
                cotizacions.value = page.props.cotizacions;
                Swal.fire('Eliminado', 'El elemento ha sido eliminado con éxito.', 'success');
                },
            });
            }
        });
    };
</script>