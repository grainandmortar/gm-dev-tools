# G&M Dev Tools - Claude Project Memory

## Project Overview
WordPress plugin providing development tools for debugging and visualizing themes. Private plugin used internally by Grain & Mortar for client projects.

## Development Setup
- **Development Folder**: `/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools/`
- **Test Site**: Steven Ginn Architects (symlinked to development folder)
- **GitHub Repo**: https://github.com/grainandmortar/gm-dev-tools

## Release Workflow (IMPORTANT)

### When Making Updates:
1. **Make changes** in development folder
2. **Test** on Steven Ginn site (automatic via symlink)
3. **Bump version number** in `gm-dev-tools.php` (both header and constant)
4. **Update CHANGELOG.md** with changes
5. **Commit and push**:
   ```bash
   cd "/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools"
   git add -A
   git commit -m "Release version X.X.X - Brief description"
   git push origin main
   ```

### Creating a GitHub Release (REQUIRED for updates):
1. Go to https://github.com/grainandmortar/gm-dev-tools/releases
2. Click **"Draft a new release"**
3. **Tag version**: Enter the version number (e.g., `1.0.3`)
4. **Release title**: `Version X.X.X - Feature Name`
5. **Write release notes**
6. Click **"Publish release"**

**⚠️ IMPORTANT**: Other sites will NOT see updates unless you create a GitHub release! Just pushing code is not enough.

## Plugin Features

### Current Tools:
1. **Outline Toggle** 📐
   - Visual element outlines for layout debugging
   - Three modes: Off → Divs Only → All Elements

2. **Font X-Ray (Typography Inspector)** 🔍
   - Shows typography information
   - Labels mode: Shows element tags (H1, H2, P, etc.)
   - Details mode: Shows tag, font size, line height, font weight, and color
   - Example: `H1 • 32px/120% • Bold • #333333`

3. **ACF Module Labels** 🏷️
   - Displays ACF flexible content module names on frontend

### Tool Dock System
- Collapsible container in bottom-right corner
- Toggle with ⚙️ button
- Persistent state via localStorage

## Installation on New Sites

### For Developers (Recommended):
```bash
cd wp-content/plugins/
git clone https://github.com/grainandmortar/gm-dev-tools.git
```

### For Non-Technical Users:
1. Download from GitHub releases
2. Install via WordPress admin
3. Note: Folder must be named `gm-dev-tools` (no version numbers)

## Auto-Update System
- Checks GitHub releases for new versions
- Shows update notifications in WordPress admin
- Updates download from GitHub release assets

## Version History
- **1.0.2** - Added font weight to Typography Inspector
- **1.0.1** - UI improvements, emoji spacing
- **1.0.0** - Initial release

## Important Notes
- This is a PRIVATE plugin (not in WordPress.org repository)
- Updates REQUIRE creating GitHub releases
- Plugin folder name must always be `gm-dev-tools` (no version suffix)
- All sites with plugin installed will auto-check for updates

## Feature Development Workflow
When adding new features, follow the workflow in WORKFLOW.md:
1. Implement and test the feature
2. Bump version in gm-dev-tools.php (BOTH header and constant)
3. Update CHANGELOG.md, README.md, and readme.txt
4. Commit and push to GitHub
5. **CREATE GITHUB RELEASE** (required for updates to work!)

Last updated: January 2025