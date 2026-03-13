<template>   
    <!-- Comunicacion vertical ascendente agregar o editar--> 
    <FormSectionNew @submitted="$emit('submit')" class="py-2 w-full">        
        <template #form>  
            <!-- Mensaje de éxito -->
            <div v-if="form.recentlySuccessful" 
                 class="col-span-12 mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-green-700">
                    {{ updating ? 'Actualizado' : 'Creado' }} correctamente
                </p>
            </div>
            
            <!-- Grid responsive para campos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="(field, key) in fields" :key="key" 
                     :class="['space-y-2', field.fullWidth ? 'col-span-1 md:col-span-2 lg:col-span-3' : '']">
                    
                    <!-- Label con icono opcional -->
                    <div class="flex items-center justify-between">
                        <label :for="key" class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <span v-if="field.icon" class="text-gray-500">
                                <component :is="field.icon" class="w-4 h-4" />
                            </span>
                            {{ field.label || formatLabel(key) }}
                            <span v-if="field.required" class="text-red-500 ml-1">*</span>
                        </label>
                        
                        <!-- Helper text pequeño -->
                        <span v-if="field.helper" class="text-xs text-gray-500">
                            {{ field.helper }}
                        </span>
                    </div>

                    <!-- Campo de texto -->
                    <div v-if="field.type === 'text' || field.type === 'email' || field.type === 'password' || field.type === 'number' || field.type === 'date'" 
                         class="relative">
                        <input
                            :id="key"
                            :type="field.type"
                            v-model="form[key]"
                            :disabled="field.disabled ?? false"
                            :required="field.required ?? true"
                            :placeholder="field.placeholder || `Ingrese ${field.label?.toLowerCase() || key}`"
                            autocomplete="off"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 disabled:bg-gray-100 disabled:cursor-not-allowed placeholder:text-gray-400"
                            :class="{
                                'pl-10': field.icon,
                                'border-red-300': $page.props.errors[key],
                                'bg-green-50 border-green-300': field.success
                            }"
                        />
                        <!-- Icono izquierdo -->
                        <div v-if="field.icon" class="absolute left-3 top-3.5 text-gray-400 pointer-events-none">
                            <component :is="field.icon" class="w-4 h-4" />
                        </div>
                        <!-- Icono derecho para errores -->
                        <div v-if="$page.props.errors[key]" class="absolute right-3 top-3.5 text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Campo de selección -->
                    <select
                        v-else-if="field.type === 'select'"
                        :id="key"
                        v-model="form[key]"
                        :disabled="field.disabled ?? false"
                        :required="field.required ?? true"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 disabled:bg-gray-100 disabled:cursor-not-allowed appearance-none bg-white"
                        :class="{
                            'border-red-300': $page.props.errors[key],
                            'bg-green-50 border-green-300': field.success
                        }"
                    >
                        <option value="" disabled selected class="text-gray-400">
                            {{ field.placeholder || `Seleccione ${field.label?.toLowerCase() || key}` }}
                        </option>
                        <option 
                            v-for="option in field.options" 
                            :key="option.value" 
                            :value="option.value"
                            class="py-2 hover:bg-blue-50"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                    
                    <!-- Campo de texto largo -->
                    <textarea
                        v-else-if="field.type === 'textarea'"
                        :id="key"
                        v-model="form[key]"
                        :disabled="field.disabled ?? false"
                        :required="field.required ?? true"
                        :placeholder="field.placeholder || `Ingrese ${field.label?.toLowerCase() || key}`"
                        autocomplete="off"
                        :rows="field.rows || 4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 disabled:bg-gray-100 disabled:cursor-not-allowed placeholder:text-gray-400 resize-none"
                        :class="{
                            'border-red-300': $page.props.errors[key],
                            'bg-green-50 border-green-300': field.success
                        }"
                    ></textarea>

                    <!-- Campo booleano (checkbox) -->
                    <div v-else-if="field.type === 'checkbox'" 
                         class="flex items-start space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <input
                            :id="key"
                            type="checkbox"
                            v-model="form[key]"
                            :disabled="field.disabled ?? false"
                            :required="field.required ?? true"
                            class="h-5 w-5 mt-0.5 border-gray-300 rounded focus:ring-blue-500 text-blue-600"
                        />
                        <div class="flex-1">
                            <label :for="key" class="block text-sm font-medium text-gray-800">
                                {{ field.label }}
                            </label>
                            <p v-if="field.description" class="text-xs text-gray-500 mt-1">
                                {{ field.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Radio buttons -->
                    <div v-else-if="field.type === 'radio'" class="space-y-2">
                        <div v-for="option in field.options" :key="option.value" 
                             class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50">
                            <input
                                :id="`${key}-${option.value}`"
                                type="radio"
                                :value="option.value"
                                v-model="form[key]"
                                :disabled="field.disabled ?? false"
                                class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <label :for="`${key}-${option.value}`" class="text-sm text-gray-700">
                                {{ option.label }}
                            </label>
                        </div>
                    </div>

                    <!-- Campo para archivos -->
                    <div v-else-if="field.type === 'file'" class="space-y-2">
                        <div class="flex items-center justify-center w-full">
                            <label :for="key" 
                                   class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-1 text-sm text-gray-500">
                                        <span class="font-semibold">Click para subir</span>
                                    </p>
                                    <p class="text-xs text-gray-500">{{ field.placeholder || 'PNG, JPG, PDF (MAX. 5MB)' }}</p>
                                </div>
                                <input 
                                    :id="key" 
                                    type="file" 
                                    @change="handleFileUpload(key, $event)"
                                    class="hidden" 
                                    :accept="field.accept"
                                />
                            </label>
                        </div>
                        <div v-if="form[key]" class="text-sm text-gray-600">
                            Archivo seleccionado: {{ form[key].name }}
                        </div>
                    </div>

                    <!-- Campo por defecto -->
                    <input
                        v-else
                        :id="key"
                        type="text"
                        v-model="form[key]"
                        :disabled="field.disabled ?? false"
                        :required="field.required ?? true"
                        :placeholder="field.placeholder || `Ingrese ${field.label?.toLowerCase() || key}`"
                        autocomplete="off"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 disabled:bg-gray-100 disabled:cursor-not-allowed placeholder:text-gray-400"
                    />

                    <!-- Mensaje de error -->
                    <InputError 
                        v-if="$page.props.errors[key]" 
                        class="text-xs text-red-600 flex items-center gap-1"
                        :message="$page.props.errors[key]"
                    />
                    
                    <!-- Contador para textarea -->
                    <div v-if="field.type === 'textarea' && field.maxLength" 
                         class="text-xs text-gray-500 text-right">
                        {{ form[key]?.length || 0 }} / {{ field.maxLength }}
                    </div>
                </div>
            </div>
        </template>
        
        <template #actions>
            <div class="flex flex-col sm:flex-row gap-3 justify-end items-center">
                
                <PrimaryButton 
                    :class="{ 'opacity-50 cursor-not-allowed': form.processing, 'w-full sm:w-auto': true }" 
                    :disabled="form.processing"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl"
                >
                    <div class="flex items-center justify-center gap-2">
                        <svg v-if="form.processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                        <svg v-else-if="updating" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ updating ? 'Actualizar' : 'Crear' }}
                    </div>
                </PrimaryButton>
            </div>
        </template>
    </FormSectionNew>
</template>

<script setup>    
    import PrimaryButton from '@/Components/PrimaryButton.vue'; 
    import InputError from '../InputError.vue';
    import FormSectionNew from './FormSectionNew.vue';

    defineProps({
        fields: {
            type: Object,
            required: true,
            default: () => ({})
        },
        form: {
            type: Object,
            required: true
        },
        updating: {
            type: Boolean,
            default: false
        },
        showCancelButton: {
            type: Boolean,
            default: true
        }
    })

    defineEmits(['submit', 'cancel'])

    // Formatear label automáticamente
    const formatLabel = (key) => {
        return key
            .replace(/([A-Z])/g, ' $1')
            .replace(/^./, str => str.toUpperCase())
            .replace(/_/g, ' ')
    }

    // Manejar upload de archivos
    const handleFileUpload = (key, event) => {
        const file = event.target.files[0]
        if (file) {
            // Aquí puedes manejar la validación del archivo
            const maxSize = 5 * 1024 * 1024 // 5MB
            if (file.size > maxSize) {
                alert('El archivo es demasiado grande. Máximo 5MB.')
                event.target.value = null
                return
            }
            // Emitir evento o actualizar form
            // this.form[key] = file
        }
    }
</script>

<style scoped>
/* Animaciones */
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Estilos para scroll en textarea */
textarea::-webkit-scrollbar {
    width: 6px;
}

textarea::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

/* Estilo para selects con flecha personalizada */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}
</style>