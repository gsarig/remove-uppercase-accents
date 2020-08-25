(function () {
	'use strict';
	const form = document.getElementById('rua_form');
	const select = document.getElementById('rua_field_mode');
	select.onchange = function () {
		form.setAttribute('data-current', this.value);
	}
})();