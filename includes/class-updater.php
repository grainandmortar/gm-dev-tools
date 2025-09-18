<?php
/**
 * G&M Dev Tools - GitHub Updater
 *
 * Handles automatic updates from GitHub releases
 */

if (!defined('ABSPATH')) {
    exit;
}

class GM_Dev_Tools_Updater {

    private $plugin_slug;
    private $version;
    private $github_username = 'grainandmortar'; // Update with your GitHub username
    private $github_repo = 'gm-dev-tools';
    private $plugin_file;
    private $github_api_result;

    /**
     * Constructor
     */
    public function __construct($plugin_file) {
        $this->plugin_file = $plugin_file;
        $this->plugin_slug = plugin_basename($this->plugin_file);

        // Get plugin version from header
        $plugin_data = get_file_data($this->plugin_file, array('Version' => 'Version'));
        $this->version = $plugin_data['Version'];

        // Hook into WordPress update system
        add_filter('pre_set_site_transient_update_plugins', array($this, 'check_for_update'));
        add_filter('plugins_api', array($this, 'plugin_info'), 20, 3);
        add_action('upgrader_process_complete', array($this, 'after_update'), 10, 2);
    }

    /**
     * Check for updates
     */
    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Get the latest release from GitHub
        $github_data = $this->get_github_release_info();

        if (!$github_data) {
            return $transient;
        }

        // Compare versions
        if (version_compare($this->version, $github_data->tag_name, '<')) {
            $plugin_data = array(
                'slug' => $this->plugin_slug,
                'plugin' => $this->plugin_slug,
                'new_version' => $github_data->tag_name,
                'url' => "https://github.com/{$this->github_username}/{$this->github_repo}",
                'package' => $github_data->zipball_url,
                'icons' => array(
                    '2x' => plugin_dir_url(dirname(__FILE__)) . 'admin/images/icon-256x256.png',
                    '1x' => plugin_dir_url(dirname(__FILE__)) . 'admin/images/icon-128x128.png',
                ),
                'tested' => get_bloginfo('version'),
                'requires' => '5.0',
                'requires_php' => '7.0',
            );

            $transient->response[$this->plugin_slug] = (object) $plugin_data;
        }

        return $transient;
    }

    /**
     * Get plugin info for WordPress plugin modal
     */
    public function plugin_info($result, $action, $args) {
        if ($action !== 'plugin_information') {
            return $result;
        }

        if ($args->slug !== dirname($this->plugin_slug)) {
            return $result;
        }

        $github_data = $this->get_github_release_info();

        if (!$github_data) {
            return $result;
        }

        $plugin_info = array(
            'name' => 'G&M Dev Tools',
            'slug' => dirname($this->plugin_slug),
            'version' => $github_data->tag_name,
            'author' => '<a href="https://grainandmortar.com">Grain & Mortar</a>',
            'homepage' => "https://github.com/{$this->github_username}/{$this->github_repo}",
            'short_description' => 'Development tools for debugging and visualizing WordPress themes.',
            'sections' => array(
                'description' => $this->parse_markdown($github_data->body),
                'changelog' => $this->get_changelog(),
            ),
            'download_link' => $github_data->zipball_url,
            'tested' => get_bloginfo('version'),
            'requires' => '5.0',
            'requires_php' => '7.0',
            'last_updated' => $github_data->published_at,
        );

        return (object) $plugin_info;
    }

    /**
     * Get release info from GitHub API
     */
    private function get_github_release_info() {
        if (!empty($this->github_api_result)) {
            return $this->github_api_result;
        }

        // Check cache
        $cache_key = 'gm_dev_tools_github_release';
        $cached_data = get_transient($cache_key);

        if ($cached_data !== false) {
            $this->github_api_result = $cached_data;
            return $cached_data;
        }

        // Make API request
        $api_url = "https://api.github.com/repos/{$this->github_username}/{$this->github_repo}/releases/latest";

        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
            ),
            'timeout' => 10,
        ));

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);

        if (empty($data)) {
            return false;
        }

        // Cache for 6 hours
        set_transient($cache_key, $data, 6 * HOUR_IN_SECONDS);

        $this->github_api_result = $data;
        return $data;
    }

    /**
     * Get changelog from CHANGELOG.md
     */
    private function get_changelog() {
        $changelog_url = "https://raw.githubusercontent.com/{$this->github_username}/{$this->github_repo}/main/CHANGELOG.md";

        $response = wp_remote_get($changelog_url, array('timeout' => 10));

        if (is_wp_error($response)) {
            return 'Unable to fetch changelog.';
        }

        $changelog = wp_remote_retrieve_body($response);
        return $this->parse_markdown($changelog);
    }

    /**
     * Simple markdown to HTML parser
     */
    private function parse_markdown($text) {
        $html = $text;

        // Headers
        $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
        $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
        $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $html);

        // Bold
        $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);

        // Italic
        $html = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $html);

        // Links
        $html = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $html);

        // Lists
        $html = preg_replace('/^\* (.+)$/m', '<li>$1</li>', $html);
        $html = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $html);

        // Line breaks
        $html = nl2br($html);

        return $html;
    }

    /**
     * After update actions
     */
    public function after_update($upgrader_object, $options) {
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            // Clear update cache
            delete_transient('gm_dev_tools_github_release');
        }
    }
}