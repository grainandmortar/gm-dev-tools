<?php
/**
 * Outline Toggle Tool
 * 
 * Provides visual element outlines for layout debugging
 * Three modes: Off, Divs only, All elements
 */

if (!defined('ABSPATH')) {
    exit;
}

class GM_Tool_Outline_Toggle extends GM_Dev_Tool {
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->id = 'outline-toggle';
        $this->name = 'Outline Toggle 📐';
        $this->description = 'See the matrix! Visual element outlines for layout debugging. Cycles through Off → Divs Only → All Elements.';
        $this->enabled_by_default = true;
    }
    
    /**
     * Enqueue tool assets
     */
    public function enqueue_assets() {
        // Enqueue CSS
        wp_enqueue_style(
            'gm-tool-outline-toggle',
            GM_DEV_TOOLS_PLUGIN_URL . 'tools/outline-toggle/assets/css/outline.css',
            array(),
            GM_DEV_TOOLS_VERSION
        );
        
        // Enqueue JS
        wp_enqueue_script(
            'gm-tool-outline-toggle',
            GM_DEV_TOOLS_PLUGIN_URL . 'tools/outline-toggle/assets/js/outline.js',
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
        <!-- Outline Toggle Button -->
        <button id="outlineToggle"
                class="gm-outline-toggle-btn">
            <span class="tool-emoji">📐</span>
            <span id="outlineToggleText">Outline Mode</span>
        </button>
        <?php
    }
}