# Changelog

All notable changes to G&M Dev Tools will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.0] - 2025-11-25

### Changed
- **Simplified Module Labels** - Now uses simple `data-module` attribute approach
  - Labels appear as small badges in top-right corner of each module
  - Numbered labels (1, 2, 3...) for easy reference
  - Cleaner display with common prefixes stripped automatically
  - No complex comment detection - just wrap modules in theme

### Improved
- Much simpler theme integration - just wrap modules with `data-module` attribute
- Better documentation with step-by-step integration guide
- More reliable label positioning with absolute positioning

### Removed
- Complex comment detection system (was unreliable)
- Unnecessary configuration options

## [1.2.0] - 2025-01-23

### Added
- **Theme Configuration System** - Module Labels tool now supports custom theme configurations
  - Themes can define their own module selectors via `gm-dev-tools-config.php`
  - Supports any data attribute naming convention (data-module, data-component, etc.)
  - Supports class-based module selection
  - Optional prefix removal for cleaner label display
  - Backward compatible with existing ACF module detection

### Changed
- Renamed "ACF Module Labels" to "Module Labels" for broader compatibility
- Module Labels tool now dynamically adapts to theme configuration
- Updated tool description to reflect support for custom modules

### Improved
- Plugin is now truly universal - no code changes needed for different sites
- Configuration is version-controlled with theme, not plugin
- Better documentation with clear examples

## [1.1.0] - 2025-01-18

### Added
- **Progressive Typography Inspector** - Enhanced tool with 4 detail levels
  - Tags only mode: Shows element tags (H1, P, etc.)
  - Fonts mode: Shows tags + font family names
  - Full mode: Shows complete typography details
  - Cycles through progressive detail with each click

### Changed
- Renamed "Font X-Ray" to "Typography Inspector" for clarity
- Updated Typography Inspector emoji from 🔍 to 📏 to better represent measurements
- Merged font detection functionality directly into Typography Inspector
- Removed drop shadows from all tool labels for cleaner appearance

## [1.0.2] - 2024-09-18

### Added
- Font weight display in Typography Inspector (Font X-Ray tool)
- Shows weight as readable text (Thin, Light, Regular, Bold, etc.)

### Improved
- Typography details now show: Element • Size/Line-height • Weight • Color

## [1.0.1] - 2024-09-18

### Changed
- Improved emoji spacing in tool buttons for better visual alignment
- Minor CSS refinements for tool dock buttons

### Fixed
- Tool button text alignment on mobile devices

## [1.0.0] - 2024-09-18

### Added
- Initial release
- **Outline Toggle Tool** - Visual element outlines for layout debugging
- **Font X-Ray Tool** - Typography inspector showing element tags and font properties
- **ACF Module Labels Tool** - Display ACF flexible content module names
- **Tool Dock System** - Unified container for all dev tools with collapse/expand
- **Keyboard Shortcuts** - Quick access to tools via keyboard
- **Persistent State** - Tools remember their state using localStorage
- **GitHub Updater** - Automatic update checking from GitHub releases
- **Admin Settings Page** - Enable/disable tools from WordPress admin

### Features
- Clean, unified UI with emoji indicators
- Mobile-friendly collapsible interface
- No jQuery dependencies
- Lightweight and performant
- Works with all WordPress themes

---

## Future Releases

### [Planned Features]
- Grid overlay tool
- Color palette inspector
- Responsive breakpoint indicators
- Performance metrics display
- JavaScript error logger
- CSS specificity calculator

---

For more information, visit [Grain & Mortar](https://grainandmortar.com)