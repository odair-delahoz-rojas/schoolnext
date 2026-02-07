<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\SmallBox;

echo '<p>Small boxes are used for presenting statistics.</p>';
echo '<div class="row">';

// Box 1
echo '<div class="col-lg-3 col-6">';
echo SmallBox::render('New Orders', '150', 'bi-bag-check-fill', ['color' => 'primary']);
echo '</div>';

// Box 2
echo '<div class="col-lg-3 col-6">';
echo SmallBox::render('Bounce Rate', '53%', 'bi-bar-chart-line-fill', ['color' => 'success']);
echo '</div>';

// Box 3
echo '<div class="col-lg-3 col-6">';
echo SmallBox::render('User Registrations', '44', 'bi-person-plus-fill', ['color' => 'warning']);
echo '</div>';

// Box 4
echo '<div class="col-lg-3 col-6">';
echo SmallBox::render('Unique Visitors', '65', 'bi-pie-chart-fill', ['color' => 'danger', 'link_text' => 'See details']);
echo '</div>';

echo '</div>';
