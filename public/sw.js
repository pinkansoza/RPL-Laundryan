const CACHE_NAME = 'laundry-admin-cache-v2';
const OFFLINE_ADMIN_URL = '/offline';
const OFFLINE_PROFILE_URL = '/offline-profile';

const urlsToCache = [
    OFFLINE_ADMIN_URL,
    OFFLINE_PROFILE_URL,
    '/images/pwa-icon.svg'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .catch(() => {
                    const url = new URL(event.request.url);
                    if (url.pathname.startsWith('/bakulTambakSukses')) {
                        return caches.match(OFFLINE_ADMIN_URL);
                    }
                    return caches.match(OFFLINE_PROFILE_URL);
                })
        );
    } else {
        event.respondWith(
            caches.match(event.request)
                .then((response) => {
                    return response || fetch(event.request);
                })
        );
    }
});
