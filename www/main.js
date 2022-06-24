function hideShowSection(elem)
{

	var list_nav_button = document.getElementsByClassName('nav-button');

	for (var i = 0; i < list_nav_button.length; i++){
		list_nav_button[i].classList.remove('selected');
	}

	elem.classList.add('selected');
}

function selectDataDashboard(elem)
{
	var list_main_data = document.getElementsByClassName('button-selection-data');

	for (var i = 0; i < list_main_data.length; i++) {
		list_main_data[i].classList.remove('selected');
	}

	elem.classList.add('selected');
}

function selectTemplateImg(elem)
{
	var list_template = document.getElementsByClassName('template-img');

	for (var i = 0; i < list_template.length; i++) {
		list_template[i].classList.remove('selected');
	}

	elem.classList.add('selected');
}