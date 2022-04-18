const staticCache = "static_v1";
const assets = ["/", "/index.php", "/reset.css", "/chatcha.css", "/images/logo_chatcha.png"];

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
				if (key != staticCache) {
					caches.delete(key);
				}
			});
		})
	);
});

self.addEventListener("fetch", (evt) => {});
