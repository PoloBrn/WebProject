const NomDuCache = 'v1';
/*const assets = [
  '/index.php',
  '/styles.css',
  '/manifest.json',
  '/image/chips.png',
];*/

importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.0.2/workbox-sw.js');

workbox.routing.registerRoute(
  ({ request }) => request.destination === 'image',
  new workbox.strategies.CacheFirst({
    cacheName: 'images',
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 50,
        maxAgeSeconds: 30 * 24 * 60 * 60, // 30 days
      }),
    ],
  })
);

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(NomDuCache).then((cache) => {
      return cache.addAll(assets);
    })
  );
});

self.addEventListener('activate', (event) => {
  console.log('Le service worker a été installé.');
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request).then((response) => {
        if(response.status !== 200 || response.type !== 'basic') {
          return response;
        }

        const responseToCache = response.clone();
        caches.open(NomDuCache).then((cache) => {
          cache.put(event.request, responseToCache);
        });

        return response;
      });
    })
  );
});