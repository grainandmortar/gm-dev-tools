# G&M Dev Tools - Claude Project Memory

## Project Overview
WordPress plugin providing development tools for debugging and visualizing themes. Private plugin used internally by Grain & Mortar for client projects.

## Development Setup
- **Development Folder**: `/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools/`
- **GitHub Repo**: https://github.com/grainandmortar/gm-dev-tools
- **Test Sites**: Multiple client sites via symlinks (see Dynamic Testing Workflow below)

## Release Workflow (IMPORTANT)

### When Making Updates:
1. **Make changes** in development folder
2. **Test** on active symlinked sites (changes appear instantly)
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

2. **Typography Inspector** 📏
   - Progressive typography information with 4 detail levels
   - Tags mode: Shows element tags (H1, H2, P, etc.)
   - Fonts mode: Shows tags + font family names
   - Full mode: Complete typography details
   - Example: `H1 • Bembo MT Pro • 32px/120% • Bold • #333333`

3. **ACF Module Labels** 🏷️
   - Displays ACF flexible content module names on frontend

### Tool Dock System
- Collapsible container in bottom-right corner
- Toggle with ⚙️ button
- Persistent state via localStorage

## Dynamic Testing Workflow

### How We Use This Plugin
We use symlinks to test G&M Dev Tools across multiple active client projects. This allows us to:
- **Battle-test features** in real-world scenarios across different themes
- **Refine tools** based on actual client project needs
- **Maintain one codebase** while testing on multiple sites simultaneously

### The Symlink Strategy
```
[Master Plugin Directory]
/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools/
        ↓                    ↓                    ↓
[Active Client A]    [Active Client B]    [Active Client C]
   (symlinked)          (symlinked)          (symlinked)
```

- **When starting a new client project**: Add a symlink to test the tools
- **During development**: Any changes to the plugin instantly appear on all linked sites
- **After project completion**: Remove the symlink to keep test sites current

### Managing Symlinks

#### To add a new test site:
```bash
# Just provide the Local site name (e.g., "awesome-client")
ln -s "/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools" \
      "/Users/edowns/Local Sites/[SITE-NAME]/app/public/wp-content/plugins/gm-dev-tools"
```

#### To remove an old test site:
```bash
# Remove the symlink (doesn't affect the master plugin)
rm "/Users/edowns/Local Sites/[SITE-NAME]/app/public/wp-content/plugins/gm-dev-tools"
```

#### To check current symlinks:
```bash
# List all sites with the plugin symlinked
find "/Users/edowns/Local Sites" -type l -name "gm-dev-tools" 2>/dev/null
```

### Currently Active Test Sites
- Steven Ginn Architects (primary test site)
- *[Add new sites here as they're symlinked]*

### Why This Works Well
1. **Real-world testing** - Features are tested on actual client projects, not just demo sites
2. **Instant updates** - No need to copy files or deploy; changes appear immediately
3. **Clean rotation** - Old projects removed, new projects added, keeping testing relevant
4. **Single source of truth** - Only one codebase to maintain and push to GitHub

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
- **1.1.0** - Enhanced Typography Inspector with progressive detail and font detection
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