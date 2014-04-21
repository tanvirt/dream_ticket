function display_created_groups_options() {
	respond_in("change-group");
	xmlhttp.open("GET", "display_owner_groups_options.php", true);
	xmlhttp.send();
}
var change_group_button = document.getElementById('change-group');
change_group_button.onmouseover = function() {
    var elem = document.getElementById('change-group');
	display_created_groups_options();
	change_group_button.onmouseover = null;
};

function display_groups_options() {
	respond_in("delete-group");
	xmlhttp.open("GET", "display_groups_options.php", true);
	xmlhttp.send();
}
var delete_group_button = document.getElementById('delete-group');
delete_group_button.onmouseover = function() {
	var elem = document.getElementById('delete-group');
	display_groups_options();
	delete_group_button.onmouseover = null;
};

function display_courses_options() {
	respond_in("delete-course");
	xmlhttp.open("GET", "display_courses_options.php", true);
	xmlhttp.send();
}
var delete_course_button = document.getElementById('delete-course');
delete_course_button.onmouseover = function() {
	var elem = document.getElementById('delete-course');
	display_courses_options();
	delete_course_button.onmouseover = null;
};

function display_account_options() {
	respond_in("change-account");
	xmlhttp.open("GET", "display_account_options.php", true);
	xmlhttp.send();
}
var change_account_button = document.getElementById('change-account');
change_account_button.onmouseover = function() {
	var elem = document.getElementById('change-account');
	display_account_options();
	change_account_button.onmouseover = null;
};

function delete_group(group_name) {
	if(group_name == 'None') {
		return;
	}
	if(confirm('Are you sure you want to delete '+group_name+' from your account?')) {
		respond_in("options");
		xmlhttp.open("GET", "delete_group.php?group_name="+group_name, true);
		xmlhttp.send();
	}
}

function delete_course(course_code) {
	if(course_code == 'None') {
		return;
	}
	if(confirm('Are you sure you want to delete '+course_code+' from your account?')) {
		respond_in("options");
		xmlhttp.open("GET", "delete_course.php?course_code="+course_code, true);
		xmlhttp.send();
	}
}