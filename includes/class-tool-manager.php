<?php
/**
 * Tool Manager - Handles registration and initialization of dev tools
 */

if (!defined('ABSPATH')) {
    exit;
}

class GM_Tool_Manager {
    
    /**
     * Registered tools
     */
    private $tools = array();
    
    /**
     * Register a tool
     */
    public function register_tool(GM_Dev_Tool $tool) {
        $this->tools[$tool->get_id()] = $tool;
    }
    
    /**
     * Get all registered tools
     */
    public function get_tools() {
        return $this->tools;
    }
    
    /**
     * Get a specific tool by ID
     */
    public function get_tool($tool_id) {
        return isset($this->tools[$tool_id]) ? $this->tools[$tool_id] : null;
    }
    
    /**
     * Get enabled tools
     */
    public function get_enabled_tools() {
        $enabled_tools = array();
        $enabled_ids = get_option('gm_dev_tools_enabled', array());
        
        foreach ($this->tools as $tool) {
            if (in_array($tool->get_id(), $enabled_ids)) {
                $enabled_tools[] = $tool;
            }
        }
        
        return $enabled_tools;
    }
    
    /**
     * Initialize all enabled tools
     */
    public function init() {
        // Check if tools should be shown in this environment
        if (!GM_Dev_Tools_Environment::should_show_tools()) {
            return;
        }

        foreach ($this->tools as $tool) {
            if ($tool->is_enabled() && !$tool->is_coming_soon()) {
                $tool->init();
            }
        }
    }

    /**
     * Enqueue frontend assets for all enabled tools
     */
    public function enqueue_frontend_assets() {
        // Only load on frontend, not in admin
        if (is_admin()) {
            return;
        }

        // Check if tools should be shown in this environment
        if (!GM_Dev_Tools_Environment::should_show_tools()) {
            return;
        }

        // Check if any tools are enabled
        $enabled_tools = $this->get_enabled_tools();
        if (empty($enabled_tools)) {
            return;
        }

        // Enqueue common styles if needed
        wp_enqueue_style(
            'gm-dev-tools-common',
            GM_DEV_TOOLS_PLUGIN_URL . 'assets/css/common.css',
            array(),
            GM_DEV_TOOLS_VERSION
        );

        // Enqueue tool dock styles and scripts
        wp_enqueue_style(
            'gm-dev-tools-dock',
            GM_DEV_TOOLS_PLUGIN_URL . 'assets/css/tool-dock.css',
            array('gm-dev-tools-common'),
            GM_DEV_TOOLS_VERSION
        );

        wp_enqueue_script(
            'gm-dev-tools-dock',
            GM_DEV_TOOLS_PLUGIN_URL . 'assets/js/tool-dock.js',
            array(),
            GM_DEV_TOOLS_VERSION,
            true // Load in footer
        );
    }
    
    /**
     * Check if any tools are enabled
     */
    public function has_enabled_tools() {
        $enabled_ids = get_option('gm_dev_tools_enabled', array());
        return !empty($enabled_ids);
    }
    
    /**
     * Enable a tool
     */
    public function enable_tool($tool_id) {
        $enabled_tools = get_option('gm_dev_tools_enabled', array());
        
        if (!in_array($tool_id, $enabled_tools)) {
            $enabled_tools[] = $tool_id;
            update_option('gm_dev_tools_enabled', $enabled_tools);
        }
    }
    
    /**
     * Disable a tool
     */
    public function disable_tool($tool_id) {
        $enabled_tools = get_option('gm_dev_tools_enabled', array());
        $key = array_search($tool_id, $enabled_tools);
        
        if ($key !== false) {
            unset($enabled_tools[$key]);
            update_option('gm_dev_tools_enabled', array_values($enabled_tools));
        }
    }
    
    /**
     * Toggle a tool's enabled state
     */
    public function toggle_tool($tool_id) {
        $tool = $this->get_tool($tool_id);
        
        if ($tool) {
            if ($tool->is_enabled()) {
                $this->disable_tool($tool_id);
            } else {
                $this->enable_tool($tool_id);
            }
        }
    }
}