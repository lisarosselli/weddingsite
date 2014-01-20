/**
 *	eandlvalidation.js
 *	
 *	some initial form validation here
 */

var userName = null;
var userEmail = null;
var userCode = null;
var userEntree = null;
var serverResponse = null;

window.onload = function() {
	document.getElementById("submit").onclick = validateForm;
	document.getElementById("regret").onclick = validateRegret;
	document.getElementById("whoops").onclick = hideConfirm;
	document.getElementById("yeahisuck").onclick = submitRegretsTable;
}

function validateForm() {
	console.log("validateForm");

	userName = document.getElementById("username");
	userEmail = document.getElementById("email");
	userCode = document.getElementById("code");
	entreeBlurb = document.getElementById("entreeBlurb");

	var isNameValid = validateName(userName.value);
	var isEmailValid = validateEmail(userEmail.value);
	var isCodeValid = validateCode(userCode.value);
	var entreeValid = validateRadioBtns();

	if (!isNameValid) {
		userName.className += " redAlert";
	} else {
		userName.className = "text";
	}

	if (!isEmailValid) {
		userEmail.className += " redAlert";
	} else {
		userEmail.className = "text";
	}

	if (!isCodeValid) {
		userCode.className += " redAlert";
	} else {
		userCode.className = "text";
	}

	if (!entreeValid) {
		entreeBlurb.className += " redAlertText";
	} else {
		entreeBlurb.className = "12u";
	}

	if (isNameValid && isEmailValid && isCodeValid && entreeValid) {
		doServerCheck();
	}
}

function validateName( value ) {
	var nameRegExp = new RegExp("^[a-z A-Z-]+$");
	var nameValidation = nameRegExp.test(value);
	var subNames = value.split(" ");

	if (subNames.length != 2) {
		return 0;
	}

	if (nameValidation) {
		return 1;
	} 

	return 0;
}

function validateEmail( value ) {
	var emailRegExp = /\S+@\S+\.\S{3}/;
	var emailValidation = emailRegExp.test(value);

	if (emailValidation) {
		return 1;
	}

	return 0;
}

function validateCode( value ) {
	if (value == "" || value == null) {
		return 0;
	}

	return 1;
}

function validateRadioBtns() {
	var radio_buttons = $("input[name='entree']");

	if(radio_buttons.filter(':checked').length == 0){
		return 0;
	} 
	
	userEntree = $("input[name='entree']:checked").attr('value')
	return radio_buttons.val();
}

function submitBtnFeedback() {
	// Let user know something is happening
	var submitBtn = document.getElementById("submit");
	submitBtn.value = "RSVPing...";
	submitBtn.className += " dialBack";
}

function regretsBtnFeedback() {
	// Let user know something is happening
	var submitBtn = document.getElementById("yeahisuck");
	submitBtn.value = "Saving...";
	submitBtn.className += " dialBack";
}
 
function doServerCheck() {
	console.log("doServerCheck");

	submitBtnFeedback();

	var xhr = new XMLHttpRequest;
	xhr.onreadystatechange = ensureReadiness;
	var t = this;
	console.log("t="+t);

	function ensureReadiness()
	{
		if (xhr.readyState < 4)
		{
			return;
		}

		if (xhr.status != 200)
		{
			return;
		}

		if (xhr.readyState === 4)
		{
			console.log("success");
			console.log(xhr);
			var parsedObject = JSON.parse(xhr.response);
			console.log(parsedObject);
			t.serverResponse = parsedObject;
			serverCallback();
		}
	}

	var data = "userCode="+userCode.value+"&userName="+userName.value+"&userEmail="+userEmail.value+"&userEntree="+userEntree;
	xhr.open('GET', "includes/validateCode.php?"+data, true);
	xhr.send();
}

function serverCallback() {
	console.log("serverCallback");
	var userFormContainer = document.getElementById("userFormContainer");
	var newMessage = serverResponse.responseString;
	userFormContainer.innerHTML = newMessage;
}

function hideConfirm() {
	console.log("hideConfirm");
	confirm = document.getElementById("lean_overlay");
	confirm.className = "hide";
}

function showConfirm() {
	console.log("showConfirm");
	confirm = document.getElementById("lean_overlay");
	confirm.className = "show";
}

function validateRegret() {
	console.log("validateRegret");

	userName = document.getElementById("username");
	userEmail = document.getElementById("email");
	userCode = document.getElementById("code");
	entreeBlurb = document.getElementById("entreeBlurb");

	var isNameValid = validateName(userName.value);
	var isEmailValid = validateEmail(userEmail.value);
	var isCodeValid = validateCode(userCode.value);

	if (!isNameValid) {
		userName.className += " redAlert";
	} else {
		userName.className = "text";
	}

	if (!isEmailValid) {
		userEmail.className += " redAlert";
	} else {
		userEmail.className = "text";
	}

	if (!isCodeValid) {
		userCode.className += " redAlert";
	} else {
		userCode.className = "text";
	}

	entreeBlurb.className = "12u";

	if (isNameValid && isEmailValid && isCodeValid) {
		showConfirm();
	}
}

function submitRegretsTable() {
	console.log("submitRegretsTable");

	regretsBtnFeedback();

	var xhr = new XMLHttpRequest;
	xhr.onreadystatechange = ensureReadiness;
	var t = window;
	console.log("t="+t);

	function ensureReadiness()
	{
		if (xhr.readyState < 4)
		{
			return;
		}

		if (xhr.status != 200)
		{
			return;
		}

		if (xhr.readyState === 4)
		{
			console.log("success");
			var parsedObject = JSON.parse(xhr.response);
			console.log(xhr);
			console.log(parsedObject);
			t.serverResponse = parsedObject;
			regretsCallback();
		}
	}

	var data = "userCode="+userCode.value+"&userName="+userName.value+"&userEmail="+userEmail.value;
	xhr.open('GET', "includes/saveRegret.php?"+data, true);
	xhr.send();
}

function regretsCallback() {
	console.log("regretsCallback");

	hideConfirm();

	var userFormContainer = document.getElementById("userFormContainer");
	var newMessage = serverResponse.responseString;
	userFormContainer.innerHTML = newMessage;
}



