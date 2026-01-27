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
// Service Worker Registration for PWA
// Enables offline functionality and install prompt
// -----------------------------------------------------------
if ('serviceWorker' in navigator) {
    // Register service worker when the page loads
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/sw.js')
            .then((registration) => {
                console.log('Service Worker registered successfully:', registration.scope);
                
                // Check for updates periodically
                setInterval(() => {
                    registration.update();
                }, 60000); // Check every minute
            })
            .catch((error) => {
                console.error('Service Worker registration failed:', error);
            });
    });
}


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue', { eager: false })),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        
        // Configure Ziggy - use from window (set by @routes) or from Inertia props
        const ziggyConfig = (window as any).Ziggy || props.initialPage?.props?.ziggy;
        app.use(plugin);
        if (ziggyConfig) {
            app.use(ZiggyVue, ziggyConfig);
        } else {
            app.use(ZiggyVue);
        }
        
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();