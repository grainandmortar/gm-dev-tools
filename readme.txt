=== G&M Dev Tools 🛠️ ===
Contributors: ericdowns, grainandmortar
Tags: development, debugging, tools, outline, font-size, typography, fonts
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.1.0
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

**ACF Module Labels 🏷️**
- Shows ACF flexible content module names on frontend
- Helps identify which modules are being used
- Keyboard shortcut: Ctrl/Cmd + Shift + M

== Installation ==

1. Upload the `gm-dev-tools` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Tools → G&M Dev Tools to configure settings
4. Enable/disable individual tools as needed

== Usage ==

= Admin Settings =
1. Go to Tools → G&M Dev Tools in your WordPress admin
2. Check the boxes next to the tools you want to enable
3. Click "Save Changes"

= Outline Toggle Tool =
When enabled, a floating button appears in the bottom-right corner of your site:
- Click the button to cycle through outline modes
- Or use the keyboard shortcut: Ctrl/Cmd + Shift + O
- Modes cycle through: Off → Divs Only → All Elements → Off

== Development ==

This plugin uses a modular architecture where each tool is self-contained. To add a new tool:

1. Create a new folder in `/tools/your-tool-name/`
2. Create a class file extending `GM_Dev_Tool`
3. Register your tool in the main plugin file
4. Add any assets (CSS/JS) in the tool's assets folder

== Important Notes ==

* These tools are for development only
* Remember to disable all tools before deploying to production
* Tools are only visible on the frontend when enabled
* Some tools use localStorage to persist their state

== Changelog ==

= 1.1.0 =
* Enhanced Typography Inspector with progressive detail levels
* Added font family detection to Typography Inspector
* Now cycles through: Tags → Fonts → Full details
* Removed drop shadows from tool labels for cleaner appearance
* Simplified from two tools to one unified tool

= 1.0.2 =
* Added font weight display to Typography Inspector
* Shows weight as readable text (Regular, Bold, etc.)

= 1.0.1 =
* Improved emoji spacing in tool buttons
* Minor CSS refinements
* Fixed mobile alignment issues

= 1.0.0 =
* Initial release
* Outline Toggle tool
* Font X-Ray (Typography Inspector)
* ACF Module Labels
* Modular tool architecture
* Admin settings interface

== Frequently Asked Questions ==

= Can I use this in production? =
No, this plugin is intended for development environments only. Always disable all tools before deploying to production.

= How do I add a new tool? =
Follow the modular architecture pattern. Create a new tool class extending GM_Dev_Tool and register it in the main plugin file.

= Why isn't the outline toggle showing? =
Make sure the tool is enabled in Tools → G&M Dev Tools settings.

= Can I customize the keyboard shortcuts? =
Not in the current version, but this feature may be added in future updates.

== Credits ==

Built with ❤️ by Grain & Mortar
- Website: https://grainandmortar.com
- Instagram: @grainandmortar
- Author: Eric Downs

We're a digital design and development studio that crafts thoughtful web experiences. 🌾