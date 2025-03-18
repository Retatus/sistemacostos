<script>
    export default {
        components: { FormularioDinamico },
    };
</script>

<script setup>
   import { ref } from 'vue';
    import {Link, useForm, usePage} from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormularioDinamico from '@/Components/Categoria/FormDinanico.vue';

    import { useCategoriesStore } from '@/Stores/categories';
    import FileInput from '@/Components/FileInput.vue';
    const categoriesStore = useCategoriesStore();

    const sTipoDocumento = categoriesStore.globals.tipo_documentos;
    const sPais = categoriesStore.globals.pais;
    const sTipoPasajero = categoriesStore.globals.tipo_pasajeros;
    const sTipoClase = categoriesStore.globals.servicio_clases;

    const page = usePage();
    const ListaCotizaciones = page.props.ListaCotizaciones;

    const urlImagen = ref(null);

    const form = useForm({
        nombre: "",
        apellido_paterno: "",
        apellido_materno: "",
        documento_tipo_id: "",
        documento_numero: "",
        pais_id: "",
        documento_file: "",
        tipo_pasajero_id: "",
        clase_id: "",
        cotizacion_id: "",
        estado_activo: "1",

    });

    const submit = () => {
        form.post(route('pasajero.store'));
    }

    const onSelectFile = (e) => {
        const file = event.target.files[0];

        if (!file) return;

        const formatosPermitidos = ["image/jpeg", "image/png"];
        if (!formatosPermitidos.includes(file.type)) {
            alert("Solo se permiten imágenes JPG y PNG");
            return;
        }
        form.documento_file = e.target.files[0];
        urlImagen.value = URL.createObjectURL(file); // Crear una URL temporal
    }
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
          <div class="flex justify-between">
              <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Pasajero
              </h2>   
              <Link :href="route('pasajero')" class="btn btn-primary"> <i class="bi bi-plus"></i>
                  Lista Pasajero
              </Link>                             
          </div>    
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <!-- <FormularioDinamico
                            :form="form"
                            :fields="formFields"                            
                            :updating="false"
                            :hasFiles="true"
                            @submit="form.post(route('pasajero.store'))" 
                        /> -->
                    <div class="md:grid md:grid-cols-1 md:gap-6 py-2 w-full">    
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="submit" method="POST">
                                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                    <div class="w-full  grid grid-cols-1 gap-4">
                                        <div>
                                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                                            <input v-model="form.nombre" type="text" id="nombre" name="nombre" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required minlength="3" maxlength="25">
                                        </div>
                                        <div>
                                            <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido Paterno:</label>
                                            <input v-model="form.apellido_paterno" type="text" id="apellido_paterno" name="apellido_paterno" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required minlength="3" maxlength="25">
                                        </div>
                                        <div>
                                            <label for="apellido_materno" class="block text-sm font-medium text-gray-700">Apellido Materno:</label>
                                            <input v-model="form.apellido_materno" type="text" id="apellido_materno" name="apellido_materno" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required minlength="3" maxlength="25">
                                        </div>
                                        <div>
                                            <label for="documento_tipo_id" class="block text-sm font-medium text-gray-700">Tipo de Documento:</label>
                                            <select v-model="form.documento_tipo_id" id="documento_tipo_id" name="documento_tipo_id" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option disabled value="">-- Selecciona una opción --</option>
                                                <option v-for="option in sTipoDocumento" :key="option.value" :value="option.value">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="documento_numero" class="block text-sm font-medium text-gray-700">Número de Documento:</label>
                                            <input v-model="form.documento_numero" type="text" id="documento_numero" name="documento_numero" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required minlength="3" maxlength="15">
                                        </div>
                                        <div>
                                            <label for="pais_id" class="block text-sm font-medium text-gray-700">País:</label>
                                            <select v-model="form.pais_id" id="pais_id" name="pais_id" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option disabled value="">-- Selecciona una opción --</option>
                                                <option v-for="option in sPais" :key="option.value" :value="option.value" :selected="option.value === form.pais_id">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="documento_file" class="block text-sm font-medium text-gray-700">Archivo de Documento:</label>
                                            <FileInput name="documento_file" @change="onSelectFile($event)" />
                                            <!-- Mostrar previsualización si hay una nueva imagen seleccionada -->
                                            <img v-if="urlImagen" :src="urlImagen" class="h-20 w-20 object-cover mt-2" />
                                        </div>
                                        <div>
                                            <label for="tipo_pasajero_id" class="block text-sm font-medium text-gray-700">Tipo de Pasajero:</label>
                                            <select v-model="form.tipo_pasajero_id" id="tipo_pasajero_id" name="tipo_pasajero_id" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option disabled value="">-- Selecciona una opción --</option>
                                                <option v-for="option in sTipoPasajero" :key="option.value" :value="option.value">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="clase_id" class="block text-sm font-medium text-gray-700">Clase:</label>
                                            <select v-model="form.clase_id" id="clase_id" name="clase_id" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option disabled value="">-- Selecciona una opción --</option>
                                                <option v-for="option in sTipoClase" :key="option.value" :value="option.value">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="cotizacion_id" class="block text-sm font-medium text-gray-700">Cotización:</label>
                                            <select v-model="form.cotizacion_id" id="cotizacion_id" name="cotizacion_id" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option disabled value="">-- Selecciona una opción --</option>
                                                <option v-for="option in ListaCotizaciones" :key="option.value" :value="option.value">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="estado_activo" class="block text-sm font-medium text-gray-700">Estado Activo:</label>
                                            <select v-model="form.estado_activo" id="estado_activo" name="estado_activo" class="mt-1  w-full border-gray-300 rounded-md shadow-sm" required>
                                                <option disabled value="1">Activo</option>
                                                <option disabled value="0">Desactivo</option>                                    
                                            </select>
                                        </div>
                                        <button type="submit">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>  
</template>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  