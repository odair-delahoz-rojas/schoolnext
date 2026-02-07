<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Widgets\InfoBox;

echo '<div class="row">';

// Box 1
echo '<div class="col-12 col-sm-6 col-md-3">';
echo InfoBox::render('CPU Traffic', '90%', 'bi bi-cpu-fill', ['color' => 'primary']);
echo '</div>';

// Box 2
echo '<div class="col-12 col-sm-6 col-md-3">';
echo InfoBox::render('Likes', '41,410', 'bi bi-hand-thumbs-up-fill', ['color' => 'danger']);
echo '</div>';

// Box 3
echo '<div class="col-12 col-sm-6 col-md-3">';
echo InfoBox::render('Sales', '760', 'bi bi-cart-fill', ['color' => 'success']);
echo '</div>';

// Box 4
echo '<div class="col-12 col-sm-6 col-md-3">';
echo InfoBox::render('New Members', '2,000', 'bi bi-people-fill', ['color' => 'warning']);
echo '</div>';

echo '</div>';
