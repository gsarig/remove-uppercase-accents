/*
 * Remove Uppercase Accents for Wordpress
 */

(function (jQuery) {
	jQuery.extend(jQuery.expr[":"], {
		uppercase: function (elem) {
			var attr = jQuery(elem).css("text-transform");
			return (typeof attr !== "undefined" && attr === "uppercase");
		},
		smallcaps: function (elem) {
			var attr = jQuery(elem).css("font-variant");
			return (typeof attr !== "undefined" && attr === "small-caps");
		}
	});

	jQuery.extend({
		removeAcc: function (elem) {
			var text = (elem.tagName.toLowerCase() == "input") ? elem.value : elem.innerHTML;
			var accents = rua.accents;

			accents.forEach(function (item) {
				var reg = new RegExp(item.original, 'g');
				text = text.replace(reg, item.convert);
			});

			(elem.tagName.toLowerCase() == "input") ? (elem.value = text) : (elem.innerHTML = text);
		}
	});

	jQuery.fn.extend({
		removeAcc: function () {
			return this.each(function () {
				if (jQuery(this).attr('id') !== 'ship-to-different-address' && !jQuery(this).parents('#ship-to-different-address').length) {
					jQuery.removeAcc(this);
				}
			});
		}
	});

})(jQuery);

jQuery(document).ready(function ($) {
	$(':uppercase').removeAcc();
	$(document).ajaxComplete(function (event, request, settings) {
		$(':uppercase').removeAcc();
	});
});