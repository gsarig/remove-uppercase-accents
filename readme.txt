=== Remove Uppercase Accents ===
Contributors: gsarig
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9LNETAP9JKVAG
Tags: accents, text transform, uppercase, Greek
Requires at least: 3.0
Tested up to: 5.4
Stable tag: 0.5.1
License: GPLv2 or later

Automatically removes accented characters from text content uppercase transformed through CSS.

== Description ==

Remove Uppercase Accents is a Wordpress plugin that automatically removes accented characters (currently greek) from elements having their text content uppercase transformed through CSS ( with `{ text-transform: uppercase; }` ). Currently the script transforms only greek text, but it can be easily extended to support other languages. 

Why you would need this: For example, in greek there are accent marks that denote in which syllable you put the stress on when pronnouncing a word. However, when words are written in all UPPERCASE, those accent marks are removed. This rule is not followed by the aforementioned CSS rules, as they just use the corresponding uppercase unicode character.

The plugin is based on [jQuery Remove Uppercase Accents for Drupal 7] [drupal plugin] which, in turn, is based on a JS script released under GPL license [on github].

[drupal plugin]: http://drupal.org/project/remove_upcase_accents "jQuery Remove Uppercase Accents for Drupal 7"
[on github]: https://github.com/tdoumas/jquery-remove-upcase-accents

= Features =

* Automatically removes accented characters from text content uppercase transformed through CSS.

== Installation ==

1. Upload the Remove Uppercase Accents plugin to your website and activate it. 
1. That's it. The plugin works out of the box and no special actions needed on behalf of the site administrator. 

== Frequently Asked Questions ==

= Why would I need this? =

For example, in greek there are accent marks that denote in which syllable you put the stress on when pronnouncing a word. However, when words are written in all UPPERCASE, those accent marks are removed. This rule is not followed by the aforementioned CSS rules, as they just use the corresponding uppercase unicode character.

= I use "text-transform:uppercase" in greek text but I don't see any accents =

Then you are probably checking the page with Firefox, which at the moment is the only browser properly supporting greek accents. Try viewing the same page with Chrome, Internet Explorer, Safari or Opera and you will notice the difference. 

== Screenshots ==

1. Greek text without the plugin
2. Greek text after activating the plugin

== Changelog ==

= 0.5.2 =
Fixed a bug with WooCommerce and "Ship to different address" option on Checkout page.

= 0.5 =
* Added support for diaereses in diphthongs in Greek uppercase letters

= 0.4 =
* Properly enqueue the plugin, including the jQuery dependency

= 0.3 =
* Fixed plugin's version number

= 0.2 =
* Updated description

= 0.1 =
* First release!

== Upgrade Notice ==

= 0.3 =
* Just a minor fix in order for the plugin to display the proper version number

= 0.2 =
There are no changes on the plugin's code, just some editing of its description at the Wordpress repository.