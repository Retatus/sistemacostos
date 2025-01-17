<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {Link, usePage} from '@inertiajs/vue3';
    import Swal from 'sweetalert2';
    import { ref, computed } from 'vue';
    import { router } from '@inertiajs/vue3';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    

    const page = usePage();
    const Proveedors = ref(page.props.proveedors.data);

    console.log(Proveedors);

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
            const tipoComprobante = tiposDocumento.value.find((tipoComprobante) => tipoComprobante.id == doc.tipo_comprobante);
            const tipoSunat = tiposSunat.value.find((tipoSunat) => tipoSunat.id == doc.tipo_sunat);
            return {
            ...doc,
            tipo_documento_nombre: tipoComprobante ? tipoComprobante.nombre : 'Desconocido',
            tipo_sunat_nombre: tipoSunat ? tipoSunat.nombre : 'Desconocido',
            };
        });
    });

        
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
<script>
import { defineComponent } from 'vue';


export default defineComponent({
  props: {
    proveedors: Object,
  },
  methods: {
    changePage(page) {
        if(page > 0 && page <= this.proveedors.last_page){
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
                  proveedor
              </h2>   
              <Link :href="route('proveedor.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar proveedor
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
                                        {{proveedor.ruc}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.razon_social}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.direccion}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.tipo_documento_nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.correo}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.tipo_sunat_nombre}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.contacto}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.estado_activo}}
                                    </td> 
                                    <td scope='col' className='px-6 py-4 font-medium text-gray-900'>
                                        {{proveedor.categoria.nombre}}
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
                        <div class="flex justify-between py-5 px-5">
                            <div class="flex justify-center items-center gap-4 mt-5 mb-5">
                                <span>Total de proveedores: {{ proveedors.total }}</span>
                            </div>
                            <div v-if="proveedors.last_page > 1" class="flex justify-center items-center gap-4 mt-5 mb-5">
                                <SecondaryButton 
                                    @click="changePage(proveedors.current_page - 1)" 
                                    :disabled="proveedors.current_page === 1">
                                    Anterior
                                </SecondaryButton>
                                <span>Página {{ proveedors.current_page }} de {{ proveedors.last_page }}</span>
                                <SecondaryButton 
                                    @click="changePage(proveedors.current_page + 1)" 
                                    :disabled="proveedors.current_page === proveedors.last_page">
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
