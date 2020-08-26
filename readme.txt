=== Remove Uppercase Accents ===
Contributors: gsarig
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9LNETAP9JKVAG
Tags: accents, text transform, uppercase, Greek
Requires at least: 3.0
Tested up to: 5.5
Stable tag: 1.0.2
License: GPLv2 or later

Automatically removes accented characters from text content uppercase transformed through CSS.

== Description ==

Remove Uppercase Accents is a Wordpress plugin that automatically removes accented characters (currently greek) from elements having their text content uppercase transformed through CSS ( with `{ text-transform: uppercase; }` ). Currently the script transforms only greek text, but it can be easily extended to support other languages. 

Why you would need this: For example, in greek there are accent marks that denote in which syllable you put the stress on when pronouncing a word. However, when words are written in all UPPERCASE, those accent marks are removed. This rule is not followed by the aforementioned CSS rules, as they just use the corresponding uppercase unicode character.

= Features =

* Automatically removes accented characters from text content uppercase transformed through CSS.

== Installation ==

1. Upload the Remove Uppercase Accents plugin to your website and activate it. 
2. That's it. The plugin works out of the box and no special actions needed on behalf of the site administrator. You are encouraged to go to it's Settings and check the available options.

== Frequently Asked Questions ==

= Why would I need this plugin? =

For example, in greek there are accent marks that denote in which syllable you put the stress on when pronouncing a word. However, when words are written in all UPPERCASE, those accent marks are removed. This rule is not followed by the aforementioned CSS rules on some browsers, as they just use the corresponding uppercase unicode character.

= I use "text-transform:uppercase" in greek text but I don't see any accents =

If you use Firefox or a Chromium-based browser like Chrome, the new Edge, Opera etc., and you have set the site language to Greek, accents should be handled correctly. The problem appears on Safari and on older browsers like the Internet Explorer and everywhere if you have a site with mixed content and you don't want to set Greek as the site's language.

= I use Firefox/Chrome/the new Edge but the problem appears there too. =

Then your site's language isn't set to Greek. If your content is in Greek, you should set it.

== Screenshots ==

1. Greek text without the plugin
2. Greek text after activating the plugin
3. The plugin's control panel

== Changelog ==

= 1.0 =
Major update with many an options panel and new features:
* Added a pure JavaScript version of the script, to ditch jQuery dependency.
* The JS script allows you to limit the replacement on specific CSS selectors.
* Added option to do the replacement server-side, using PHP and WordPress filters.
* Added the remove_greek_accents() function, which can be used anywhere in your theme.

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