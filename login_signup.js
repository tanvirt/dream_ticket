function check_user(value) {
	if (value == "") {
		document.getElementById("username_response").innerHTML="";
		return;
	}
	respond_in("username_response");
	xmlhttp.open("GET", "get_user.php?username=" + value, true);
	xmlhttp.send();
}

function check_signup_validity(username, password1, password2, first_name, last_name) {
	respond_in("signup_response");
	xmlhttp.open("POST","signup.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("username="+username+"&password1="+password1+"&password2="+password2+"&first_name="+first_name+"&last_name="+last_name);
}

function check_login_validity(username, password) {
	respond_in("login_response");
	xmlhttp.open("POST","login.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("username="+username+"&password="+password);
}

function display_groups(course_code) {
	respond_in("groups");
	xmlhttp.open("GET", "display_groups.php?course_code=" + course_code, true);
	xmlhttp.send();
}