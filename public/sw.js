// public/sw.js

// Define the name of your cache. Increment the version number if you make changes
// to the service worker or the cached assets to ensure users get the latest version.
const CACHE_NAME = 'my-pwa-cache-v2'; // Increment version if you update cached files or sw.js logic

// List of URLs to cache when the service worker is installed.
// These should be paths relative to your domain root (i.e., from the 'public' directory).
// Note: Vite-handled assets (CSS/JS) are not included here as they're dynamically generated
// and served by Vite's dev server or have hashed filenames in production.
const urlsToCache = [
    '/', // Your application's homepage
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
                // Cache files individually to handle missing files gracefully
                return Promise.allSettled(
                    urlsToCache.map((url) => {
                        return fetch(url)
                            .then((response) => {
                                if (response.ok) {
                                    return cache.put(url, response);
                                } else {
                                    console.warn(`[Service Worker] Skipping ${url}: ${response.status} ${response.statusText}`);
                                }
                            })
                            .catch((error) => {
                                console.warn(`[Service Worker] Failed to cache ${url}:`, error.message);
                            });
                    })
                );
            })
            .then(() => {
                console.log('[Service Worker] Installation complete');
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
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests - don't intercept at all
    if (request.method !== 'GET') {
        return;
    }

    // Skip chrome-extension and other non-http(s) protocols
    if (!url.protocol.startsWith('http')) {
        return;
    }

    // Skip cross-origin requests
    if (url.origin !== self.location.origin) {
        return;
    }

    // Skip Vite dev server requests (HMR, etc.) - check for Vite-specific paths
    if (url.pathname.startsWith('/@') || 
        url.pathname.includes('/node_modules/') ||
        url.pathname.startsWith('/src/') ||
        url.searchParams.has('import') ||
        url.pathname.endsWith('.ts') ||
        url.pathname.endsWith('.tsx') ||
        url.pathname.endsWith('.vue')) {
        return;
    }

    // Skip Vite-generated assets - they have hashes or are served differently
    // Only cache known static assets
    const staticAssetExtensions = ['.png', '.jpg', '.jpeg', '.gif', '.svg', '.ico', '.webmanifest', '.woff', '.woff2', '.ttf', '.eot'];
    const isStaticAsset = staticAssetExtensions.some(ext => url.pathname.toLowerCase().endsWith(ext));
    
    // Also allow the homepage and manifest
    const isAllowedPath = url.pathname === '/' || 
                         url.pathname === '/site.webmanifest' ||
                         url.pathname.startsWith('/assets/');

    // Only intercept static assets and allowed paths
    if (!isStaticAsset && !isAllowedPath) {
        return;
    }

    // Now we can safely intercept
    event.respondWith(
        caches.match(request)
            .then((cachedResponse) => {
                // If the request is in the cache, return the cached response.
                if (cachedResponse) {
                    return cachedResponse;
                }

                // If not in cache, fetch from the network.
                return fetch(request)
                    .then((networkResponse) => {
                        // Only cache successful responses for static assets
                        if (networkResponse.status === 200 && networkResponse.ok) {
                            // Clone the response before caching
                            const responseToCache = networkResponse.clone();
                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(request, responseToCache).catch((err) => {
                                    console.warn('[Service Worker] Failed to cache:', request.url, err);
                                });
                            });
                        }
                        return networkResponse;
                    })
                    .catch((error) => {
                        console.error('[Service Worker] Fetch failed:', request.url, error);
                        // Return the original fetch as fallback
                        return fetch(request);
                    });
            })
            .catch((error) => {
                console.error('[Service Worker] Cache match failed:', request.url, error);
                // Fallback to network if cache match fails
                return fetch(request);
            })
    );
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

