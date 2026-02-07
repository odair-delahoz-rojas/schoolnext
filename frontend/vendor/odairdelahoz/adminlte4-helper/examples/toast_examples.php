<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Toast;
use AdminLTE\Components\Card;

// --- TOAST DEFINITIONS ---
$toasts = [
    [
        'id' => 'toastSuccess',
        'title' => 'Success',
        'body' => 'Operation completed successfully.',
        'options' => ['color' => 'success', 'icon' => 'bi bi-check-circle-fill me-2']
    ],
    [
        'id' => 'toastWarning',
        'title' => 'Warning',
        'body' => 'Please check the input fields.',
        'options' => ['color' => 'warning', 'icon' => 'bi bi-exclamation-triangle-fill me-2']
    ],
    [
        'id' => 'toastInfo',
        'title' => 'Info',
        'body' => 'A new version is available.',
        'options' => ['color' => 'info', 'icon' => 'bi bi-info-circle-fill me-2']
    ]
];

$cardBody = '<p>Click the buttons to show the toasts.</p>';
$cardBody .= '<button type="button" class="btn btn-success" onclick="showToast(\'toastSuccess\')">Launch Success Toast</button> ';
$cardBody .= '<button type="button" class="btn btn-warning" onclick="showToast(\'toastWarning\')">Launch Warning Toast</button> ';
$cardBody .= '<button type="button" class="btn btn-info" onclick="showToast(\'toastInfo\')">Launch Info Toast</button>';

echo Card::render('Launch Toasts', $cardBody);

// Render the container with all toasts
echo Toast::renderContainer($toasts);

// Render the JS trigger function
echo Toast::renderJsTriggerScript();

