=== Plugin Name ===
Contributors: mrfr0g
Donate link: http://michaelcamden.me
Tags: translate, google translate, instant translate, language
Requires at least: 3.0.1
Tested up to: 3.0.1
Stable tag: 1.2

Instant Translate instantly translates text that you specify in to any language supported by Google Translate.

== Description ==

Instant Translate Widget is my first attempt at a Word Press widget. It lives in the Widget menu, and uses jQuery and Google Translate to instantly translate text on my blog. It uses jQuery’s selector to determine what text you want to translate. For example, the selector I use is, “.post h2,.entry > *:not(pre), .translate”. Which translates all of my titles, and entry text and not any thing within PRE tags. This lets me keep my code in English, but translate the explanation. 

== Installation ==

1. Extract the plugin using WinZip or similar program.
2. Upload the folder, 'Instant Translate' in to the '/wp-content/plugins/' directory.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Click Appearance -> Widgets
5. Move the Instant Translate Widget to your side bar.


== Frequently Asked Questions ==

= What languages are supported? =

As many as Google Translate supports. Please see, http://code.google.com/apis/ajaxlanguage/documentation/#SupportedLanguages for more information.

== Screenshots ==

1. This shows the blog in it's normal state.
2. Clicking on the drop down, shows you the many languages this supports.
3. I've clicked on, FINNISH, and the text updated as soon as I clicked.

== Changelog ==

= 1.2 =
Added text transition effect framework, and one effect fadeout/in.

= 1.1 =
Fixed bug in admin section.

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.2 =
1.2 is an optional upgrade version. It includes a text transition framework when the text is translated. Currently only supports a fade out of current text, and fade in of the new text.

= 1.1 =
Please upgrade to 1.1 to resolve a bug that was being caused in the admin section.

= 1.0 =
None.
