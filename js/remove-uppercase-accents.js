/*
 * Remove Uppercase Accents for Wordpress
 */
(function () {
	'use strict';

	window.addEventListener('DOMContentLoaded', function () {
		removeUppercaseAccents();
	});

	ajaxLoaded(removeUppercaseAccents);

	// Remove the uppercase accents.
	function removeUppercaseAccents() {
		const accents = rua.accents;
		for (const entry of getSelectorsList()) {
			let text = (entry.tagName && entry.tagName.toLowerCase() === 'input') ? entry.value : entry.innerHTML;
			accents.forEach(function (item) {
				const reg = new RegExp(item.original, 'g');
				text = text.replace(reg, item.convert);
			});
			entry.innerHTML = text;
		}
	}

	// Get the selectors' list.
	function getSelectorsList() {
		const cssProp = 'text-transform';
		const cssValue = 'uppercase';
		const manuallySetSelectors = rua.selectors;
		const action = rua.selAction;
		let selectors = findUppercaseSelectors();

		if ('exclude' === action && false === manuallySetSelectors.isEmpty()) {
			selectors = withoutExcludedSelectors(manuallySetSelectors);
		} else if (false === manuallySetSelectors.isEmpty()) {
			selectors = manuallySetSelectors;
		}

		const selectorsArr = document.querySelectorAll(selectors);
		const l = selectorsArr.length;

		let i, results = [];
		for (i = 0; i < l; i++) {
			// Test whether the element is really text-transform:uppercase;
			if (window.getComputedStyle(selectorsArr[i], null).getPropertyValue(cssProp) === cssValue) {
				results.push(selectorsArr[i]);
			}
		}
		return results;
	}

	// Exclude specific selectors
	function withoutExcludedSelectors(manuallySet) {
		const excludesArr = manuallySet.split(',');
		let withoutExcludes = findUppercaseSelectors().split(',').map(function (item) {
			return item.trim();
		});
		for (const selector of excludesArr) {
			const trimmed = selector.trim();
			if (withoutExcludes.includes(trimmed)) {
				withoutExcludes = withoutExcludes.filter(function (e) {
					return e !== trimmed;
				});
			}
		}
		return withoutExcludes.join(',');
	}

	// Find all CSS selectors that use text-transform:uppercase.
	function findUppercaseSelectors() {
		const loc = new URL(window.location, location);
		let variations = ['[style*="text-transform:uppercase"],[style*="text-transform: uppercase"]'];
		const searchFor = /\btext-transform:\s*uppercase;/;
		const styles = document.styleSheets;
		let i, j, l, rules, rule;

		for (i = 0; i < styles.length; i++) {
			const url = new URL(styles[i].href, location);
			if (url.origin === loc.origin) {
				rules = styles[i].cssRules;
				l = rules.length;
				for (j = 0; j < l; j++) {
					rule = rules[j];
					if (searchFor.test(rule.cssText)) {
						variations.push(rule.selectorText);
					}
				}
			}
		}
		let selectors = variations.filter(function (el) { // Clear empty and undefined.
			return el != null;
		});
		return selectors.join(',');
	}

	// Detect when all ajax calls are finished.
	function ajaxLoaded(callback) {
		const send = XMLHttpRequest.prototype.send
		XMLHttpRequest.prototype.send = function () {
			this.addEventListener('load', function () {
				callback();
			})
			return send.apply(this, arguments);
		}
	}

	// Test if a string is empty or contain only blank space.
	String.prototype.isEmpty = function () {
		return (this.length === 0 || !this.trim());
	};
})();