<?php
/**
 * GM Dev Tools Configuration Example
 *
 * Copy this file to your theme root and rename to: gm-dev-tools-config.php
 * Then customize the settings for your specific theme's module structure.
 *
 * @package GM_Dev_Tools
 * @version 1.2.0
 */

return array(
	/**
	 * Module Labels Tool Configuration
	 *
	 * Customize how the Module Labels tool finds and displays modules in your theme.
	 */
	'module_labels' => array(

		/**
		 * CSS selector to find modules in the DOM
		 * Examples:
		 * - '[data-module]' - Find elements with data-module attribute
		 * - '[data-acf-module]' - Find ACF flexible content modules (default)
		 * - '[data-component]' - Find elements with data-component attribute
		 * - '.module' - Find elements with class="module"
		 */
		'selector' => '[data-module]',

		/**
		 * The data attribute name (without 'data-' prefix)
		 * This is used to extract the module name from the element.
		 * Set to null if using class-based selection.
		 * Examples:
		 * - 'module' - Reads from data-module="name"
		 * - 'acf-module' - Reads from data-acf-module="name"
		 * - 'component' - Reads from data-component="name"
		 */
		'attribute' => 'module',

		/**
		 * Optional: Prefix to remove from module names when displaying
		 * This makes labels cleaner and more readable.
		 * Examples:
		 * - 'page_module_' - Turns 'page_module_home_hero' into 'home_hero'
		 * - 'component_' - Turns 'component_header' into 'header'
		 * - '' - Don't remove any prefix (default)
		 */
		'format_prefix' => 'page_module_',

		/**
		 * Optional: Additional class selectors to find modules
		 * Use this if your modules use classes instead of or in addition to data attributes.
		 * Examples:
		 * - array('.acf-module', '.flex-module')
		 * - array('.component', '.widget')
		 * - array() - No class selectors (default)
		 */
		'class_selectors' => array(),

		/**
		 * Optional: Custom JavaScript function name for formatting module names
		 * If specified, this function will be called instead of the default formatter.
		 * The function should be globally accessible (window.functionName).
		 * Example:
		 * - 'myCustomFormatter' - Calls window.myCustomFormatter(moduleName)
		 * - null - Use default formatter (default)
		 */
		'format_function' => null,

		/**
		 * Optional: Auto-detect modules from HTML comments
		 * When enabled, the tool will scan for HTML comments like <!-- Text Block -->
		 * and automatically associate them with the next sibling element.
		 * This works great for themes that don't use data attributes but have
		 * descriptive comments before each module.
		 * Examples:
		 * - true - Enable comment detection (default)
		 * - false - Disable comment detection
		 */
		'detect_comments' => true,

		/**
		 * Optional: Custom regex patterns for detecting module comments
		 * By default, the tool looks for patterns like "Text Block", "Hero Module",
		 * "page_module_text_block", etc. Add custom patterns here if your theme
		 * uses different comment formats.
		 * Examples:
		 * - array('^\\s*Module:\\s*(\\w+)\\s*$') - Matches "Module: name"
		 * - array('^\\s*Component:\\s*([\\w-]+)\\s*$') - Matches "Component: my-name"
		 * - array() - Use default patterns (default)
		 */
		'comment_patterns' => array(),
	),

	/**
	 * Future tool configurations can be added here
	 * The plugin is designed to be extensible for additional tools.
	 *
	 * Example:
	 * 'another_tool' => array(
	 *     'setting' => 'value'
	 * )
	 */
);

/**
 * Configuration Examples for Common Scenarios:
 *
 * 1. Standard ACF Modules (no configuration file needed - uses defaults)
 *
 * 2. Custom WordPress Blocks:
 *    'selector' => '[data-block]',
 *    'attribute' => 'block',
 *    'format_prefix' => 'acf/',
 *
 * 3. Elementor Sections:
 *    'selector' => '.elementor-section',
 *    'attribute' => null,
 *    'class_selectors' => array('.elementor-section', '.elementor-widget'),
 *
 * 4. Custom Page Builder:
 *    'selector' => '[data-pb-module]',
 *    'attribute' => 'pb-module',
 *    'format_prefix' => 'pb_',
 */