<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Alert;

// 1. Basic Alerts
echo '<h4>1. Basic Alerts</h4>';
echo '<p>Different colors available.</p>';
echo Alert::render('This is a primary alert.', ['color' => 'primary']);
echo Alert::render('This is a success alert.', ['color' => 'success']);
echo Alert::render('This is a warning alert.', ['color' => 'warning']);
echo Alert::render('This is a danger alert.', ['color' => 'danger']);
echo Alert::render('This is an info alert.', ['color' => 'info']);
echo Alert::render('This is a light alert.', ['color' => 'light']);
echo Alert::render('This is a dark alert.', ['color' => 'dark']);
echo '<hr>';

// 2. Alerts with Icons
echo '<h4>2. Alerts with Icons</h4>';
echo '<p>Using the <code>icon</code> option.</p>';
echo Alert::render('An info alert with an icon.', ['color' => 'info', 'icon' => 'bi bi-info-circle-fill']);
echo Alert::render('A success alert with an icon.', ['color' => 'success', 'icon' => 'bi bi-check-circle-fill']);
echo Alert::render('A warning alert with an icon.', ['color' => 'warning', 'icon' => 'bi bi-exclamation-triangle-fill']);
echo Alert::render('A danger alert with an icon.', ['color' => 'danger', 'icon' => 'bi bi-x-octagon-fill']);
echo '<hr>';

// 3. Dismissible Alerts
echo '<h4>3. Dismissible Alerts</h4>';
echo '<p>Using the <code>dismissible</code> option. Click the \'x\' to close.</p>';
echo Alert::render('This success alert is dismissible.', ['color' => 'success', 'icon' => 'bi bi-check-circle-fill', 'dismissible' => true]);
echo Alert::render('This danger alert is also dismissible.', ['color' => 'danger', 'icon' => 'bi bi-exclamation-triangle-fill', 'dismissible' => true]);
echo '<hr>';

// 4. Alert with Custom Class
echo '<h4>4. Alert with Custom Class</h4>';
echo '<p>Using the <code>customClass</code> option to add custom styles (e.g., a border).</p>';
echo Alert::render('This alert has a custom class <code>border-primary</code>.', ['color' => 'info', 'customClass' => 'border border-primary']);
echo '<hr>';
