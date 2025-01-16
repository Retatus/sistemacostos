<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import { router } from '@inertiajs/vue3';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import ServiceClassModal from '@/Components/Modal/FormModal.vue';

    const page = usePage();
    const ServicioClases = ref(page.props.servicioclases.data);
    
    console.log(ServicioClases);
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
            const response = await axios.post(`${route('servicio_clase')}/storemodal`, data);    
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

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    servicioclases: Object,
  },
  methods: {
    changePage(page) {
        if(page > 0 && page <= this.servicioclases.last_page){
            this.$inertia.get(window.location.pathname, { page: page });
        }
    }
  },
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  ServicioClase
              </h2>   
              <button @click="showModal = true">Agregar Servicio Clase Modal</button>      
              <Link :href="route('servicio_clase.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar Servicio Clase
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
                        <div v-if="servicioclases.last_page > 1" class="flex justify-center items-center gap-4 mt-5 mb-5">
                            <SecondaryButton 
                                @click="changePage(servicioclases.current_page - 1)" 
                                :disabled="servicioclases.current_page === 1">
                                Anterior
                            </SecondaryButton>
                            <span>Página {{ servicioclases.current_page }} de {{ servicioclases.last_page }}</span>
                            <SecondaryButton 
                                @click="changePage(servicioclases.current_page + 1)" 
                                :disabled="servicioclases.current_page === servicioclases.last_page">
                                Siguiente
                            </SecondaryButton>
                        </div>
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
