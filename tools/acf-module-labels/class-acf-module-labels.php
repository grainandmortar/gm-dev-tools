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
     * Constructor
     */
    public function __construct() {
        $this->id = 'acf-module-labels';
        $this->name = 'ACF Module Labels 🏷️';
        $this->description = 'See the building blocks! Displays ACF module names on the frontend for easy identification. Perfect for developers and clients.';
        $this->enabled_by_default = false;
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