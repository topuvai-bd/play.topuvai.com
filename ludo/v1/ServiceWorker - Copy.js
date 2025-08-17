const cacheName = "DefaultCompany-Deshi Ludo-1.0";
const contentToCache = [
    "Build/v1.loader.js",
    "Build/v1.framework.js",
    "Build/v1.data",
    "Build/v1.wasm",
    "TemplateData/style.css"

];

// add
self.addEventListener('activate', event => {
  event.waitUntil(
      caches.keys().then(cacheNames => {
          return Promise.all(
              cacheNames.filter(name => name !== cacheName)
                  .map(name => caches.delete(name))
          );
      })
  );
});

//change
self.addEventListener('fetch', function(e) {
  e.respondWith((async function() {
      if (e.request.method !== 'GET') {
          return fetch(e.request);
      }

      try {   
          const cachedResponse = await caches.match(e.request);
          if (cachedResponse) {
              console.log(`[Service Worker] Return cached: ${e.request.url}`);
              return cachedResponse;
          }
    
          const fetchResponse = await fetch(e.request);
             
          if (fetchResponse.status === 200 && isCacheable(fetchResponse)) {
              const cache = await caches.open(cacheName);
              console.log(`[Service Worker] Caching new: ${e.request.url}`);
              cache.put(e.request, fetchResponse.clone());
          }
          
          return fetchResponse;
      } catch (error) {
          console.log('[Service Worker] Fetch failed; returning offline page');
          return caches.match('offline.html'); 
      }
  })());
});

//add
function isCacheable(response) {
  const contentType = response.headers.get('content-type') || '';
  return contentType.includes('application/javascript') ||
         contentType.includes('text/css') ||
         contentType.includes('application/wasm') ||
         contentType.includes('application/octet-stream');
}
