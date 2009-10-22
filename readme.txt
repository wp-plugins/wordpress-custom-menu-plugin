=== Plugin Name ===
Contributors: ClubWordpress
Donate link: 
Tags: menus
Requires at least: 1.5
Tested up to: 2.8.5
Stable tag: trunk

Very simple plugin to manage a custom navigation menu.

== Description ==

This is a very simple plugin to manage navigation menus from the admin panel in WordPress instead of having to code the template each time a menu or a menu item was added, removed or changed.

== Installation ==

1. Upload `club-wordpress-custom-menu.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php custommenu_output(); ?>` in your templates where you want the menu to be displayed
4. The menu is output as an unordered HTML list, so you just need to make sure you style it correctly

== Frequently Asked Questions ==

= Can only 1 menu be made? =

Yes.

= How is the menu output to the theme? =

As an unordered HTML list.

== Screenshots ==

1. The admin panel for the menu

== Changelog ==

= 1.0 =
* 1st submit to SVN.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`
