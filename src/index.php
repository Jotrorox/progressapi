<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$type = isset($_GET['type']) ? $_GET['type'] : 'default';  // Progress bar type from query param
$progress = isset($_GET['progress']) ? $_GET['progress'] : 50;  // Progress value from query param (0-100)
$progress = min(100, max(0, (int)$progress));  // Ensure progress is between 0-100
$color = isset($_GET['color']) ? $_GET['color'] : '#4caf50';  // Progress bar color from query param (default to green)
$height = isset($_GET['height']) ? $_GET['height'] : 20;  // Progress bar height from query param (default to 20px)

// Define progress bar styles
$progressBars = [
    'default' => function($progress, $color, $height) {
        return "<div style='width: 100%; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px;'></div>
                </div>";
    },
    'striped' => function($progress, $color, $height) {
        return "<div style='width: 100%; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px;
                    background-image: linear-gradient(45deg, rgba(255,255,255,.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, transparent 75%, transparent);'>
                    </div>
                </div>";
    },
    'animated' => function($progress, $color, $height) {
        return "<div style='width: 100%; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px; transition: width 2s ease;'></div>
                </div>";
    },
];

// Set the correct progress bar type
$progressBar = isset($progressBars[$type]) ? $progressBars[$type] : $progressBars['default'];

// Return the progress bar as JSON
echo json_encode([
    'type' => $type,
    'progress' => $progress,
    'color' => $color,
    'height' => $height,
    'html' => $progressBar($progress, $color, (int)$height)
]);