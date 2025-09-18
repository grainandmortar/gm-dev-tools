<?php
/**
 * G&M Dev Tools - Direct Download Script
 *
 * This script downloads the latest version with the CORRECT folder name
 * Upload this to any web server and share the link
 */

// Get latest release from GitHub
$api_url = 'https://api.github.com/repos/grainandmortar/gm-dev-tools/releases/latest';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'GM-Dev-Tools-Downloader');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$release = json_decode($response);

if (!$release) {
    die('Unable to fetch latest release');
}

// Download the release
$download_url = $release->zipball_url;
$version = $release->tag_name;

// Download the file
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $download_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'GM-Dev-Tools-Downloader');
$zipContent = curl_exec($ch);
curl_close($ch);

// Create temp file
$temp_file = sys_get_temp_dir() . '/gm-dev-tools-temp.zip';
file_put_contents($temp_file, $zipContent);

// Extract and repackage with correct folder name
$temp_extract = sys_get_temp_dir() . '/gm-dev-tools-extract-' . time();
mkdir($temp_extract);

$zip = new ZipArchive;
if ($zip->open($temp_file) === TRUE) {
    $zip->extractTo($temp_extract);
    $zip->close();

    // Find the extracted folder (GitHub creates random names)
    $folders = glob($temp_extract . '/*', GLOB_ONLYDIR);
    $source_folder = $folders[0];

    // Create new ZIP with correct folder structure
    $finalZip = new ZipArchive;
    $finalZipPath = sys_get_temp_dir() . '/gm-dev-tools.zip';

    if ($finalZip->open($finalZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Create iterator
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source_folder),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = 'gm-dev-tools/' . substr($filePath, strlen($source_folder) + 1);
                $finalZip->addFile($filePath, $relativePath);
            }
        }

        $finalZip->close();

        // Send the correctly named ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="gm-dev-tools.zip"');
        header('Content-Length: ' . filesize($finalZipPath));
        readfile($finalZipPath);

        // Clean up
        unlink($temp_file);
        unlink($finalZipPath);
        array_map('unlink', glob("$temp_extract/*/*.*"));
        array_map('rmdir', glob("$temp_extract/*"));
        rmdir($temp_extract);
    }
}
?>