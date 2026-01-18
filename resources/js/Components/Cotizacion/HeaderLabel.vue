<template>
  <div class="flex justify-between">
    <span class="text-xs font-medium text-gray-700">{{ label }}</span>
    <span v-if="id" class="text-xs text-gray-500">ID: {{ id }}</span>
  </div>
</template>

<script setup>
defineProps({
  label: String,
  id: [Number, String]
})
</script>
