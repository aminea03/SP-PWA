// NO RESUBMISSON ON RELOAD
if (window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}

// Registration style function
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

// Show Registration page
function register() {
	document.querySelector(".connexion").classList.add("hide_connexion");
	document.querySelector(".index_top img").style.height = "150px";
	document.querySelector(".create_account").classList.add("show_create_account");
}

// Back to connection page
function backToConnection() {
	document.querySelector(".connexion").classList.remove("hide_connexion");
	document.querySelector(".index_top img").style = "";
	document.querySelector(".create_account").classList.remove("show_create_account");
}

// Emoticons list show
var emoticonCount = 0;
function showEmoticons() {
	if (emoticonCount === 0) {
		document.querySelector(".emoticon_list").style.display = "flex";
		emoticonCount = 1;
	} else {
		document.querySelector(".emoticon_list").style.display = "none";
		emoticonCount = 0;
	}
}

// Type emoticon on click
function typeEmoticon() {
	let emoticon = event.target.textContent;
	let msgContent = document.getElementById("chat_msg").value;
	let newContent = msgContent + emoticon;
	document.getElementById("chat_msg").value = newContent;
	showEmoticons();
	document.getElementById("chat_msg").focus();
}

// SW Register
if ("serviceWorker" in navigator) {
	navigator.serviceWorker.register("sw.js");
}
