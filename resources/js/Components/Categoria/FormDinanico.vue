<script>
  export default {
    name: 'CategoriesForm'
  };
</script>

<script setup>   
import { computed, useSlots } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue'; 
    import InputError from '../InputError.vue';
    import FormSectionNew from './FormSectionNew.vue';

    defineProps({
        form: {
            type: Object,
            required: true
        },
        updating: {
            type: Boolean,
            required: true,
            default: false
        },

        fields: {
            type: Object,
            required: true, // Estructura de los campos { name: { type: 'text', placeholder: 'Enter name' }, ... }
        },       
     });
     // Comunicacion vertical descendente agregar o editar a traves de las props
     defineEmits(['submit']);

     const hasActions = computed(() => !! useSlots().actions);

</script>
<template>   
    <!-- Comunicacion vertical ascedente agregar o editar--> 
    <FormSectionNew @submitted="$emit('submit')" class="py-2 w-full">
        <template #form>
        <div v-for="(field, key) in fields" :key="key" class="col-span-12 sm:col-span-12">
            <label :for="key" class="block text-sm font-medium text-gray-700  " >
            {{ field.label || key }}
            </label>

            <!-- Campo de texto -->
            <input
                v-if="field.type === 'text'"
                :id="key"
                :type="field.type"                
                v-model="form[key]"                
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                required
                aurofocus
                :placeholder="field.placeholder || ''"
                autocomplete="off"
            />

            <!-- Campo de selección -->
            <select
                v-else-if="field.type === 'select'"
                :id="key"
                v-model="form[key]"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            >
                <option 
                    v-for="option in field.options" 
                    :key="option.value" 
                    :value="option.value"
                >
                    {{ option.label }}
                </option>
            </select>
            
            <!-- Campo de texto largo -->
            <textarea
                v-else-if="field.type === 'textarea'"
                :id="key"
                :type="field.type" 
                v-model="form[key]"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                required
                aurofocus
                :placeholder="field.placeholder || ''"
                autocomplete="off"
            ></textarea>

            <!-- Campo booleano (checkbox) -->
            <div v-else-if="field.type === 'checkbox'" class="flex items-center">
                <input
                    :id="key"
                    type="checkbox"
                    v-model="form[key]"
                    required
                    class="h-4 w-4 border-gray-300 rounded"
                />
                <label :for="key" class="ml-2 text-sm text-gray-700">{{ field.label }}</label>
            </div>

            <!-- Otros tipos de campo -->
            <input
                v-else                
                :id="key"
                :type="field.type"
                v-model="form[key]"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                required
                aurofocus
                :placeholder="field.placeholder || ''"
                autocomplete="off"
            />
            <InputError class="mt-2" :message="$page.props.errors[key]" />
        </div>
        </template>
        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{updating ? 'Actualizar' : 'Crear'}}
            </PrimaryButton>
        </template>
    </FormSectionNew>
  </template>

  
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  