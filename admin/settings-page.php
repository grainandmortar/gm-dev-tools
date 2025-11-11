<?php
/**
 * Admin settings page for G&M Dev Tools
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get tool manager instance
$plugin = GM_Dev_Tools::get_instance();
$tool_manager = $plugin->get_tool_manager();
$tools = $tool_manager->get_tools();
$enabled_tools = get_option('gm_dev_tools_enabled', array());
$show_on_setting = get_option('gm_dev_tools_show_on', 'local');
$current_env = GM_Dev_Tools_Environment::get_environment_name();
$tools_visible = GM_Dev_Tools_Environment::should_show_tools();

?>
<div class="wrap gm-dev-tools-admin">
    <h1>G&M Dev Tools 🛠️</h1>
    <p class="description">Development tools for debugging and visualizing your WordPress theme. Enable or disable tools as needed. Built with ❤️ by <a href="https://grainandmortar.com" target="_blank">Grain & Mortar</a></p>

    <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'): ?>
        <div class="notice notice-success is-dismissible">
            <p>✅ Settings saved successfully!</p>
        </div>
    <?php endif; ?>

    <form method="post" action="options.php" class="gm-dev-tools-form">
        <?php wp_nonce_field('gm_dev_tools_settings', 'gm_dev_tools_nonce'); ?>

        <div class="gm-dev-tools-container">
            <h2>🌍 Environment Settings</h2>
            <div class="environment-settings">
                <div class="environment-status">
                    <strong>Current Environment:</strong>
                    <span class="env-badge env-<?php echo strtolower($current_env); ?>"><?php echo esc_html($current_env); ?></span>
                    <span class="env-visibility <?php echo $tools_visible ? 'visible' : 'hidden'; ?>">
                        <?php echo $tools_visible ? '👁️ Tools Visible' : '🚫 Tools Hidden'; ?>
                    </span>
                </div>

                <div class="show-tools-on">
                    <label><strong>Show Tools On:</strong></label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="gm_dev_tools_show_on" value="local" <?php checked($show_on_setting, 'local'); ?> />
                            <span class="radio-label">
                                <strong>Local environments only</strong>
                                <small>Safest option - tools only appear on localhost, .local, .test domains</small>
                            </span>
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="gm_dev_tools_show_on" value="production" <?php checked($show_on_setting, 'production'); ?> />
                            <span class="radio-label">
                                <strong>Production/Live sites only</strong>
                                <small>Tools only visible on live/staging sites (not local)</small>
                            </span>
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="gm_dev_tools_show_on" value="both" <?php checked($show_on_setting, 'both'); ?> />
                            <span class="radio-label">
                                <strong>Both local and production</strong>
                                <small>Tools visible everywhere (use for debugging live issues)</small>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <h2>Available Tools</h2>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col" class="check-column">
                            <input type="checkbox" id="gm-select-all" />
                        </th>
                        <th scope="col">Tool Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tools as $tool): ?>
                        <?php 
                        $tool_id = $tool->get_id();
                        $is_enabled = in_array($tool_id, $enabled_tools);
                        $is_coming_soon = $tool->is_coming_soon();
                        ?>
                        <tr class="<?php echo $is_coming_soon ? 'coming-soon' : ''; ?>">
                            <th scope="row" class="check-column">
                                <?php if (!$is_coming_soon): ?>
                                    <input type="checkbox" 
                                           name="gm_dev_tools_enabled[]" 
                                           value="<?php echo esc_attr($tool_id); ?>"
                                           id="tool-<?php echo esc_attr($tool_id); ?>"
                                           <?php checked($is_enabled); ?> />
                                <?php endif; ?>
                            </th>
                            <td>
                                <label for="tool-<?php echo esc_attr($tool_id); ?>">
                                    <strong><?php echo esc_html($tool->get_name()); ?></strong>
                                    <?php if ($is_coming_soon): ?>
                                        <span class="badge badge-coming-soon">Coming Soon</span>
                                    <?php endif; ?>
                                </label>
                            </td>
                            <td>
                                <?php echo esc_html($tool->get_description()); ?>
                            </td>
                            <td>
                                <?php if ($is_coming_soon): ?>
                                    <span class="status-indicator status-coming-soon">In Development</span>
                                <?php elseif ($is_enabled): ?>
                                    <span class="status-indicator status-enabled">Enabled</span>
                                <?php else: ?>
                                    <span class="status-indicator status-disabled">Disabled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="submit-wrapper">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                <span class="spinner"></span>
            </div>
        </div>
        
        <div class="gm-dev-tools-info">
            <h3>📖 Usage Information</h3>
            <ul>
                <li><strong>Outline Toggle:</strong> Press <code>Ctrl/Cmd + Shift + O</code> to cycle through outline modes, or use the floating button in the bottom-right corner.</li>
                <li><strong>Font Size X-Ray:</strong> <em>Coming soon - will display font sizes overlaid on text elements.</em> 👀</li>
            </ul>
            
            <h3>⚠️ Important Notes</h3>
            <ul>
                <li>Dev tools are only visible on the frontend when enabled and the environment setting allows it.</li>
                <li>By default, tools are hidden on production sites for safety. Use the "Show Tools On" setting above to override.</li>
                <li>Tools persist their state using browser localStorage when applicable.</li>
                <li>Environment detection works with localhost, .local, .test, .dev domains and Local by Flywheel.</li>
            </ul>
            
            <h3>🌾 About Grain & Mortar</h3>
            <p>We're a digital design and development studio that crafts thoughtful web experiences. Find us at <a href="https://grainandmortar.com" target="_blank">grainandmortar.com</a> or follow us <a href="https://www.instagram.com/grainandmortar" target="_blank">@grainandmortar</a> on Instagram.</p>
        </div>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Select all checkbox
    $('#gm-select-all').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('input[name="gm_dev_tools_enabled[]"]').prop('checked', isChecked);
    });
    
    // Update select all based on individual checkboxes
    $('input[name="gm_dev_tools_enabled[]"]').on('change', function() {
        var total = $('input[name="gm_dev_tools_enabled[]"]').length;
        var checked = $('input[name="gm_dev_tools_enabled[]"]:checked').length;
        $('#gm-select-all').prop('checked', total === checked);
    });
    
    // Handle form submission
    $('.gm-dev-tools-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $spinner = $form.find('.spinner');
        var $submit = $form.find('#submit');
        
        // Show spinner
        $spinner.addClass('is-active');
        $submit.prop('disabled', true);
        
        // Gather enabled tools
        var enabledTools = [];
        $('input[name="gm_dev_tools_enabled[]"]:checked').each(function() {
            enabledTools.push($(this).val());
        });

        // Get environment setting
        var showOn = $('input[name="gm_dev_tools_show_on"]:checked').val();

        // Send AJAX request
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'gm_dev_tools_save_settings',
                nonce: $('#gm_dev_tools_nonce').val(),
                enabled_tools: enabledTools,
                show_on: showOn
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    var notice = $('<div class="notice notice-success is-dismissible"><p>✅ Settings saved successfully!</p></div>');
                    $('.wrap h1').after(notice);
                    
                    // Update status indicators
                    $('input[name="gm_dev_tools_enabled[]"]').each(function() {
                        var $checkbox = $(this);
                        var $row = $checkbox.closest('tr');
                        var $status = $row.find('.status-indicator');
                        
                        if ($checkbox.is(':checked')) {
                            $status.removeClass('status-disabled').addClass('status-enabled').text('Enabled');
                        } else {
                            $status.removeClass('status-enabled').addClass('status-disabled').text('Disabled');
                        }
                    });
                    
                    // Auto-dismiss notice after 3 seconds
                    setTimeout(function() {
                        notice.fadeOut(function() {
                            $(this).remove();
                        });
                    }, 3000);
                }
            },
            complete: function() {
                // Hide spinner
                $spinner.removeClass('is-active');
                $submit.prop('disabled', false);
            }
        });
    });
});
</script>