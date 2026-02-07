<?php
// layout_collapsed_config.php

$pageTitle = 'Collapsed Sidebar Layout';
$layoutOptions = [
    'fixed_header' => false,
    'fixed_sidebar' => false,
    'collapsed_sidebar' => true,
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

$pageContent = '<h3>Collapsed Sidebar Layout Example</h3><p>This layout has the sidebar collapsed by default. Click the toggle button to expand it.</p>';
