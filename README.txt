=== PCES Homepage ===
Contributors: PCES Inc.
Tags: shortcodes, homepage, bootstrap, custom
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0
License: GPL v2 or later

Custom shortcodes for PCES homepage redesign with Bootstrap and custom styling.

== Description ==

This plugin provides custom shortcodes for the PCES homepage redesign project. It includes:

* Hero section shortcode [pces_hero]
* Services section shortcode [pces_services] 
* Bootstrap 5.3.0 integration
* Custom CSS styling matching Figma design
* Mobile-responsive design
* Font Awesome icons

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/pces-homepage/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the shortcodes in your pages or posts

== Available Shortcodes ==

* `[pces_hero]` - Displays the hero section with company name and tagline
* `[pces_services]` - Displays the services grid section

== Updating Content ==

To update content, edit the PHP arrays in the shortcode functions:

1. Open `pces-homepage.php`
2. Find the shortcode function you want to modify
3. Edit the content arrays (services, hero text, etc.)
4. Save the file

== Changelog ==

= 1.0 =
* Initial release
* Hero section shortcode
* Services section shortcode
* Bootstrap integration
* Custom CSS styling