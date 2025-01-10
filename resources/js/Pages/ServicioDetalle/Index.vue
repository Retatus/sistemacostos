<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';

    const page = usePage();
    const ServicioDetalles = ref(page.props.serviciodetalles);
    
    const onDeleteConfirm = (ServicioDetalle) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${ServicioDetalle.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('serviciodetalle.destroy', ServicioDetalle), {
                onSuccess: (page) => {
                ServicioDetalles.value = page.props.serviciodetalles;
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
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  ServicioDetalle
              </h2>   
              <Link :href="route('serviciodetalle.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar ServicioDetalle
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
                                        descripcion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        costo_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        destino_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        distribucion_venta_id
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
                                <tr v-for="serviciodetalle in ServicioDetalles" className="bg-white border-b ">
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.descripcion}}
                                    </td> 
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.costo_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.costo.nombre}}
                                    </td> 
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.destino_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.destino.nombre}}
                                    </td> 
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.distribucion_venta_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.distribucion_venta.nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{serviciodetalle.estado_activo}}
                                    </td> 

                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('serviciodetalle.edit', serviciodetalle)">
                                                Editar
                                            </Link>
                                            <button @click="onDeleteConfirm(serviciodetalle)">Eliminar</button>
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
