<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Widgets\Ribbon;
use AdminLTE\Components\Card;

echo '<div class="row">';

// 1. Ribbon on the right
$cardBody1 = Ribbon::render('Ribbon', ['color' => 'primary', 'position' => 'right']);
$cardBody1 .= 'Card content with a ribbon on the right.';
echo '<div class="col-md-6">';
echo Card::render('Card with Right Ribbon', $cardBody1, ['customClass' => 'position-relative']);
echo '</div>';

// 2. Ribbon on the left
$cardBody2 = Ribbon::render('Ribbon Left', ['color' => 'success', 'position' => 'left']);
$cardBody2 .= 'Card content with a ribbon on the left.';
echo '<div class="col-md-6">';
echo Card::render('Card with Left Ribbon', $cardBody2, ['customClass' => 'position-relative']);
echo '</div>';

echo '</div>';
