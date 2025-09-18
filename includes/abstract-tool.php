<?php
/**
 * Abstract base class for all dev tools
 */

if (!defined('ABSPATH')) {
    exit;
}

abstract class GM_Dev_Tool {
    
    /**
     * Tool ID (unique identifier)
     */
    protected $id = '';
    
    /**
     * Tool name (display name)
     */
    protected $name = '';
    
    /**
     * Tool description
     */
    protected $description = '';
    
    /**
     * Whether tool is enabled by default
     */
    protected $enabled_by_default = false;
    
    /**
     * Whether tool is coming soon (not yet implemented)
     */
    protected $coming_soon = false;
    
    /**
     * Get tool ID
     */
    public function get_id() {
        return $this->id;
    }
    
    /**
     * Get tool name
     */
    public function get_name() {
        return $this->name;
    }
    
    /**
     * Get tool description
     */
    public function get_description() {
        return $this->description;
    }
    
    /**
     * Check if enabled by default
     */
    public function is_enabled_by_default() {
        return $this->enabled_by_default;
    }
    
    /**
     * Check if coming soon
     */
    public function is_coming_soon() {
        return $this->coming_soon;
    }
    
    /**
     * Check if tool is currently enabled
     */
    public function is_enabled() {
        $enabled_tools = get_option('gm_dev_tools_enabled', array());
        return in_array($this->id, $enabled_tools);
    }
    
    /**
     * Initialize the tool (called when tool is enabled)
     */
    public function init() {
        if (!$this->is_enabled() || $this->is_coming_soon()) {
            return;
        }
        
        // Enqueue assets
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        
        // Add any frontend output
        add_action('wp_footer', array($this, 'render_frontend'), 999);
    }
    
    /**
     * Enqueue tool assets (override in child classes)
     */
    public function enqueue_assets() {
        // Override in child classes
    }
    
    /**
     * Render frontend output (override in child classes)
     */
    public function render_frontend() {
        // Override in child classes
    }
    
    /**
     * Get tool settings (override in child classes for tool-specific settings)
     */
    public function get_settings() {
        return array();
    }
    
    /**
     * Render tool settings in admin (override in child classes)
     */
    public function render_settings() {
        // Override in child classes
    }
}