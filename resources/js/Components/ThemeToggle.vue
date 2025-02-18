<template>
    <div class="flex">
        <button @click="toggleTheme" class="p-2 rounded-full">
            <span v-if="isDark">🌙</span>
            <span v-else>☀️</span>
        </button>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    const isDark = ref(false);

    const toggleTheme = () => {
        isDark.value = !isDark.value;
        if (isDark.value) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    };

    onMounted(() => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            isDark.value = true;
            document.documentElement.classList.add('dark');
        } else {
            isDark.value = false;
            document.documentElement.classList.remove('dark');
        }
    });
</script>