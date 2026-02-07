<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Card;

echo '<div class="row"><div class="col-md-6">';

// 1. Basic Card
echo '<h4>1. Basic Card</h4>';
echo Card::render('Basic Card', 'This is the body of a basic card.');

// 2. Colored Cards (Solid)
echo '<h4 class="mt-4">2. Solid Color Cards</h4>';
echo Card::render('Success Card', 'Body of the success card.', ['color' => 'success']);
echo Card::render('Warning Card', 'Body of the warning card.', ['color' => 'warning']);

// 3. Card with Tools
echo '<h4 class="mt-4">3. Card with Tools</h4>';
echo Card::render('Card with Tools', 'You can collapse or remove this card.', ['color' => 'primary', 'collapsable' => true, 'removable' => true]);

echo '</div><div class="col-md-6">';

// 4. Outline Cards
echo '<h4 class="">4. Outline Cards</h4>';
echo Card::render('Primary Outline', 'Body of the outline card.', ['color' => 'primary', 'outline' => true]);

// 5. Collapsed Card
echo '<h4 class="mt-4">5. Collapsed Card</h4>';
echo Card::render('Collapsed by Default', 'This content is hidden initially.', ['color' => 'danger', 'collapsed' => true, 'collapsable' => true]);

// 6. Card with Footer and Custom Class
echo '<h4 class="mt-4">6. Card with Footer & Custom Class</h4>';
echo Card::render('Card with Footer', 'The body of the card.', ['color' => 'info', 'footer' => '<i>This is the footer</i>', 'customClass' => 'my-custom-class']);

echo '</div></div>';
