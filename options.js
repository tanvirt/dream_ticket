function display_created_groups_options() {
	respond_in("change_group");
	xmlhttp.open("GET", "display_owner_groups_options.php", true);
	xmlhttp.send();
}
var change_group_button = document.getElementById('change_group');
change_group_button.onmouseover = function() {
    var elem = document.getElementById('change_group');
	display_created_groups_options();
	change_group_button.onmouseover = null;
};

function display_groups_options() {
	respond_in("delete_group");
	xmlhttp.open("GET", "display_groups_options.php", true);
	xmlhttp.send();
}
var delete_group_button = document.getElementById('delete_group');
delete_group_button.onmouseover = function() {
	var elem = document.getElementById('delete_group');
	display_groups_options();
	delete_group_button.onmouseover = null;
};

function display_courses_options() {
	respond_in("delete_course");
	xmlhttp.open("GET", "display_courses_options.php", true);
	xmlhttp.send();
}
var delete_course_button = document.getElementById('delete_course');
delete_course_button.onmouseover = function() {
	var elem = document.getElementById('delete_course');
	display_courses_options();
	delete_course_button.onmouseover = null;
};

function display_account_options() {
	respond_in("change_account");
	xmlhttp.open("GET", "display_account_options.php", true);
	xmlhttp.send();
}
var change_account_button = document.getElementById('change_account');
change_account_button.onmouseover = function() {
	var elem = document.getElementById('change_account');
	display_account_options();
	change_account_button.onmouseover = null;
};