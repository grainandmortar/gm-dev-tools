# G&M Dev Tools 🛠️

Professional WordPress development tools for debugging and visualizing themes.

## Features

### 📐 Outline Toggle
Visual element outlines for layout debugging. Cycles through:
- **Off** - No outlines
- **Divs Only** - Shows only div elements
- **All Elements** - Shows all HTML elements

### 🔍 Font X-Ray (Typography Inspector)
Shows element tags and typography information on headings and paragraphs. Three modes:
- **Off** - No labels
- **Labels** - Shows element tags (H1, H2, P, etc.)
- **Details** - Shows tags + font size/line height/color

### 🏷️ ACF Module Labels
Displays ACF flexible content module names on the frontend for easy identification.

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
- **ACF Module Labels**: `Ctrl/Cmd + Shift + M`

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
├── admin/           # Admin interface
├── assets/          # Shared CSS/JS for tool dock
├── includes/        # Core classes
├── tools/           # Individual tools
│   ├── outline-toggle/
│   ├── font-xray/
│   └── acf-module-labels/
├── gm-dev-tools.php # Main plugin file
└── README.md
```

### Adding New Tools

1. Create a new directory in `/tools/your-tool-name/`
2. Create a class extending `GM_Dev_Tool`
3. Register in `gm-dev-tools.php`

## Support

- **Issues**: [GitHub Issues](https://github.com/grainandmortar/gm-dev-tools/issues)
- **Website**: [Grain & Mortar](https://grainandmortar.com)

## License

GPL v2 or later

---

Built with ❤️ by [Grain & Mortar](https://grainandmortar.com)