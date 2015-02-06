// JavaScript Document

$(':input').removeAttr('placeholder');

if (document.getElementsByTagName) {

	var inputElements = document.getElementsByTagName(“input”);

	for (i=0; inputElements[i]; i++) {

		if (inputElements[i].className && (inputElements[i].className.indexOf(“disableAutoComplete”) != -1)) {

			inputElements[i].setAttribute(“autocomplete”,”off”);

		}

	}//for

} //if