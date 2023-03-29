const PREFIX = "V7";
const CACHED_FILES = [
    '../assets/CSS/style.css',
    '../assets/images/chips.png',
    '../assets/images/background.webp',
    '../manifest.json'
];

self.addEventListener("install", (event) => {
    self.skipWaiting();
    event.waitUntil(
        (async () => {
            const cache = await caches.open(PREFIX);
            await Promise.all([...CACHED_FILES, '../view/offline.html'].map((path) => {
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
