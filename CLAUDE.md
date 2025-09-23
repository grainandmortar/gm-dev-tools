# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview
WordPress plugin providing development tools for debugging and visualizing themes. Private plugin used internally by Grain & Mortar for client projects.

## Essential Commands

### Testing Changes
```bash
# Check current symlinks to see which sites have the plugin
find "/Users/edowns/Local Sites" -type l -name "gm-dev-tools" 2>/dev/null

# Add a new test site (changes appear instantly via symlink)
ln -s "/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools" \
      "/Users/edowns/Local Sites/[SITE-NAME]/app/public/wp-content/plugins/gm-dev-tools"
```

### Release Process (CRITICAL)
```bash
# After making changes, commit and push
cd "/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools"
git add -A
git commit -m "Release version X.X.X - Brief description"
git push origin main
```

**⚠️ IMPORTANT**: Other sites will NOT see updates unless you create a GitHub release at https://github.com/grainandmortar/gm-dev-tools/releases

## Architecture

### Plugin Structure
- **Abstract Tool System**: All tools extend `GM_Dev_Tool` (includes/abstract-tool.php) providing standardized init, asset enqueuing, and frontend rendering
- **Tool Manager**: Central registry (`GM_Tool_Manager`) handles tool registration, enabling/disabling, and initialization
- **Tool Dock**: Frontend UI container (bottom-right) that holds all active tools, collapsible with localStorage persistence
- **Auto-Update System**: Custom updater checks GitHub releases for new versions using `GM_Dev_Tools_Updater`

### Adding a New Tool
1. Create folder: `tools/[tool-name]/`
2. Create class extending `GM_Dev_Tool`: `class-[tool-name].php`
3. Override required methods: `enqueue_assets()`, `render_frontend()`
4. Register in main plugin file: `gm-dev-tools.php`
5. Tool automatically appears in admin settings and tool dock

### Key Files That Must Be Updated Together
When bumping version:
- `gm-dev-tools.php`: Version header (line ~6) AND constant (line ~23)
- `CHANGELOG.md`: Add version entry
- `README.md`: Update if features changed
- `readme.txt`: WordPress-format changelog

## Current Tools

1. **Outline Toggle** (`tools/outline-toggle/`): CSS-based element outlining with 3 modes
2. **Typography Inspector** (`tools/font-xray/`): Progressive font details with 4 levels
3. **ACF Module Labels** (`tools/acf-module-labels/`): Shows ACF flexible content module names

## Development Workflow

### Symlink Strategy
The plugin uses symlinks to test across multiple active client sites simultaneously:
- **Development folder**: `/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools/`
- **Test sites**: Symlinked from various client projects
- **Changes appear instantly** on all linked sites (no deployment needed)

### Version Numbering
- **Major** (X.0.0): New tools or breaking changes
- **Minor** (1.X.0): New features to existing tools
- **Patch** (1.0.X): Bug fixes, minor improvements

### Testing Checklist
Before releasing:
- [ ] Test on multiple symlinked sites with different themes
- [ ] Verify tool dock opens/closes correctly
- [ ] Check localStorage persistence works
- [ ] Confirm all tools function independently
- [ ] Test with ACF activated and deactivated (for ACF-dependent tools)

## Important Constraints
- Plugin folder MUST be named exactly `gm-dev-tools` (no version suffix)
- This is a PRIVATE plugin (not in WordPress.org repository)
- Updates REQUIRE creating GitHub releases (just pushing code won't trigger updates)
- All tools should be non-destructive and frontend-only for safety