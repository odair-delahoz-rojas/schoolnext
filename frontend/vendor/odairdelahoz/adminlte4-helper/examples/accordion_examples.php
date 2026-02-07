<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Accordion;
use AdminLTE\Components\Card;

// --- Example Data ---
$items1 = [
    [
        'title' => 'Elemento #1',
        'content' => 'Contenido del <strong>primer</strong> elemento.',
        'open' => true
    ],
    [
        'title' => 'Elemento #2',
        'content' => 'Contenido del segundo elemento.'
    ],
    [
        'title' => 'Elemento #3',
        'content' => 'Contenido del tercer elemento.'
    ],
];

$items2 = [
    [
        'title' => 'Sección A',
        'content' => 'Contenido de la sección A.'
    ],
    [
        'title' => 'Sección B',
        'content' => 'Contenido de la sección B.',
        'open' => true
    ],
];


// 1. Basic Accordion
echo '<h4>1. Basic Accordion</h4>';
echo '<p>Wrapped in a card by default. The first item is open.</p>';
echo Accordion::render($items1);
echo '<hr>';

// 2. Accordion with a different item open
echo '<h4>2. Accordion with a different item open</h4>';
echo '<p>The second item is set to be open initially.</p>';
echo Accordion::render($items2, ['id' => 'accordion-2']);
echo '<hr>';

// 3. Accordion without a card wrapper
echo '<h4>3. Accordion without a card wrapper</h4>';
echo '<p>Using <code>[\'card\' => false]</code>.</p>';
echo Accordion::render($items1, ['id' => 'accordion-3', 'card' => false]);
echo '<hr>';

// 4. Accordion with a custom card title
echo '<h4>4. Accordion with a custom card title</h4>';
echo '<p>Using <code>[\'card\' => \'My Custom Title\']</code>.</p>';
echo Accordion::render($items1, ['id' => 'accordion-4', 'card' => 'My Custom Accordion']);
echo '<hr>';
