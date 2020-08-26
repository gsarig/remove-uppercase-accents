(function () {
	'use strict';
	const form = document.getElementById('rua_form');
	const select = document.getElementById('rua_field_mode');
	select.onchange = function () {
		form.setAttribute('data-current', this.value);
	}
	const tips = document.querySelectorAll('.rua-tips-container h3 a');
	for (const tip of tips) {
		tip.onclick = function () {
			const parent = this.closest('.rua-tips-container');
			if (parent.classList.contains('open')) {
				parent.classList.remove('open');
			} else {
				const tipContainers = document.querySelectorAll('.rua-tips-container');
				for (const container of tipContainers) {
					container.classList.remove('open');
				}
				parent.classList.add('open');
			}
		}
	}
})();