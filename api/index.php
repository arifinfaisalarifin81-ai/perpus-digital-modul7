<?php

// Perbaikan untuk Vercel: file masuk ada di /api/index.php, sehingga Laravel
// salah mengira "/api" adalah base URL. Paksa Laravel menganggap
// file masuknya adalah /index.php biasa.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

require __DIR__ . '/../public/index.php';