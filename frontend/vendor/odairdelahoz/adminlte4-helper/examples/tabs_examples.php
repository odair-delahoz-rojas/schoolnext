<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Tabs;

// --- Example Data ---
$tabsData1 = [
    [
        'title' => 'Home',
        'content' => 'Content for the Home tab. Lorem ipsum dolor sit amet.',
        'active' => true
    ],
    [
        'title' => 'Profile',
        'content' => 'Content for the Profile tab. You can put any HTML here.'
    ],
    [
        'title' => 'Contact',
        'content' => 'Content for the Contact tab. Get in touch with us!'
    ]
];

$tabsData2 = [
    [
        'title' => 'Tab A',
        'content' => 'Content for tab A.',
        'id' => 'tab-a'
    ],
    [
        'title' => 'Tab B',
        'content' => 'Content for tab B.',
        'id' => 'tab-b',
        'active' => true
    ]
];

// 1. Basic Tabs (in a card by default)
echo '<h4>1. Basic Tabs in a Card</h4>';
echo '<p>By default, tabs are rendered inside a card component.</p>';
echo Tabs::render($tabsData1);
echo '<hr>';

// 2. Tabs without a card
echo '<h4>2. Tabs without a Card</h4>';
echo '<p>Using <code>[\'card\' => false]</code>.</p>';
echo Tabs::render($tabsData2, ['card' => false, 'id_prefix' => 'no-card-tabs-']);
echo '<hr>';

// 3. Tabs with a custom card title
echo '<h4>3. Tabs with Custom Card Title</h4>';
echo '<p>Using <code>[\'card\' => \'My Custom Title\']</code>.</p>';
echo Tabs::render($tabsData1, ['card' => 'User Information', 'id_prefix' => 'custom-title-tabs-']);
