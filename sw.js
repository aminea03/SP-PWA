const dynamicCache = "dynamic_v1";
const staticCache = "static_v1";
const assets = [
	"/",
	"/reset.css",
	"/chatcha.css",
	"/images/logo_chatcha.png",
	"/images/catfoot_button.png",
	"/images/param.png",
	"/images/disconnect.png",
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
	/* evt.respondWith(
		caches.match(evt.request).then((cacheResponse) => {
			if (!navigator.onLine) {
				return cacheResponse;
			} else {
				return fetch(evt.request)
					.then(function (response) {
						let responseClone = response.clone();
						caches.open(dynamicCache).then(function (cache) {
							cache.put(evt.request, responseClone);
						});
						return cacheResponse;
					})
					.catch(function () {
						return caches.match("/sw-test/gallery/myLittleVader.jpg");
					});
			}
		})
	); */
});
