function swapClass(swapObject, swapClass) {
	if (swapObject) {
		swapObject.className = swapClass;
	}
}

function ajaxData(id, file, query) {
	if (query == "") {
		document.getElementById(id).innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(id).innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", file + "?query=" + query, true);
	xmlhttp.send();
}
