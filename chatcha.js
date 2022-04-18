// NO RESUBMISSON ON RELOAD
if (window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}

document.addEventListener("click", function () {
	$radios = document.querySelectorAll("input[type='radio']");
	$radios.forEach((element) => {
		if (element.checked == true) {
			element.parentElement.querySelector("img").classList.add("cat_type_checked");
		} else {
			element.parentElement.querySelector("img").classList.remove("cat_type_checked");
		}
	});
});

function register() {
	document.querySelector(".connexion").classList.add("hide_connexion");
	document.querySelector(".index_top img").style.height = "150px";
	document.querySelector(".create_account").classList.add("show_create_account");
}

function backToConnection() {
	document.querySelector(".connexion").classList.remove("hide_connexion");
	document.querySelector(".index_top img").style = "";
	document.querySelector(".create_account").classList.remove("show_create_account");
}

// SW Register
if ("serviceWorker" in navigator) {
	navigator.serviceWorker.register("sw.js");
}
