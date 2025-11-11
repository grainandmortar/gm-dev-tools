<?php
/**
 * Environment Detection - Determines if tools should be visible
 */

if (!defined('ABSPATH')) {
    exit;
}

class GM_Dev_Tools_Environment {

    /**
     * Check if current environment is local
     */
    public static function is_local() {
        // Check for common local development indicators
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

        // Local domains and IPs
        $local_hosts = array(
            'localhost',
            '127.0.0.1',
            '::1',
            '.local',
            '.test',
            '.dev',
            '.localhost'
        );

        foreach ($local_hosts as $local_host) {
            if (strpos($host, $local_host) !== false) {
                return true;
            }
        }

        // Check for Local by Flywheel
        if (defined('LOCAL_SITE_PATH')) {
            return true;
        }

        // Check for WP_ENVIRONMENT_TYPE constant (WordPress 5.5+)
        if (defined('WP_ENVIRONMENT_TYPE') && in_array(WP_ENVIRONMENT_TYPE, array('local', 'development'))) {
            return true;
        }

        // Check for common local environment variables
        if (defined('WP_LOCAL_DEV') && WP_LOCAL_DEV === true) {
            return true;
        }

        return false;
    }

    /**
     * Check if tools should be shown based on environment and settings
     */
    public static function should_show_tools() {
        $show_on_setting = get_option('gm_dev_tools_show_on', 'local');
        $is_local = self::is_local();

        switch ($show_on_setting) {
            case 'local':
                return $is_local;

            case 'production':
                return !$is_local;

            case 'both':
                return true;

            default:
                return $is_local; // Default to local only for safety
        }
    }

    /**
     * Get current environment name
     */
    public static function get_environment_name() {
        if (self::is_local()) {
            return 'Local';
        }

        if (defined('WP_ENVIRONMENT_TYPE')) {
            return ucfirst(WP_ENVIRONMENT_TYPE);
        }

        return 'Production';
    }

    /**
     * Get human-readable label for show_on setting
     */
    public static function get_show_on_label($setting = null) {
        if ($setting === null) {
            $setting = get_option('gm_dev_tools_show_on', 'local');
        }

        $labels = array(
            'local' => 'Local environments only',
            'production' => 'Production/Live sites only',
            'both' => 'Both local and production'
        );

        return isset($labels[$setting]) ? $labels[$setting] : $labels['local'];
    }
}
