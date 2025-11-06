<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="grid grid-cols-1 md:grid-cols-8 gap-4 w-full">
                <!-- <div class="col-span-1">
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">Cotizacion</PrimaryButton>
                </div> -->
                <div class="col-span-1">
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">Confirmado</PrimaryButton>
                </div>
                <div class="col-span-1">
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">Pendientes&nbsp;</PrimaryButton>
                </div>
                <div class="col-span-1">
                    <PrimaryButton class="btn btn-primary mt-1 px-5 py-2.5 text-sm font-medium sm:min-w-[120px] w-full sm:w-auto text-center" @click="handleSearch">Cancelados&nbsp;</PrimaryButton>
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
                <div class="col-span-1"> 
                    <Link :href="route('cotizacion.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                        Agregar Cotizacion
                    </Link>
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
                                        file_nombre
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
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.file_nombre}}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.nro_pasajeros}}
                                    </td>
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{cotizacion.estado_activo}}
                                    </td>
                                    <td scope="col" className="px-6 py-4 font-medium text-gray-700">
                                        <div class="flex space-x-2">
                                            <Link :href="route('cotizacion.edit', cotizacion)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                </svg>
                                            </Link>
                                            <Link :href="route('cotizacion.edit', cotizacion)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>

                                            </Link>
                                            <button type ="button" @click="">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                                                </svg>
                                            </button>
                                            <button @click="onDeleteConfirm(cotizacion)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
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
    import Datepicker from '@/Components/Datepicker.vue'; 
    import { router } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import Pagination from '@/Components/Pagination.vue';

    const page = usePage();
    const Paginate = ref(page.props.cotizacions);
    const cotizacions = ref(page.props.cotizacions.data);

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
