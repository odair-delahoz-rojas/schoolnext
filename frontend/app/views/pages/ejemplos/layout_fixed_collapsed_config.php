<?php
// layout_fixed_collapsed_config.php

$pageTitle = 'Fixed & Collapsed Layout';
$layoutOptions = [
    'fixed_header' => true,
    'fixed_sidebar' => true,
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

$pageContent = '<h3>Fixed Header, Fixed Sidebar, & Collapsed Sidebar Layout Example</h3><p>This layout combines fixed elements with a collapsed sidebar.</p>';
