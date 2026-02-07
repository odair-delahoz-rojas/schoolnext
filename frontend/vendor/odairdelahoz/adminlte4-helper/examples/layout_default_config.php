<?php
// layout_default_config.php

$pageTitle = 'Default Layout';
$layoutOptions = [
    'fixed_header' => false,
    'fixed_sidebar' => false,
    'collapsed_sidebar' => false,
    'dist_path' => 'vendor/adminlte'
];

$menuItems = [
    ['type' => 'header', 'text' => 'MAIN NAVIGATION'],
    ['text' => 'Dashboard', 'icon' => 'bi bi-speedometer', 'link' => '#'],
    ['text' => 'Widgets', 'icon' => 'bi bi-box-seam-fill', 'link' => '#'],
    ['type' => 'header', 'text' => 'EXAMPLES'],
    ['text' => 'Accordion', 'icon' => 'bi bi-plus-circle', 'link' => 'accordion_examples.php'],
    ['text' => 'Alerts', 'icon' => 'bi bi-exclamation-triangle', 'link' => 'alert_examples.php'],
    ['text' => 'Cards', 'icon' => 'bi bi-card-heading', 'link' => 'card_examples.php'],
];

$pageContent = '<h3>Default Layout Example</h3><p>This is a basic layout with no fixed header or sidebar, and the sidebar is expanded by default.</p>';
