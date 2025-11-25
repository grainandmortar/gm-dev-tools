# G&M Dev Tools 🛠️

Professional WordPress development tools for debugging and visualizing themes.

## Features

### 📐 Outline Toggle
Visual element outlines for layout debugging. Cycles through:
- **Off** - No outlines
- **Divs Only** - Shows only div elements
- **All Elements** - Shows all HTML elements

### 📏 Typography Inspector
Progressive typography information with 4 detail levels:
- **Off** - No labels
- **Tags** - Shows element tags (H1, H2, P, etc.)
- **Fonts** - Shows tags + font family (e.g., `H1 • Bembo MT Pro`)
- **Full** - Complete details (e.g., `H1 • Bembo MT Pro • 32px/120% • Bold • #333333`)

### 🏷️ Module Labels
Displays module names on the frontend for easy identification. Works with:
- ACF Flexible Content modules
- Custom theme modules
- Any data-attribute based modules

## Installation

### Method 1: Direct Download
1. Download the latest release from GitHub
2. Upload to `/wp-content/plugins/` directory
3. Activate through the 'Plugins' menu in WordPress

### Method 2: Git Clone
```bash
cd wp-content/plugins/
git clone https://github.com/grainandmortar/gm-dev-tools.git
```

### Method 3: Symlink for Development
```bash
# Clone to your development directory
git clone https://github.com/grainandmortar/gm-dev-tools.git ~/Local\ Sites/wordpress-plugins/gm-dev-tools

# Create symlink in your WordPress installation
ln -s ~/Local\ Sites/wordpress-plugins/gm-dev-tools /path/to/wordpress/wp-content/plugins/gm-dev-tools
```

## Usage

Once activated, the tools appear in the bottom-right corner of your site:

1. Click the ⚙️ toggle button to show/hide the tool panel
2. Click any tool button to activate/deactivate it
3. Tools remember their state using localStorage

### Keyboard Shortcuts
- **Outline Toggle**: `Ctrl/Cmd + Shift + O`
- **Typography Inspector**: `Ctrl/Cmd + Shift + T`
- **Module Labels**: `Ctrl/Cmd + Shift + M`

## Module Labels Configuration 🆕

The Module Labels tool can be customized for any theme by adding a configuration file. This allows the plugin to work with any module naming convention without modifying the plugin code.

### Default Behavior
By default, the Module Labels tool looks for ACF modules with `data-acf-module` attributes.

### Custom Configuration
To use custom module attributes (like `data-module` or `data-component`), add a configuration file to your theme root:

**File:** `your-theme/gm-dev-tools-config.php`

```php
<?php
/**
 * GM Dev Tools Configuration
 * Theme-specific settings for GM Dev Tools plugin
 */

return array(
    'module_labels' => array(
        // CSS selector to find modules
        'selector' => '[data-module]',

        // The data attribute name (without 'data-' prefix)
        'attribute' => 'module',

        // Optional: Prefix to remove from module names when displaying
        // Example: 'page_module_home_hero' becomes 'home_hero'
        'format_prefix' => 'page_module_',

        // Optional: Additional class selectors
        'class_selectors' => array(),

        // Optional: Custom format function name
        'format_function' => null,
    )
);
```

### Configuration Examples

#### Example 1: Standard ACF Modules
```php
// No configuration needed - uses defaults
// Looks for: data-acf-module="hero_banner"
```

#### Example 2: Custom Data Attributes
```php
return array(
    'module_labels' => array(
        'selector' => '[data-component]',
        'attribute' => 'component',
        'format_prefix' => 'component_',
    )
);
// Looks for: data-component="component_header"
```

#### Example 3: Class-Based Modules
```php
return array(
    'module_labels' => array(
        'selector' => '.module',
        'attribute' => null,
        'class_selectors' => array('.module', '.component'),
    )
);
// Looks for: <div class="module">
```

### Theme Integration

For Module Labels to work, wrap each module in a div with a `data-module` attribute. Here's how to do it for ACF Flexible Content modules:

#### Step 1: Wrap modules in your loader file

In your module loader file (e.g., `page_modules.php`), wrap each module:

```php
<?php if ( have_rows( 'page_modules', $page_variable ) ): ?>
<?php while ( have_rows( 'page_modules', $page_variable ) ) : the_row(); ?>
<div class="gm-module-wrapper" data-module="<?php echo esc_attr( get_row_layout() ); ?>">
<?php
    $layout = get_row_layout();
    switch ( $layout ) {
        case 'page_module_text_block':
            get_template_part('inc/modules/page_modules/page_module_text_block');
            break;
        case 'page_module_title_block':
            get_template_part('inc/modules/page_modules/page_module_title_block');
            break;
        // ... add all your modules
    }
?>
</div>
<?php endwhile; ?>
<?php endif; ?>
```

#### Step 2: That's it!

The plugin will automatically:
- Find all `[data-module]` elements
- Display a small label in the top-right corner showing the module name
- Strip common prefixes like `page_module_` for cleaner display
- Number each module (1, 2, 3...)

#### Before & After Example

**Before (typical ACF flexible content):**
```php
<?php if ( get_row_layout() == 'page_module_text_block' ) : ?>
    <?php get_template_part('inc/modules/page_modules/page_module_text_block'); ?>
<?php endif; ?>
```

**After (with module labels support):**
```php
<div class="gm-module-wrapper" data-module="<?php echo esc_attr( get_row_layout() ); ?>">
<?php if ( get_row_layout() == 'page_module_text_block' ) : ?>
    <?php get_template_part('inc/modules/page_modules/page_module_text_block'); ?>
<?php endif; ?>
</div>
```

#### Module Loaders to Update

Apply this pattern to all your module loader files:
- `inc/modules/page_modules/page_modules.php`
- `inc/modules/hero_modules/hero_modules.php`
- `inc/modules/cta_modules/cta_modules.php`
- `inc/modules/media_modules/media_modules.php`
- etc.

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Modern browser with JavaScript enabled

## Updates

The plugin includes automatic update checking from GitHub releases. When a new version is available, you'll see an update notification in your WordPress admin.

## Development

### Directory Structure
```
gm-dev-tools/
├── admin/                  # Admin interface
├── assets/                 # Shared CSS/JS for tool dock
├── includes/              # Core classes
├── tools/                 # Individual tools
│   ├── outline-toggle/
│   ├── font-xray/        # Typography Inspector
│   └── acf-module-labels/   # Module Labels
├── gm-dev-tools.php       # Main plugin file
├── gm-dev-tools-config-example.php  # Example config (copy to theme)
└── README.md
```

### Adding New Tools

1. Create a new directory in `/tools/your-tool-name/`
2. Create a class extending `GM_Dev_Tool`
3. Register in `gm-dev-tools.php`

### Creating a Release

1. Update version number in:
   - `gm-dev-tools.php` (header comment and `GM_DEV_TOOLS_VERSION` constant)
   - `readme.txt`
   - `CHANGELOG.md`

2. Commit changes:
   ```bash
   git add .
   git commit -m "Release version X.X.X"
   git push origin main
   ```

3. Create GitHub release:
   ```bash
   ./create-release.sh
   ```

## Support

- **Issues**: [GitHub Issues](https://github.com/grainandmortar/gm-dev-tools/issues)
- **Website**: [Grain & Mortar](https://grainandmortar.com)

## License

GPL v2 or later

---

Built with ❤️ by [Grain & Mortar](https://grainandmortar.com)