=== G&M Dev Tools 🛠️ ===
Contributors: ericdowns, grainandmortar
Tags: development, debugging, tools, outline, font-size, typography, fonts, modules, acf
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Development tools for debugging and visualizing WordPress themes. Built with ❤️ by Grain & Mortar.

== Description ==

G&M Dev Tools provides a suite of development and debugging tools for WordPress theme developers. Each tool can be individually enabled or disabled through the WordPress admin interface.

= Current Tools =

**Outline Toggle 📐**
- Visualize element boundaries with colored outlines
- Three modes: Off, Divs Only, All Elements
- Keyboard shortcut: Ctrl/Cmd + Shift + O
- Persistent state using browser localStorage
- Color-coded elements by type

**Typography Inspector 📏**
- Progressive typography information with 4 detail levels
- Tags mode: Shows element tags (H1, H2, P, etc.)
- Fonts mode: Shows tags + font family names
- Full mode: Complete typography details (size, line height, weight, color)
- Example: H1 • Bembo MT Pro • 32px/120% • Bold • #333333
- Keyboard shortcut: Ctrl/Cmd + Shift + T

**Module Labels 🏷️**
- Shows module names on frontend for easy identification
- Works with ACF flexible content modules (default)
- Supports custom theme modules via configuration
- Configurable per theme - no plugin modifications needed
- Keyboard shortcut: Ctrl/Cmd + Shift + M

== Installation ==

1. Upload the `gm-dev-tools` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Tools → G&M Dev Tools to configure settings
4. Enable/disable individual tools as needed

== Module Labels Configuration ==

The Module Labels tool can be customized for any theme without modifying the plugin.

= Default Behavior =
By default, looks for ACF modules with `data-acf-module` attributes.

= Custom Configuration =
Add a configuration file to your theme root: `gm-dev-tools-config.php`

Example configuration:
```php
<?php
return array(
    'module_labels' => array(
        'selector' => '[data-module]',
        'attribute' => 'module',
        'format_prefix' => 'page_module_',
    )
);
```

This allows the plugin to work with any module naming convention.

== Usage ==

= Admin Settings =
1. Go to Tools → G&M Dev Tools in your WordPress admin
2. Check the boxes next to the tools you want to enable
3. Click "Save Changes"

= Frontend Tools =
1. Visit your website's frontend
2. Look for the gear icon (⚙️) in the bottom-right corner
3. Click to expand the tool panel
4. Click individual tool buttons to activate/deactivate them

= Keyboard Shortcuts =
- **Outline Toggle**: Ctrl/Cmd + Shift + O
- **Typography Inspector**: Ctrl/Cmd + Shift + T
- **Module Labels**: Ctrl/Cmd + Shift + M

== Frequently Asked Questions ==

= Do these tools affect my live site? =
The tools are only visible to logged-in administrators and do not affect regular site visitors.

= Can I use this with any theme? =
Yes! G&M Dev Tools works with any WordPress theme.

= How do I make Module Labels work with my custom modules? =
Add a `gm-dev-tools-config.php` file to your theme with your module selector configuration. See the Module Labels Configuration section for details.

= Will the tools slow down my site? =
No. The tools are lightweight and only load when enabled. They use vanilla JavaScript with no jQuery dependency.

= Can I add my own tools? =
Yes! The plugin is extensible. Create a new tool class extending `GM_Dev_Tool` and register it in the main plugin file.

== Screenshots ==

1. Tool panel in collapsed state showing gear icon
2. Expanded tool panel with all tools visible
3. Outline Toggle showing element boundaries
4. Typography Inspector displaying font information
5. Module Labels showing module names on frontend
6. Admin settings page for enabling/disabling tools

== Changelog ==

= 1.2.0 =
* Added theme configuration system for Module Labels tool
* Module Labels now supports custom theme configurations via gm-dev-tools-config.php
* Renamed "ACF Module Labels" to "Module Labels" for broader compatibility
* Added support for any data attribute naming convention
* Added support for class-based module selection
* Optional prefix removal for cleaner label display
* Improved documentation with configuration examples

= 1.1.0 =
* Added progressive Typography Inspector with 4 detail levels
* Renamed "Font X-Ray" to "Typography Inspector"
* Updated Typography Inspector emoji from 🔍 to 📏
* Merged font detection functionality into Typography Inspector
* Removed drop shadows from tool labels for cleaner appearance

= 1.0.2 =
* Added font weight display in Typography Inspector
* Shows weight as readable text (Thin, Light, Regular, Bold, etc.)
* Typography details now show: Element • Size/Line-height • Weight • Color

= 1.0.1 =
* Improved emoji spacing in tool buttons
* Minor CSS refinements for tool dock buttons
* Fixed tool button text alignment on mobile devices

= 1.0.0 =
* Initial release
* Outline Toggle Tool for layout debugging
* Font X-Ray Tool for typography inspection
* ACF Module Labels Tool for module identification
* Tool Dock System with collapse/expand
* Keyboard shortcuts for quick access
* Persistent state using localStorage
* GitHub Updater for automatic updates
* Admin Settings Page

== Upgrade Notice ==

= 1.2.0 =
Module Labels tool now supports custom theme configurations. No plugin modifications needed for different sites!

= 1.1.0 =
Typography Inspector now features progressive detail levels. Click to cycle through different levels of information.

= 1.0.0 =
Initial release with three powerful development tools.

== Credits ==

Built with ❤️ by [Grain & Mortar](https://grainandmortar.com)

== Support ==

For bug reports and feature requests, please use the [GitHub repository](https://github.com/grainandmortar/gm-dev-tools/issues).