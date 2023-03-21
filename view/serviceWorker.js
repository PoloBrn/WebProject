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
});
*/

const staticCacheName = "cache-v1";
const assets = ["/", "/index.html"];

// ajout fichiers en cache
self.addEventListener("install", (e) => {
    e.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            cache.addAll(assets);
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            // Cache hit - return response
            if (response) {
                return response;
            }

            // IMPORTANT: Cloner la requête.
            // Une requete est un flux et est à consommation unique
            // Il est donc nécessaire de copier la requete pour pouvoir l'utiliser et la servir
            var fetchRequest = event.request.clone();

            return fetch(fetchRequest).then(function (response) {
                if (!response || response.status !== 200 || response.type !== "basic") {
                    return response;
                }

                // IMPORTANT: Même constat qu'au dessus, mais pour la mettre en cache
                var responseToCache = response.clone();

                caches.open(staticCacheName).then(function (cache) {
                    cache.put(event.request, responseToCache);
                });

                return response;
            });
        })
    );
});

// supprimer caches
self.addEventListener("activate", (e) => {
    e.waitUntil(
        caches.keys().then((keys) => {
            return Promise.add(
                keys
                    .filter((key) => key !== staticCacheName)
                    .map((key) => caches.delete(key))
            );
        })
    );
});