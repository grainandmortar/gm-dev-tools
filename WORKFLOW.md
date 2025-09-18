# G&M Dev Tools - Feature Development Workflow

## Standard Workflow for New Features

### When Adding a New Feature:

1. **Implement the Feature**
   - Create/modify necessary files
   - Test on active symlinked sites (changes appear instantly)
   - Ensure all tools work correctly across different themes/environments

2. **Update Version Number** (REQUIRED)
   ```php
   // In gm-dev-tools.php - update BOTH locations:
   * Version: X.X.X
   define('GM_DEV_TOOLS_VERSION', 'X.X.X');
   ```

3. **Update Documentation** (ALL required):
   - **CHANGELOG.md** - Add new version with feature description
   - **README.md** - Update feature list if needed
   - **readme.txt** - Update WordPress readme (version, changelog, description)
   - **CLAUDE.md** - Update if workflow/setup changes

4. **Commit and Push**
   ```bash
   cd "/Users/edowns/Local Sites/wordpress-plugins/gm-dev-tools"
   git add -A
   git commit -m "Add [feature name] - version X.X.X"
   git push origin main
   ```

5. **Create GitHub Release** (CRITICAL - Updates won't work without this!)
   - Go to: https://github.com/grainandmortar/gm-dev-tools/releases
   - Click "Draft a new release"
   - Tag version: `X.X.X` (match plugin version)
   - Title: `Version X.X.X - [Feature Name]`
   - Description: Brief feature summary
   - Publish release

## Version Numbering Guide
- **Major** (X.0.0): New tools or breaking changes
- **Minor** (1.X.0): New features to existing tools
- **Patch** (1.0.X): Bug fixes, minor improvements

## Files That ALWAYS Need Updating

### For ANY change:
1. `gm-dev-tools.php` - Version number (2 places)
2. `CHANGELOG.md` - Version history

### For NEW features:
3. `README.md` - Feature documentation
4. `readme.txt` - WordPress repository format

### For workflow changes:
5. `CLAUDE.md` - Development notes
6. This file (`WORKFLOW.md`) - If process changes

## Quick Checklist
```
[ ] Feature implemented and tested
[ ] Version bumped in gm-dev-tools.php (both places)
[ ] CHANGELOG.md updated
[ ] README.md updated (if needed)
[ ] readme.txt updated (if needed)
[ ] Committed and pushed to GitHub
[ ] GitHub release created
[ ] Other sites can now update!
```

## Testing Update on Other Sites
1. Wait ~5 minutes after creating release
2. Check WordPress admin → Plugins
3. Should see update notification
4. Click "Update Now"

## Common Issues
- **No update showing?** - Did you create a GitHub release?
- **Version mismatch?** - Check both version locations in main file
- **Update fails?** - Folder permissions or maintenance mode issue

Remember: Just pushing code is NOT enough - GitHub release is REQUIRED!