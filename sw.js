const dynamicCache = "dynamic_v1";
const staticCache = "static_v1";
const assets = [
	"/",
	"/offline.html",
	"/reset.css",
	"/chatcha.css",
	"/images/logo_chatcha.png",
	"/images/catfoot_button.png",
	"/images/param.png",
	"/images/boredcat.png",
	"/images/businesscat.png",
	"/images/extracleancat.png",
	"/images/funnycat.png",
	"/images/hackercat.png",
	"/images/lazycat.png",
	"/images/stealthcat.png",
	"/images/supercat.png",
	"/images/unicorncat.png",
	"/fonts/AIR_Rebellion.eot",
	"/fonts/AIR_Rebellion.svg",
	"/fonts/AIR_Rebellion.ttf",
	"/fonts/AIR_Rebellion.woff",
	"/fonts/AIR_Rebellion.woff2",
	"/fonts/TurretRoadRegular.eot",
	"/fonts/TurretRoadRegular.svg",
	"/fonts/TurretRoadRegular.ttf",
	"/fonts/TurretRoadRegular.woff",
	"/fonts/TurretRoadRegular.woff2",
];

// cache static assets while installing sw
self.addEventListener("install", (evt) => {
	evt.waitUntil(
		caches.open(staticCache).then((cache) => {
			cache.addAll(assets);
		})
	);
});

// delete old cache assets
self.addEventListener("activate", (evt) => {
	evt.waitUntil(
		caches.keys().then((keys) => {
			keys.forEach((key) => {
				if (key != staticCache && key != dynamicCache) {
					caches.delete(key);
				}
			});
		})
	);
});

self.addEventListener("fetch", (evt) => {
	if (!navigator.onLine) {
		evt.respondWith(
			caches.match(evt.request).then((cacheResponse) => {
				if (evt.request.url.indexOf("index.php") > -1) {
					return caches.match("/meowroom.php") || caches.match("/offline.html");
				} else {
					return cacheResponse || caches.match("/offline.html");
				}
			})
		);
	} else {
		evt.respondWith(
			caches.match(evt.request).then((cacheResponse) => {
				if (cacheResponse) {
					// Online.php shall not be cached
					if (evt.request.url.indexOf("online.php") > -1) {
						return fetch(evt.request);
					} // Chat.php shall be cached on every fetch to ensure last version availabily
					else if (evt.request.url.indexOf("chat.php") > -1) {
						return fetch(evt.request).then((newResponse) => {
							caches.open(dynamicCache).then((cache) => cache.put(evt.request, newResponse));
							return newResponse.clone();
						});
					} // All other pages should be cached
					else {
						return cacheResponse;
					}
				} else {
					// Online.php shall never be called from cache
					if (evt.request.url.indexOf("online.php") > -1) {
						return fetch(evt.request);
					} else {
						return fetch(evt.request).then((newResponse) => {
							caches.open(dynamicCache).then((cache) => cache.put(evt.request, newResponse));
							return newResponse.clone();
						});
					}
				}
			})
		);
	}
});
