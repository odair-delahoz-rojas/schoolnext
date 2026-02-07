<?php
// layout_fixed_config.php

$pageTitle = 'Fixed Header & Sidebar Layout';
$layoutOptions = [
    'fixed_header' => true,
    'fixed_sidebar' => true,
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

$pageContent = '<h3>Fixed Header & Sidebar Layout Example</h3><p>This layout has a fixed header and a fixed sidebar. Try scrolling down to see the effect.</p>';
