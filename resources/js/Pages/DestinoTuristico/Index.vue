<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';

    const page = usePage();
    const DestinoTuristicos = ref(page.props.destinoturisticos);
    
    const onDeleteConfirm = (DestinoTuristico) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${DestinoTuristico.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('destino_turistico.destroy', DestinoTuristico), {
                onSuccess: (page) => {
                DestinoTuristicos.value = page.props.destinoturisticos;
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
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight dark:text-gray-200">
                  DestinoTuristico
              </h2>   
              <Link :href="route('destino_turistico.create')" class="btn btn-primary dark:text-gray-200"> <i class="bi bi-plus"></i>
                  Agregar DestinoTuristico
              </Link>                    
          </div>    
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="relative overflow-y-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope='col' className='px-6 py-3'>
                                        nombre
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        descripcion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        pais
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        nro_dias
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        costo_total
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        margen
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        ganancia
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        venta
                                    </th> 

                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="destinoturistico in DestinoTuristicos" className="bg-white border-b ">
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.descripcion}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.pais}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.nro_dias}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.costo_total}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.margen}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.ganancia}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{destinoturistico.venta}}
                                    </td> 

                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('destino_turistico.edit', destinoturistico)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </Link>
                                            <button @click="onDeleteConfirm(destinoturistico)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>                                                                               
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                </div>                
            </div>
        </div>
    </AppLayout>  
</template>
