<?php

// 1) Layani berkas statis dari public/ (CSS, JS, gambar, font)
$uri        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$publicPath = realpath(__DIR__ . '/../public');
$file       = realpath($publicPath . $uri);

if (
    $file
    && str_starts_with($file, $publicPath . DIRECTORY_SEPARATOR)
    && is_file($file)
    && !str_starts_with(basename($file), '.')
    && strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'php'
) {
    $types = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'json'  => 'application/json',
        'map'   => 'application/json',
        'svg'   => 'image/svg+xml',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
    ];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
    header('Cache-Control: public, max-age=31536000');
    readfile($file);
    exit;
}

// 2) Perbaikan untuk Vercel: file masuk ada di /api/index.php, sehingga Laravel
// salah mengira "/api" adalah base URL. Paksa Laravel menganggap
// file masuknya adalah /index.php biasa.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

require __DIR__ . '/../public/index.php';