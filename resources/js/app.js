// resources/js/app.js
import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Importar Pinia y el plugin de persistencia
import { createPinia } from 'pinia';
import piniaPluginPersistedState from 'pinia-plugin-persistedstate';

// Importar el store de categorías
import { useCategoriesStore } from '@/Stores/categories'; // Ajusta la ruta según tu estructura

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Crear una instancia de Pinia y usar el plugin de persistencia
const pinia = createPinia();
pinia.use(piniaPluginPersistedState);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin) // Usar el plugin de Inertia
            .use(ZiggyVue) // Usar Ziggy
            .use(pinia); // Usar Pinia

        // Inicializar el store de categorías
        const categoriesStore = useCategoriesStore();
        categoriesStore.initializeGlobals().then(() => {
            console.log('Datos globales inicializados');
        });

        // Montar la aplicación
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
