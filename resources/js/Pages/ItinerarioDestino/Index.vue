<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  ItinerarioDestino
              </h2>   
              <Link :href="route('itinerario_destino.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar ItinerarioDestino
              </Link>                    
          </div>    
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="relative overflow-y-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope='col' className='px-6 py-3'>
                                        nro_dia
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        itinerario_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        destino_turistico_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        nombre
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        descripcion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        observacion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        estado_activo
                                    </th> 

                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="itinerariodestino in ItinerarioDestinos" className="bg-white border-b ">
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.nro_dia}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.itinerario_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.destino_turistico_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.descripcion}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.observacion}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{itinerariodestino.estado_activo}}
                                    </td> 

                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('itinerario_destino.edit', itinerariodestino)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </Link>
                                            <button @click="onDeleteConfirm(itinerariodestino)">
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
                        <Pagination :paginate="Paginate" :paginatedDataKey="'itinerariodestinos'" @update:data="ItinerarioDestinos = $event" />
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
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';

    const page = usePage();
    const Paginate = ref(page.props.itinerariodestinos);
    const ItinerarioDestinos = ref(page.props.itinerariodestinos.data);
    
    const onDeleteConfirm = (ItinerarioDestino) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${ItinerarioDestino.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('itinerario_destino.destroy', ItinerarioDestino), {
                onSuccess: (page) => {
                ItinerarioDestinos.value = page.props.itinerariodestinos;
                Swal.fire('Eliminado', 'El elemento ha sido eliminado con éxito.', 'success');
                },
            });
            }
        });
    };
</script>
