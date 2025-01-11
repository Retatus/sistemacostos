<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';

    const page = usePage();
    const Servicios = ref(page.props.servicios);
    console.log(Servicios);
    const onDeleteConfirm = (Servicio) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${Servicio.id}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('servicio.destroy', Servicio), {
                onSuccess: (page) => {
                Servicios.value = page.props.servicios;
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
                  Servicio
              </h2>   
              <Link :href="route('servicio.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar Servicio
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
                                        monto
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        moneda
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        proveedor_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        servicio_detalle_id
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        ubicacion
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        tipo_pax
                                    </th> 
                                    <th scope='col' className='px-6 py-3'>
                                        servicio_clase_id
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
                                <tr v-for="servicio in Servicios" className="bg-white border-b ">
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.monto}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.moneda}}
                                    </td> 
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.proveedor_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.proveedor.razon_social}}
                                    </td> 
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.servicio_detalle_id}}
                                    </td>
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.servicio_detalle.descripcion}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.ubicacion}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.tipo_pax}}
                                    </td> 
                                    <td hidden scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.servicio_clase_id}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.servicio_clase.nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicio.estado_activo}}
                                    </td> 

                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('servicio.edit', servicio)">
                                                Editar
                                            </Link>
                                            <button @click="onDeleteConfirm(servicio)">Eliminar</button>
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
