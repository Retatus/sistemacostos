<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import ServiceClassModal from '@/Components/Modal/FormModal.vue';

    const page = usePage();
    const ServicioClases = ref(page.props.servicioclases);
    
    const onDeleteConfirm = (ServicioClase) => {
        Swal.fire({
            title: '<strong>¿Estás seguro?</strong>',
            html: `Este elemento <strong>${ServicioClase.nombre}</strong> será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
            router.delete(route('servicio_clase.destroy', ServicioClase), {
                onSuccess: (page) => {
                ServicioClases.value = page.props.servicioclases;
                Swal.fire('Eliminado', 'El elemento ha sido eliminado con éxito.', 'success');
                },
            });
            }
        });
    };

    const showModal = ref(false);
    const error = ref('');

    async function addServiceClass(data) {
        try {
            const response = await axios.post(route('servicio_clase.storemodal'), data);    
            console.log('Elemento agregado:', response.data);            
            if (response.status === 200) {        
                ServicioClases.value = response.data;    
                showModal.value = false;

                // isModalVisible.value = false;
                // newItem.value = { nombre: ''};
                // Swal.fire({
                //     title: 'Registro exitoso',
                //     html: `Este elemento <strong>${nombre.value}</strong> agregado correctamente.`,
                //     icon: 'success',
                //     timer: 2000,
                //     showConfirmButton: false,
                // }); 
            }else{
                //console.error('Error al agregar el elemento:', error);
                alert('Error al agregar el elemento:', response.data);
            }

        } catch (err) {
            error.value = err.response?.data?.message || 'Ocurrió un error';
        }
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  ServicioClase
              </h2>   
              <!-- <button @click="showModal()" class="btn btn-primary">Modal categoria proveedor</button>        -->
              <button @click="showModal = true">Abrir Modal</button>              
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
                                        estado_activo
                                    </th> 
                                    <th scope="col" className="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="servicioclase in ServicioClases" className="bg-white border-b ">
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicioclase.nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{servicioclase.estado_activo}}
                                    </td> 

                                    <td scope="col" className="px-6 py-4 font-medium text-gray-900">
                                        <div class="flex space-x-2">
                                            <Link :href="route('servicio_clase.edit', servicioclase)">
                                                Editar
                                            </Link>
                                            <button @click="onDeleteConfirm(servicioclase)">Eliminar</button>
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
    <ServiceClassModal
        :isModalVisible="showModal"
        title="Agregar Servicio Clase"
        inputLabel="Nombre"
        inputPlaceholder="Ingrese un nombre"
        submitButtonText="Guardar"
        :errorMessage="error"
        :defaultData="{ nombre: '' }"
        @close="showModal = false"
        @submit="addServiceClass"
    />    
</template>
