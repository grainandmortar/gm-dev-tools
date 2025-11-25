<?php
/**
 * ACF Module Labels Tool
 * 
 * Displays ACF module names as labels on the frontend for easy identification
 * Helps developers and clients see which modules are being used on each page
 */

if (!defined('ABSPATH')) {
    exit;
}

class GM_Tool_ACF_Module_Labels extends GM_Dev_Tool {

    /**
     * Module configuration
     */
    private $config = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->id = 'acf-module-labels';
        $this->name = 'Module Labels 🏷️';
        $this->description = 'See the building blocks! Displays module names on the frontend for easy identification. Works with ACF modules and custom theme modules.';
        $this->enabled_by_default = false;
        $this->load_theme_config();
    }

    /**
     * Load theme-specific configuration
     */
    private function load_theme_config() {
        // Check if theme has a configuration file
        $config_file = get_stylesheet_directory() . '/gm-dev-tools-config.php';

        if (file_exists($config_file)) {
            $config = include $config_file;
            if (isset($config['module_labels'])) {
                $this->config = $config['module_labels'];
            }
        }

        // Set default configuration if none exists
        if (!$this->config) {
            $this->config = array(
                'selector' => '[data-module]',
                'attribute' => 'module',
                'format_prefix' => 'page_module_',
            );
        }
    }
    
    /**
     * Enqueue tool assets
     */
    public function enqueue_assets() {
        // Enqueue CSS
        wp_enqueue_style(
            'gm-tool-acf-module-labels',
            GM_DEV_TOOLS_PLUGIN_URL . 'tools/acf-module-labels/assets/css/module-labels.css',
            array(),
            GM_DEV_TOOLS_VERSION
        );

        // Enqueue JS
        wp_enqueue_script(
            'gm-tool-acf-module-labels',
            GM_DEV_TOOLS_PLUGIN_URL . 'tools/acf-module-labels/assets/js/module-labels.js',
            array(),
            GM_DEV_TOOLS_VERSION,
            true
        );

        // Pass configuration to JavaScript (simplified - JS handles formatting now)
        wp_localize_script(
            'gm-tool-acf-module-labels',
            'gmModuleLabelsConfig',
            array(
                'selector' => $this->config['selector'],
            )
        );
    }
    
    /**
     * Render frontend output
     */
    public function render_frontend() {
        ?>
        <!-- ACF Module Labels Toggle Button -->
        <button id="acfModuleLabelsToggle"
                class="gm-acf-labels-toggle-btn">
            <span class="tool-emoji">🏷️</span>
            <span id="acfModuleLabelsToggleText">Module Labels</span>
        </button>
        <?php
    }
}