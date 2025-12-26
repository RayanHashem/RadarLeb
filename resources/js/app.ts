import '../css/app.css';
import 'bootstrap/dist/js/bootstrap.bundle.js';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// -----------------------------------------------------------
// Service Worker Registration
// TEMPORARILY DISABLED - Unregister all Service Workers to fix CSS loading issues
// -----------------------------------------------------------
if ('serviceWorker' in navigator) {
    // Immediately unregister all Service Workers and clear caches
    navigator.serviceWorker.getRegistrations().then((registrations) => {
        if (registrations.length > 0) {
            console.log(`Unregistering ${registrations.length} Service Worker(s)...`);
            registrations.forEach((registration) => {
                registration.unregister().then((success) => {
                    if (success) {
                        console.log('Service Worker unregistered successfully');
                    }
                });
            });
        }
        
        // Clear all caches
        caches.keys().then((cacheNames) => {
            if (cacheNames.length > 0) {
                console.log(`Clearing ${cacheNames.length} cache(s)...`);
                cacheNames.forEach((cacheName) => {
                    caches.delete(cacheName).then((deleted) => {
                        if (deleted) {
                            console.log(`Cache "${cacheName}" deleted`);
                        }
                    });
                });
            }
        });
    });
    
    // Prevent any new Service Worker registration
    // Service Workers are completely disabled for now
}


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();