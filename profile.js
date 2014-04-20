function display_courses() {
	respond_in("course_response");
	xmlhttp.open("GET", "display_courses.php", true);
	xmlhttp.send();
}

function display_groups(course_code) {
	respond_in("group_response");
	xmlhttp.open("GET", "display_groups.php?course_code="+course_code, true);
	xmlhttp.send();
}

var course_button = document.getElementById('course_button');
var count1 = 1;

course_button.onclick = function() {
    var div = document.getElementById('course_response');
    if (div.style.display !== 'block' && count1 === 1) {
        div.style.display = 'block';
		display_courses();
		count1 += 1;
    }
	else if(div.style.display !== 'block') {
		div.style.display = 'block';
	}
    else {
        div.style.display = 'none';
    }
};

var group_button = document.getElementById('group_button');

function change_group_button(course_code) {
	var group_button = document.getElementById('group_button');
	group_button.value = 'My Groups | ' + course_code;
}

group_button.onclick = function() {
    var div = document.getElementById('group_response');
    if (div.style.display !== 'none') {
        div.style.display = 'none';
    }
    else {
        div.style.display = 'block';
    }
};