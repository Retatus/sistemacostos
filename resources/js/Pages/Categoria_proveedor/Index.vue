<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';

    const page = usePage();
    const CategoriaProveedors = ref(page.props.categoriaproveedors);
    
    const onDeleteConfirm = (categoria) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${categoria.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('categoria_proveedor.destroy', categoria), {
                onSuccess: (page) => {
                CategoriaProveedors.value = page.props.categoriaproveedors;
                Swal.fire('Eliminado', 'El elemento ha sido eliminado con éxito.', 'success');
                },
            });
            }
        });
    };

    const isModalVisible = ref(false);
    function showModal() {
        console.log('Mostrando modal...');
        isModalVisible.value = true;
    }

    function closeModal() {
        console.log('Ocultar modal...');
        isModalVisible.value = false;
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Categoria proveedor
              </h2>   
              <button @click="showModal()" class="btn btn-primary">Modal categoria proveedor</button>    
              <Link :href="route('categoria_proveedor.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar categoria proveedor
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
                                    <th scope="col" className="px-6 py-3">
                                        Id
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Estado
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="CategoriaProveedor in CategoriaProveedors" className="bg-white border-b ">
                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        {{ CategoriaProveedor.id }}
                                    </td>
                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        {{ CategoriaProveedor.nombre }}
                                    </td>
                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        {{ CategoriaProveedor.estado }}
                                    </td>
                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('categoria_proveedor.edit', CategoriaProveedor)">
                                                Editar
                                            </Link>
                                            <button @click="onDeleteConfirm(CategoriaProveedor)">Eliminar</button>
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
    <Modal
        :show="isModalVisible"
        maxWidth="lg"
        closeable
        @close="closeModal"
    >
        <template #default>
            <div class="p-4">
                <h2 class="text-lg font-bold">Agregar categoria proveedor</h2>
                <p>Este es el contenido dentro del modal.</p>
                <button
                    @click="closeModal"
                    class="mt-4 btn btn-secondary"
                >
                    Cerrar
                </button>
            </div>
        </template>
    </Modal>      
</template>
