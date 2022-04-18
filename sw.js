const staticCache = "static_v1";
const assets = [
	"/",
	"/index.php",
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
				if (key != staticCache) {
					caches.delete(key);
				}
			});
		})
	);
});

self.addEventListener("fetch", (evt) => {});
