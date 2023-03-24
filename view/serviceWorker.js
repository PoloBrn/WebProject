const PREFIX = "V7";
const CACHED_FILES = [
    '../assets/CSS/style.css',
    '../assets/images/chips.png',
    '../assets/images/background.png'
];

self.addEventListener("install", (event) => {
    self.skipWaiting();
    event.waitUntil(
        (async () => {
            const cache = await caches.open(PREFIX);
            await Promise.all([...CACHED_FILES, 'offline.html'].map((path) => {
                return cache.add(new Request(path));
            }))
            /*cache.add(new Request('offline.html'));
            cache.add(new Request('../assets/CSS/style.css'));
            cache.add(new Request('../assets/images/chips.png'));
            cache.add(new Request('../assets/images/background.png'));
            cache.add(new Request('../manifest.json'));*/
        })()
    );
    console.log(`${PREFIX} Install`);
});


self.addEventListener("activate", (event) => {
    clients.claim();
    event.waitUntil(
        (async () => {
            const keys = await caches.keys();
            await Promise.all(
                keys.map(key => {
                    if (!key.includes(PREFIX)) {
                        return caches.delete(key);
                    }
                })
            );
        })()
    );
    console.log(`${PREFIX} Active`);
});

self.addEventListener('fetch', (event) => {
    console.log(`Fetching : ${event.request.url}, Mode : ${event.request.mode}`
    );
    if (event.request.mode == 'navigate') {
        event.respondWith(
            (async () => {
                try {
                    const preloadResponse = await event.preloadResponse;
                    if (preloadResponse) {
                        return preloadResponse;
                    }

                    return await fetch(event.request);
                } catch (e) {
                    const cache = await caches.open(PREFIX);
                    return await cache.match('offline.html');
                }
            })()
        );
    } else if (CACHED_FILES.includes(event.request.url)) {
        event.respondWith(caches.match(event.request));
    }
});