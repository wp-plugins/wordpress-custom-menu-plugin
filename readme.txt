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