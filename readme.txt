=== Editor Cleanup For Elementor: clean up and solve plugin conflicts with the Elementor editor ===
Contributors: giuse
Requires at least: 4.6
Tested up to: 6.5
Stable tag: 0.0.6
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags:  cleanup, elementor, performance, debugging, conflicts


FDP add-on to clean up the editor of Elementor. The Elementor editor will be faster and without conflicts with other plugins.


== Description ==

Editor Cleanup For Elementor is an add-on of <a href="https://wordpress.org/plugins/freesoul-deactivate-plugins/" target="_blank">Freesoul Deactivate Plugins</a> to clean up the editor of <a href="https://wordpress.org/plugins/elementor/" target="_blank">Elementor</a>.

It will not only clean up the assets of other plugins, their PHP code will not run either.

The Elementor editor will be faster and without conflicts with other plugins.

Both Freesoul Deactivate Plugins and Elementor must be installed and active, in another case this plugin will not run.

== How to clean up the Elementor editor ==
* Install and activate Freesoul Deactivate Plugins if not active yet
* Install and activate Elementor if not active yet
* Install and activate Editor Cleanup For Elementor
* Go to Elementor => Editor Cleanup
* Click on "Outer editor cleanup" to disable plugins that the outer editor does't need (usually no plugin needed)
* Click on "Inner editor cleanup" to disable plugins that the inner editor does't need (the inner editor is like the page on frontend, but loaded inside the Elementor editor)
* Click on "Editor loading cleanup" to disable the plugins that are called during the loading of the editor (usually no plugin needed, disabling plugins here can solve conflicts with other plugins)


== Similar add-ons to clean up ==
* <a href="https://wordpress.org/plugins/editor-cleanup-for-oxygen/">Editor Cleanup For Oxygen</a>
* <a href="https://wordpress.org/plugins/editor-cleanup-for-avada/">Editor Cleanup For Avada</a>
* <a href="https://wordpress.org/plugins/editor-cleanup-for-wpbakery/">Editor Cleanup For WPBakery</a>
* <a href="https://wordpress.org/plugins/editor-cleanup-for-divi-builder/">Editor Cleanup For Divi Builder</a>
* <a href="https://wordpress.org/plugins/editor-cleanup-for-flatsome/">Editor Cleanup For Flatsome</a>

== Help ==
For any question or if something doesn't work, don't hesitate to open a thread on the <a href="https://wordpress.org/support/plugin/editor-cleanup-for-elementor/">support forum</a>.



== Changelog ==

= 0.0.6 =
*Fix: Editor loading cleanup not working if FDP PRO is not active

= 0.0.5 =
*Fix: Settings not saving (need FDP v. 2.1.7)

= 0.0.4 =
*Fix: Fatal error in the plugin settings page

= 0.0.3 =
*Added: warning in the plugins page if Freesoul Deactivate Pluugins and/or Elementor are not active

= 0.0.2 =
*Removed: animation of the gear below the button Editor Loading Cleanup in the settings page

= 0.0.1 =
*Initial release


== Screenshots ==

1. How disable plugins in the editor of Elementor
