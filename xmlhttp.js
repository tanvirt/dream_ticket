var xmlhttp = XMLHttpRequestObject();

function XMLHttpRequestObject() {
	if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	else {	// code for IE6, IE5c
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function respond_in(id) {
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
}