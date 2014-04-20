function create_course(course_code, title) {
	respond_in("create_response");
	xmlhttp.open("GET", "create_course.php?course_code="+course_code+"&title="+title, true);
	xmlhttp.send();
}

function add_course(course_code) {
	respond_in("add_response");
	xmlhttp.open("GET", "add_course.php?course_code="+course_code, true);
	xmlhttp.send();
}

function display_all_courses() {
	respond_in("display_response");
	xmlhttp.open("GET", "display_all_courses.php", true);
	xmlhttp.send();
}

var display_button = document.getElementById('display_button');

display_button.onclick = function() {
	document.getElementById('create_response').style.display='none'; 
	document.getElementById('add_response').style.display='none';
    var div = document.getElementById('display_response');
    if (div.style.display !== 'block') {
        div.style.display = 'block';
		display_all_courses();
    }
    else {
        div.style.display = 'none';
    }
};