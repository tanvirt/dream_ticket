function create_course(course_code, course_title) {
	respond_in("create_response");
	xmlhttp.open("GET", "create_course.php?course_code="+course_code"&course_title="+course_title, true);
	xmlhttp.send();
}