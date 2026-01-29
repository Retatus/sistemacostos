<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed, h, onMounted } from 'vue';
import { ref } from 'vue';
import { tr } from 'date-fns/locale';

const props = defineProps({
    user: {
        type: Object,
        default: null
    },
    roles: {
        type: Array,
        default: () => []
    },
    permissions: {
        type: Array,
        default: () => []
    },
    isEditing: {
        type: Boolean,
        default: false
    }
});

// Formulario reactivo
const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '',
    password_confirmation: '',
    roles: props.user?.roles.map(r => r.id) || [],
    permissions: props.user?.permissions.map(p => p.id) || []
});

// Estado para mostrar/ocultar contraseña
const showPassword = ref(false);

// Determinar si estamos editando o creando
const mode = computed(() => props.isEditing ? 'edit' : 'create');

// Título dinámico
const pageTitle = computed(() => 
    mode.value === 'edit' ? 'Editar Usuario' : 'Crear Usuario'
);

// Texto del botón
const submitButtonText = computed(() => 
    mode.value === 'edit' ? 'Actualizar Usuario' : 'Crear Usuario'
);

// Ruta de envío dinámica
const submitRoute = computed(() => {
    if (mode.value === 'edit') {
        return route('admin.users.update', props.user?.id);
    }
    return route('admin.users.store');
});

// Método de envío dinámico
function handleSubmit() {
    if (mode.value === 'edit') {
        form.put(submitRoute.value, {
            preserveScroll: true,
            onSuccess: () => {
                // Opcional: mostrar mensaje de éxito
                console.log('Usuario actualizado');
            }
        });
    } else {
        form.post(submitRoute.value, {
            preserveScroll: true,
            onSuccess: () => {
                // Resetear formulario después de crear
                form.reset();
            }
        });
    }
}

// Toggle para mostrar contraseña
function togglePasswordVisibility() {
    showPassword.value = !showPassword.value;
}

// Cargar datos del usuario si estamos editando
onMounted(() => {
    if (props.user) {
        form.id = props.user.id;
        form.name = props.user.name;
        form.email = props.user.email;
        // No cargamos la contraseña por seguridad
    }
});
</script>

<template>
    <AppLayout :title="pageTitle">
        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ pageTitle }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ mode === 'edit' ? 'Modifica la información del usuario' : 'Registra un nuevo usuario en el sistema' }}
                    </p>
                </div>
                <Link 
                    :href="route('admin.users.index')" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-200"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a la lista
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Tarjeta del formulario -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <!-- Encabezado de la tarjeta -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path v-if="mode === 'edit'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Información del Usuario
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Complete todos los campos requeridos
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
                        <!-- Campo Nombre -->
                        <div>
                            <!-- ID -->
                             <div v-if="mode === 'edit'" class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                ID
                                </label>
                                <div class="relative">
                                    <input 
                                        v-model="form.id" 
                                        type="text"
                                        disabled
                                        :class="[
                                            'w-full pl-4 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-offset-1 transition duration-200 bg-gray-100 cursor-not-allowed',
                                            'border-gray-300 focus:border-blue-500 focus:ring-blue-500'
                                        ]"
                                    />
                                </div>
                             </div>
                            
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre completo
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input 
                                    v-model="form.name" 
                                    type="text"
                                    placeholder="Ingrese el nombre completo"
                                    :class="[
                                        'w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-offset-1 transition duration-200',
                                        form.errors.name 
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'
                                    ]"
                                    required
                                />
                            </div>
                            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Campo Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input 
                                    v-model="form.email" 
                                    type="email"
                                    placeholder="ejemplo@correo.com"
                                    :class="[
                                        'w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-offset-1 transition duration-200',
                                        form.errors.email 
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'
                                    ]"
                                    required
                                />
                            </div>
                            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Campo Contraseña (solo requerido al crear) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña
                                <span v-if="mode === 'create'" class="text-red-500">*</span>
                                <span v-else class="text-gray-500 text-xs ml-2">(Opcional - deje en blanco para no cambiar)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input 
                                    v-model="form.password" 
                                    :type="showPassword ? 'text' : 'password'"
                                    :placeholder="mode === 'create' ? 'Mínimo 6 caracteres' : 'Nueva contraseña'"
                                    :class="[
                                        'w-full pl-10 pr-12 py-3 border rounded-lg focus:ring-2 focus:ring-offset-1 transition duration-200',
                                        form.errors.password 
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500' 
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'
                                    ]"
                                    :required="mode === 'create'"
                                />
                                <button
                                    type="button"
                                    @click="togglePasswordVisibility"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                >
                                    <svg v-if="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                    <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Confirmar Contraseña (solo mostrar si se ingresó contraseña) -->
                        <div v-if="form.password">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmar Contraseña
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <input 
                                    v-model="form.password_confirmation" 
                                    :type="showPassword ? 'text' : 'password'"
                                    placeholder="Repita la contraseña"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:ring-offset-1 transition duration-200"
                                />
                            </div>
                        </div>
                        <h2 class="text-xl mt-6">Roles</h2>
                        <div v-for="role in roles" :key="role.id">
                            <label>
                                <input
                                    type="checkbox"
                                    :value="role.id"
                                    v-model="form.roles"
                                >
                                {{ role.name }}
                            </label>
                        </div>

                        <h2 class="text-xl mt-6">Permisos especiales</h2>
                        <div v-for="perm in permissions" :key="perm.id">
                            <label>
                                <input
                                    type="checkbox"
                                    :value="perm.id"
                                    v-model="form.permissions"
                                >
                                {{ perm.name }}
                            </label>
                        </div>

                        <!-- Botones de acción -->
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <Link 
                                    :href="route('admin.users.index')" 
                                    class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200"
                                >
                                    Cancelar
                                </Link>
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    :class="[
                                        'px-6 py-3 font-medium rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2',
                                        mode === 'edit'
                                            ? 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500'
                                            : 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
                                        form.processing ? 'opacity-75 cursor-not-allowed' : ''
                                    ]"
                                >
                                    <span v-if="form.processing" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Procesando...
                                    </span>
                                    <span v-else class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path v-if="mode === 'edit'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M5 13l4 4L19 7" />
                                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        {{ submitButtonText }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Nota informativa -->
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-medium">Nota:</span> 
                                {{ mode === 'edit' 
                                    ? 'Al actualizar un usuario, solo complete los campos de contraseña si desea cambiarla.' 
                                    : 'Todos los campos son obligatorios al crear un nuevo usuario.' 
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>