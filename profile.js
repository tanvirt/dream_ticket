function display_courses() {
	respond_in("course_response");
	xmlhttp.open("GET", "user_courses.php", true);
	xmlhttp.send();
}

function display_groups() {
	respond_in("group_response");
	xmlhttp.open("GET", "display_groups.php", true);
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
var count2 = 1

group_button.onclick = function() {
    var div = document.getElementById('group_response');
    if (div.style.display !== 'block' && count2 == 1) {
        div.style.display = 'block';
		display_groups();
		count2 += 1;
    }
	else if(div.style.display !== 'block') {
		div.style.display = 'block';
	}
    else {
        div.style.display = 'none';
    }
};