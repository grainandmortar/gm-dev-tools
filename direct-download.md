# Direct Download Link

## The Problem:
GitHub stupidly adds version numbers and random strings to folder names when you download, making plugins not work in WordPress.

## The Solution:
Instead of using GitHub releases, just use this direct download link that ALWAYS gets the latest version with the CORRECT folder name:

### Direct Download (Always Latest):
```
https://github.com/grainandmortar/gm-dev-tools/archive/refs/heads/main.zip
```

This downloads the main branch as `gm-dev-tools-main.zip` but the folder inside is still wrong.

## Better Solution:
Host the ZIP file yourself somewhere (Dropbox, Google Drive, your server) with the correct structure:
1. ZIP file contains a folder named exactly: `gm-dev-tools`
2. Share that link
3. It just works - no renaming needed

## Or Use Git:
The only reliable way to get it with the right name from GitHub is:
```bash
git clone https://github.com/grainandmortar/gm-dev-tools.git
```

GitHub's release system is fundamentally broken for WordPress plugins because they insist on adding suffixes to folder names.