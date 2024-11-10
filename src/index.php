<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$type = isset($_GET['type']) ? $_GET['type'] : 'default';  // Progress bar type from query param
$progress = isset($_GET['progress']) ? $_GET['progress'] : 50;  // Progress value from query param (0-100)
$progress = min(100, max(0, (int)$progress));  // Ensure progress is between 0-100

// Define progress bar styles
$progressBars = [
    'default' => function($progress) {
        return "<div style='width: 100%; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: #4caf50; height: 20px;'></div>
                </div>";
    },
    'striped' => function($progress) {
        return "<div style='width: 100%; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: #4caf50; height: 20px;
                    background-image: linear-gradient(45deg, rgba(255,255,255,.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, transparent 75%, transparent);'>
                    </div>
                </div>";
    },
    'animated' => function($progress) {
        return "<div style='width: 100%; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: #4caf50; height: 20px; transition: width 2s ease;'></div>
                </div>";
    },
];

// Set the correct progress bar type
$progressBar = isset($progressBars[$type]) ? $progressBars[$type] : $progressBars['default'];

// Return the progress bar as JSON
echo json_encode([
    'type' => $type,
    'progress' => $progress,
    'html' => $progressBar($progress)
]);
