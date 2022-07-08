console.log("Service Worker Loaded...");

const myCache = 'cache-v1';
var resourcesToPrecache = [
  './',
  './index.html',
  './naturallove.webmanifest',
  './js/routes.js',
  './js/spa.js',
  './js/service_worker_installer.js',
  './js/info.json',
  './bridge.css',
  './css/reset.css',
  './css/blog.css',
  './css/gallery.css',
  './css/home.css',
  './css/style.css',
  './css/responsive.css',
  './fonts/nunito-v11-latin-regular.eot',
  './fonts/nunito-v11-latin-regular.svg',
  './fonts/nunito-v11-latin-regular.ttf',
  './fonts/nunito-v11-latin-regular.woff',
  './fonts/nunito-v11-latin-regular.woff2',
  './img/natural-love.ico',
  './img/assets.svg',
  './img/logos.svg',
  './img/logo.svg',
  './img/sil.jpg',
  './img/bg.svg',
  './img/bg_desktop.jpg',
  './img/placeholder.png',
  './views/blog.html',
  './views/gallery.html',
  './page404.html',
  './views/home.html',
];

self.addEventListener('install', function(e){

  e.waitUntil(
    caches.open(myCache)
    .then(cache => {
      return cache.addAll(resourcesToPrecache);
    }).then(() => self.skipWaiting())
  );
});



self.addEventListener('activate', event => {

  const cacheWhitelist = [myCache];

  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});


self.addEventListener('fetch', event => {
  let url = event.request.url;
  let referrer = event.request.referrer;
  let href = url.substring(referrer.lastIndexOf('/'));

  if(href == 'blog/data_query.php' || href == '/js/info.json'){
    event.respondWith(
      fetch(event.request)
        .then(res => {
          // Make copy/clone of response
          const resClone = res.clone();
          // Open cahce
          caches.open(myCache).then(cache => {
            // Add response to cache
            cache.put(event.request, resClone);
          });
          return res;
        })
        .catch(err => caches.match(event.request).then(res => res))
    );
  }else{

    event.respondWith(

      caches.match(event.request)
      .then(response => {
        if (response) {
          return response;
        }
  
        return fetch(event.request).then(response => {
          return caches.open(myCache).then(cache => {
            cache.put(event.request.url, response.clone());
            return response;
          });
        });
  
      }).catch(error => {
  
        if (event.request.mode == 'navigate') {
          return caches.match(event.request);
        }
  
      })
    );

  }

});
