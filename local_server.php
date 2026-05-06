<?php
/**
 * Custom local PHP server to serve static files with CORS headers.
 * Usage: php -S 0.0.0.0:8000 local_server.php
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Add global CORS headers for all requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With, X-XSRF-TOKEN');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Private-Network: true');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    exit;
}

// If the requested file exists in the public directory, serve it directly
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    // Set basic MIME types
    $ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));
    $mimes = [
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'pdf'  => 'application/pdf',
        'json' => 'application/json',
        'mp4'  => 'video/mp4',
        'webp' => 'image/webp',
        'ico'  => 'image/x-icon'
    ];
    
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    } else if (file_exists(__DIR__.'/public'.$uri)) {
        $mime = mime_content_type(__DIR__.'/public'.$uri);
        if ($mime) {
            header('Content-Type: ' . $mime);
        }
    }

    readfile(__DIR__.'/public'.$uri);
    return true;
}

// Otherwise, pass the request to Laravel's index.php
require_once __DIR__.'/public/index.php';
