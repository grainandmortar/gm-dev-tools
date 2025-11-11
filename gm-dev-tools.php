<?php
/**
 * Plugin Name: G&M Dev Tools 🛠️
 * Plugin URI: https://github.com/grainandmortar/gm-dev-tools
 * Description: Development tools for debugging and visualizing WordPress themes. Includes outline mode, font x-ray, and more magical debugging goodness.
 * Version: 1.2.0
 * Author: Eric Downs - Grain & Mortar
 * Author URI: https://grainandmortar.com
 * GitHub: https://github.com/grainandmortar/gm-dev-tools
 * License: GPL v2 or later
 * Text Domain: gm-dev-tools
 * 
 * Built with ❤️ by Grain & Mortar
 * Follow us: @grainandmortar
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('GM_DEV_TOOLS_VERSION', '1.2.0');
define('GM_DEV_TOOLS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GM_DEV_TOOLS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include core files
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'includes/abstract-tool.php';
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'includes/class-environment.php';
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'includes/class-tool-manager.php';
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'includes/class-updater.php';

// Include individual tools
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'tools/outline-toggle/class-outline-toggle.php';
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'tools/font-xray/class-font-xray.php';
require_once GM_DEV_TOOLS_PLUGIN_DIR . 'tools/acf-module-labels/class-acf-module-labels.php';

/**
 * Main plugin class
 */
class GM_Dev_Tools {
    
    /**
     * Plugin instance
     */
    private static $instance = null;
    
    /**
     * Tool manager instance
     */
    private $tool_manager;
    
    /**
     * Get plugin instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->tool_manager = new GM_Tool_Manager();
        $this->register_tools();
        $this->init_hooks();
    }
    
    /**
     * Register all available tools
     */
    private function register_tools() {
        // Register Outline Toggle tool
        $this->tool_manager->register_tool(new GM_Tool_Outline_Toggle());

        // Register Typography Inspector tool (with progressive detail)
        $this->tool_manager->register_tool(new GM_Tool_Font_XRay());

        // Register ACF Module Labels tool
        $this->tool_manager->register_tool(new GM_Tool_ACF_Module_Labels());

        // Additional tools can be registered here
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Admin scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Initialize tool manager
        add_action('init', array($this->tool_manager, 'init'));
        
        // Frontend assets
        add_action('wp_enqueue_scripts', array($this->tool_manager, 'enqueue_frontend_assets'));
        
        // AJAX handlers for settings
        add_action('wp_ajax_gm_dev_tools_save_settings', array($this, 'save_settings'));
        
        // Add plugin action links
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_submenu_page(
            'tools.php',
            'G&M Dev Tools',
            'G&M Dev Tools',
            'manage_options',
            'gm-dev-tools',
            array($this, 'render_admin_page')
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if ('tools_page_gm-dev-tools' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'gm-dev-tools-admin',
            GM_DEV_TOOLS_PLUGIN_URL . 'admin/css/admin.css',
            array(),
            GM_DEV_TOOLS_VERSION
        );
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        include GM_DEV_TOOLS_PLUGIN_DIR . 'admin/settings-page.php';
    }
    
    /**
     * Save settings via AJAX
     */
    public function save_settings() {
        // Check nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'gm_dev_tools_settings')) {
            wp_die('Security check failed');
        }

        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }

        // Get enabled tools from POST data
        $enabled_tools = isset($_POST['enabled_tools']) ? array_map('sanitize_text_field', $_POST['enabled_tools']) : array();

        // Get environment setting
        $show_on = isset($_POST['show_on']) ? sanitize_text_field($_POST['show_on']) : 'local';

        // Validate show_on value
        if (!in_array($show_on, array('local', 'production', 'both'))) {
            $show_on = 'local';
        }

        // Save to options
        update_option('gm_dev_tools_enabled', $enabled_tools);
        update_option('gm_dev_tools_show_on', $show_on);

        wp_send_json_success(array('message' => 'Settings saved successfully'));
    }
    
    /**
     * Get tool manager
     */
    public function get_tool_manager() {
        return $this->tool_manager;
    }
    
    /**
     * Add action links to plugin page
     */
    public function add_action_links($links) {
        $settings_link = '<a href="' . admin_url('tools.php?page=gm-dev-tools') . '">⚙️ Settings</a>';
        array_unshift($links, $settings_link);
        
        // Add link to Grain & Mortar
        $gm_link = '<a href="https://grainandmortar.com" target="_blank" style="color: #646464;">by Grain & Mortar</a>';
        $links[] = $gm_link;
        
        return $links;
    }
}

// Initialize plugin
add_action('plugins_loaded', function() {
    GM_Dev_Tools::get_instance();

    // Initialize updater
    new GM_Dev_Tools_Updater(__FILE__);
});

// Activation hook
register_activation_hook(__FILE__, function() {
    // Set default enabled tools on first activation
    if (false === get_option('gm_dev_tools_enabled')) {
        update_option('gm_dev_tools_enabled', array('outline-toggle'));
    }

    // Set default environment setting (local only for safety)
    if (false === get_option('gm_dev_tools_show_on')) {
        update_option('gm_dev_tools_show_on', 'local');
    }
});