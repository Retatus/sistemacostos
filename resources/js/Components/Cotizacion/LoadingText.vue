<template>
  <div class="text-xs text-blue-600 flex items-center gap-1">
    <svg class="w-3 h-3 animate-spin" viewBox="0 0 24 24"></svg>
    {{ text }}
  </div>
</template>

<script setup>
defineProps({ text: String })
</script>
