<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\ProgressBar;
use AdminLTE\Components\Card;

$cardBody = '';

// 1. Basic Progress Bars
$cardBody .= '<h5>1. Basic Progress Bars</h5>';
$cardBody .= '<p>Different colors available using the <code>color</code> option.</p>';
$cardBody .= ProgressBar::render(25, ['color' => 'primary']);
$cardBody .= '<br>';
$cardBody .= ProgressBar::render(40, ['color' => 'success']);
$cardBody .= '<br>';
$cardBody .= ProgressBar::render(60, ['color' => 'warning']);
$cardBody .= '<br>';
$cardBody .= ProgressBar::render(80, ['color' => 'danger']);
$cardBody .= '<hr>';

// 2. With Labels
$cardBody .= '<h5>2. With Labels</h5>';
$cardBody .= '<p>Using the <code>label</code> option.</p>';
$cardBody .= ProgressBar::render(55, ['color' => 'info', 'label' => true]);
$cardBody .= '<hr>';

// 3. Striped Progress Bars
$cardBody .= '<h5>3. Striped</h5>';
$cardBody .= '<p>Using the <code>striped</code> option.</p>';
$cardBody .= ProgressBar::render(65, ['color' => 'success', 'striped' => true]);
$cardBody .= '<hr>';

// 4. Animated Progress Bars
$cardBody .= '<h5>4. Animated</h5>';
$cardBody .= '<p>Using the <code>animated</code> and <code>striped</code> options.</p>';
$cardBody .= ProgressBar::render(75, ['color' => 'primary', 'striped' => true, 'animated' => true]);
$cardBody .= '<hr>';

// 5. All options combined
$cardBody .= '<h5>5. All Options Combined</h5>';
$cardBody .= '<p>Label, color, striped, and animated.</p>';
$cardBody .= ProgressBar::render(90, ['color' => 'danger', 'striped' => true, 'animated' => true, 'label' => true]);

echo Card::render('Progress Bar Variations', $cardBody);
