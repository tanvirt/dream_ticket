function display_created_groups_options() {
	respond_in("change_group");
	xmlhttp.open("GET", "display_owner_groups_options.php", true);
	xmlhttp.send();
}

function display_groups_options() {
	respond_in("delete_group");
	xmlhttp.open("GET", "display_groups_options.php", true);
	xmlhttp.send();
}

function display_courses_options() {
	respond_in("delete_course");
	xmlhttp.open("GET", "display_courses_options.php", true);
	xmlhttp.send();
}

function display_account_options() {
	respond_in("change_account");
	xmlhttp.open("GET", "display_account_options.php", true);
	xmlhttp.send();
}