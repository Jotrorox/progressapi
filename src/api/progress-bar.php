<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Default values
$defaultType = 'default';
$defaultProgress = 50;
$defaultColor = '#4caf50';
$defaultHeight = 20;
$defaultWidth = 300;

$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$progress = filter_input(INPUT_GET, 'progress', FILTER_VALIDATE_INT, array("options" => array("default" => $defaultProgress, "min_range" => 0, "max_range" => 100)));
$color = filter_input(INPUT_GET, 'color', FILTER_SANITIZE_STRING);
$height = filter_input(INPUT_GET, 'height', FILTER_VALIDATE_INT, array("options" => array("default" => $defaultHeight)));
$width = filter_input(INPUT_GET, 'width', FILTER_VALIDATE_INT, array("options" => array("default" => $defaultWidth, "min_range" => 1)));

// Define progress bar styles
$progressBars = [
    'default' => function($progress, $color, $height, $width) {
        return "<div style='width: {$width}px; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px;'></div>
                </div>";
    },
    'striped' => function($progress, $color, $height, $width) {
        return "<div style='width: {$width}px; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px;
                    background-image: linear-gradient(45deg, rgba(255,255,255,.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, transparent 75%, transparent);'>
                    </div>
                </div>";
    },
    'animated' => function($progress, $color, $height, $width) {
        return "<div style='width: {$width}px; background-color: #ddd;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px; 
                        background-image: linear-gradient(45deg, rgba(255,255,255,.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, transparent 75%, transparent);
                        background-size: 40px 40px;
                        transition: width 0.6s ease-in-out;
                        animation: progress-bar-stripes 1s linear infinite, glow 1.5s ease-in-out infinite alternate;'>
                    </div>
                </div>
                <style>
                @keyframes progress-bar-stripes {
                    from { background-position: 40px 0; }
                    to { background-position: 0 0; }
                }
                @keyframes glow {
                    from { filter: brightness(95%); }
                    to { filter: brightness(105%); }
                }
                </style>";
    },
    'rounded' => function($progress, $color, $height, $width) {
        $radius = $height / 2;
        return "<div style='width: {$width}px; background-color: #ddd; border-radius: {$radius}px;'>
                    <div style='width: {$progress}%; background-color: {$color}; height: {$height}px; border-radius: {$radius}px;'></div>
                </div>";
    }
];

// Set the correct progress bar type
$progressBar = isset($progressBars[$type]) ? $progressBars[$type] : $progressBars['default'];

// Return the progress bar as JSON
echo json_encode([
    'type' => $type,
    'progress' => $progress,
    'color' => $color,
    'height' => $height,
    'width' => $width,
    'html' => $progressBar($progress, $color, (int)$height, (int)$width)
]); 