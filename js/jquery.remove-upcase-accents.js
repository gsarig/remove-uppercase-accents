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

			text = text.replace(/ΆΙ/g, "ΑΪ");
			text = text.replace(/ΆΥ/g, "ΑΫ");
			text = text.replace(/ΈΙ/g, "ΕΪ");
			text = text.replace(/ΌΙ/g, "ΟΪ");
			text = text.replace(/ΈΥ/g, "ΕΫ");
			text = text.replace(/ΌΥ/g, "ΟΫ");
			text = text.replace(/άι/g, "αϊ");
			text = text.replace(/έι/g, "εϊ");
			text = text.replace(/Άυ/g, "αϋ");
			text = text.replace(/άυ/g, "αϋ");
			text = text.replace(/όι/g, "οϊ");
			text = text.replace(/Έυ/g, "εϋ");
			text = text.replace(/έυ/g, "εϋ");
			text = text.replace(/όυ/g, "οϋ");
			text = text.replace(/Όυ/g, "οϋ");
			text = text.replace(/Ά/g, "Α");
			text = text.replace(/ά/g, "α");
			text = text.replace(/Έ/g, "Ε");
			text = text.replace(/έ/g, "ε");
			text = text.replace(/Ή/g, "Η");
			text = text.replace(/ή/g, "η");
			text = text.replace(/Ί/g, "Ι");
			text = text.replace(/Ϊ/g, "Ι");
			text = text.replace(/ί/g, "ι");
			// text = text.replace(/ϊ/g, "ι");
			text = text.replace(/ΐ/g, "ϊ");
			text = text.replace(/Ό/g, "Ο");
			text = text.replace(/ό/g, "ο");
			text = text.replace(/Ύ/g, "Υ");
			// text = text.replace(/Ϋ/g, "Υ");
			text = text.replace(/ύ/g, "υ");
			// text = text.replace(/ϋ/g, "υ");
			text = text.replace(/ΰ/g, "ϋ");
			text = text.replace(/Ώ/g, "Ω");
			text = text.replace(/ώ/g, "ω");

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