<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import {Link, usePage} from '@inertiajs/vue3';
  import { ref } from 'vue';

  const page = usePage();
  const CategoriaProveedors = ref(page.props.categoriaproveedors);

  const onDeleteSuccess = (e)=>{
      //console.log(e);
      CategoriaProveedors.value = e.props.categoriaproveedors;
  }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Categoria proveedor
              </h2>   
              <Link :href="route('categoria_proveedor.create')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Agregar categoria
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
                                            <Link 
                                                @success="onDeleteSuccess" 
                                                :href="route('categoria_proveedor.destroy', CategoriaProveedor)" 
                                                method="delete" 
                                                as="button">
                                                Eliminar
                                            </Link>
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