// public/sw.js

// Define the name of your cache. Increment the version number if you make changes
// to the service worker or the cached assets to ensure users get the latest version.
const CACHE_NAME = 'my-pwa-cache-v2'; // Increment version if you update cached files or sw.js logic

// List of URLs to cache when the service worker is installed.
// These should be paths relative to your domain root (i.e., from the 'public' directory).
const urlsToCache = [
    '/', // Your application's homepage
    '/css/app.css', // Assuming your main CSS file is compiled here by Vite/Mix
    '/js/app.js',   // Assuming your main JavaScript file is compiled here by Vite/Mix
    // Add your main favicon files to the cache
    '/favicon.ico',
    '/apple-touch-icon.png',
    '/favicon-32x32.png',
    '/favicon-16x16.png',
    '/android-chrome-192x192.png',
    '/android-chrome-512x512.png',
    '/site.webmanifest',
    // If you have other critical static assets (like a logo.png in public/images/ or specific fonts), add them here:
    // '/assets/imgs/logo.png', // Example if you have a main logo image
    // '/assets/fonts/GEFlow.woff2', // Example if you have custom fonts
];

// -----------------------------------------------------------
// Install Event: Caches the listed assets
// This event fires when the service worker is first installed.
// -----------------------------------------------------------
self.addEventListener('install', (event) => {
    console.log('[Service Worker] Installing...');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[Service Worker] Caching app shell');
                return cache.addAll(urlsToCache); // Add all listed URLs to the cache
            })
            .catch((error) => {
                console.error('[Service Worker] Failed to cache during install:', error);
            })
    );
});

// -----------------------------------------------------------
// Fetch Event: Serves assets from cache or network
// This event fires every time the browser requests a resource.
// -----------------------------------------------------------
self.addEventListener('fetch', (event) => {
    // We only want to handle HTTP(S) requests.
    if (event.request.url.startsWith('http')) {
        event.respondWith(
            caches.match(event.request)
                .then((response) => {
                    // If the request is in the cache, return the cached response.
                    if (response) {
                        console.log(`[Service Worker] Serving from cache: ${event.request.url}`);
                        return response;
                    }

                    // If not in cache, fetch from the network.
                    console.log(`[Service Worker] Fetching from network: ${event.request.url}`);
                    return fetch(event.request)
                        .then((networkResponse) => {
                            // Optionally, cache new successful responses for future use.
                            // Be careful with caching too much, especially dynamic content.
                            // This example caches successful GET requests.
                            if (networkResponse.status === 200 && networkResponse.type === 'basic') {
                                const responseToCache = networkResponse.clone();
                                caches.open(CACHE_NAME).then((cache) => {
                                    cache.put(event.request, responseToCache);
                                });
                            }
                            return networkResponse;
                        })
                        .catch((error) => {
                            console.error('[Service Worker] Fetch failed:', error);
                            // You could return an offline page here if the fetch fails
                            // return caches.match('/offline.html'); // Requires an offline.html to be cached
                        });
                })
        );
    }
});

// -----------------------------------------------------------
// Activate Event: Cleans up old caches
// This event fires when the service worker becomes active.
// It's a good place to delete old caches.
// -----------------------------------------------------------
self.addEventListener('activate', (event) => {
    console.log('[Service Worker] Activating...');
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log(`[Service Worker] Deleting old cache: ${cacheName}`);
                        return caches.delete(cacheName);
                    }
                    return null;
                })
            );
        })
    );
});
