<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Badge;

// 1. Basic Badges
echo '<h4>1. Basic Badges</h4>';
echo '<p>Different colors available using the <code>color</code> option.</p>';
echo Badge::render('Primary', ['color' => 'primary']) . ' ';
echo Badge::render('Secondary', ['color' => 'secondary']) . ' ';
echo Badge::render('Success', ['color' => 'success']) . ' ';
echo Badge::render('Danger', ['color' => 'danger']) . ' ';
echo Badge::render('Warning', ['color' => 'warning']) . ' ';
echo Badge::render('Info', ['color' => 'info']) . ' ';
echo Badge::render('Light', ['color' => 'light']) . ' ';
echo Badge::render('Dark', ['color' => 'dark']);
echo '<hr>';

// 2. Pill Badges
echo '<h4>2. Pill Badges</h4>';
echo '<p>Using the <code>pill</code> option.</p>';
echo Badge::render('Primary', ['color' => 'primary', 'pill' => true]) . ' ';
echo Badge::render('Secondary', ['color' => 'secondary', 'pill' => true]) . ' ';
echo Badge::render('Success', ['color' => 'success', 'pill' => true]) . ' ';
echo Badge::render('Danger', ['color' => 'danger', 'pill' => true]) . ' ';
echo '<hr>';

// 3. Badges in Headings
echo '<h4>3. Badges in Headings</h4>';
echo '<h1>Example heading ' . Badge::render('New', ['color' => 'secondary']) . '</h1>';
echo '<h2>Example heading ' . Badge::render('New', ['color' => 'secondary']) . '</h2>';
echo '<h3>Example heading ' . Badge::render('New', ['color' => 'secondary']) . '</h3>';
echo '<h4>Example heading ' . Badge::render('New', ['color' => 'secondary']) . '</h4>';
echo '<h5>Example heading ' . Badge::render('New', ['color' => 'secondary']) . '</h5>';
echo '<h6>Example heading ' . Badge::render('New', ['color' => 'secondary']) . '</h6>';
echo '<hr>';

// 4. Badges in Buttons
echo '<h4>4. Badges in Buttons</h4>';
echo '<button type="button" class="btn btn-primary">';
echo 'Notifications ' . Badge::render('4', ['color' => 'light']);
echo '</button>' . ' ';
echo '<button type="button" class="btn btn-success">';
echo 'Messages ' . Badge::render('12', ['color' => 'dark', 'pill' => true]);
echo '</button>';
echo '<hr>';
