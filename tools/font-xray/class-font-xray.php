<?php
/**
 * Font X-Ray Tool
 *
 * Visualizes font sizes across the page with overlays and color coding
 */

if (!defined('ABSPATH')) {
    exit;
}

class GM_Tool_Font_XRay extends GM_Dev_Tool {

    /**
     * Constructor
     */
    public function __construct() {
        $this->id = 'font-xray';
        $this->name = 'Typography Inspector 📏';
        $this->description = 'Progressive typography information! Click to cycle through: Tags → Fonts → Full details. Shows element tags, font families, sizes, weights, and colors.';
        $this->enabled_by_default = false;
        $this->coming_soon = false; // Tool is now active!
    }

    /**
     * Enqueue tool assets
     */
    public function enqueue_assets() {
        // Enqueue CSS
        wp_enqueue_style(
            'gm-tool-font-xray',
            GM_DEV_TOOLS_PLUGIN_URL . 'tools/font-xray/assets/css/font-xray.css',
            array(),
            GM_DEV_TOOLS_VERSION
        );

        // Enqueue JS
        wp_enqueue_script(
            'gm-tool-font-xray',
            GM_DEV_TOOLS_PLUGIN_URL . 'tools/font-xray/assets/js/font-xray.js',
            array(),
            GM_DEV_TOOLS_VERSION,
            true
        );

        // Pass settings to JS
        wp_localize_script('gm-tool-font-xray', 'gmFontXRaySettings', array(
            'pluginUrl' => GM_DEV_TOOLS_PLUGIN_URL,
            'version' => GM_DEV_TOOLS_VERSION,
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gm_font_xray_nonce')
        ));
    }

    /**
     * Render frontend output
     */
    public function render_frontend() {
        // The JavaScript will create the toggle button dynamically
        // No PHP output needed since button is created in JS
    }
}