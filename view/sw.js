/*importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.0.2/workbox-sw.js');

workbox.routing.registerRoute(
    ({ request }) => request.destination === 'image',
    new workbox.strategies.NetworkFirst()
);

//Installation du service worker
self.addEventListener('install', evt => {
    evt.waitUntil(caches.open(NomDuCache).then(cache => {
        cache.addAll(assets);
    })
    )
});

self.addEventListener('activate', evt => {
    console.log('le Service Worker a été installé ');
});

//fetch event afin de répondre quand on est en mode hors ligne.
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.open('ma_sauvegarde').then(function (cache) {
            return cache.match(event.request).then(function (response) {
                return response || fetch(event.request).then(function (response) {
                    cache.put(event.request, response.clone());
                    return response;
                });
            });
        })
    );
});*/