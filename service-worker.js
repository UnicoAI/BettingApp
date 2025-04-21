
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open('v1').then(cache => {
            const filesToCache = [
                '/',
                '/index.php',
                '/vertical-menu/sass/dark-theme.css',
                '/app.js',
                '/assets/LogoUnicoin.png',
                '/manifest.json'
            ];

            console.log('Caching files:', filesToCache);
            return cache.addAll(filesToCache).catch(error => {
                console.error('Failed to cache files:', error);
            });
        })
    );
});

