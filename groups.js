function create_group(course_code, group_name, description) {
	respond_in("create_response");
	xmlhttp.open("GET", "create_group.php?course_code="+course_code+"&group_name="+group_name+"&description="+description, true);
	xmlhttp.send();
}

function add_group(course_code, group_name) {
	respond_in("add_response");
	xmlhttp.open("GET", "add_group.php?course_code="+course_code+"&group_name="+group_name, true);
	xmlhttp.send();
}

function display_all_groups() {
	respond_in("display_response");
	xmlhttp.open("GET", "display_all_groups.php", true);
	xmlhttp.send();
}

var display_button = document.getElementById('display_button');

display_button.onclick = function() {
	document.getElementById('create_response').style.display='none'; 
	document.getElementById('add_response').style.display='none';
    var div = document.getElementById('display_response');
    if (div.style.display !== 'block') {
        div.style.display = 'block';
		display_all_groups();
    }
    else {
        div.style.display = 'none';
    }
};