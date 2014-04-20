function display_all_groups() {
	respond_in("display_response");
	xmlhttp.open("GET", "display_all_groups.php", true);
	xmlhttp.send();
}

function add_group(course_code) {
	
}

var display_button = document.getElementById('display_button');
var count = 1;

display_button.onclick = function() {
    var div = document.getElementById('display_response');
    if (div.style.display !== 'block' && count == 1) {
        div.style.display = 'block';
		display_all_groups();
		count += 1;
    }
	else if(div.style.display !== 'block') {
		div.style.display = 'block';
	}
    else {
        div.style.display = 'none';
    }
};