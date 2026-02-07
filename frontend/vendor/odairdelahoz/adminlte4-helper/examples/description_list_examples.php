<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Widgets\DescriptionList;
use AdminLTE\Components\ProgressBar;

// --- Example Data ---
$items = [
    ['term' => 'Product', 'description' => 'AdminLTE PHP Helper Library'],
    ['term' => 'E-mail', 'description' => 'null@example.com'],
    ['term' => 'Telefone', 'description' => '987 654 321']
];

$itemsWithHtml = [
    ['term' => 'CPU Traffic', 'description' => '10% (' . ProgressBar::render(10, ['color' => 'info']) . ')'],
    ['term' => 'RAM Usage', 'description' => '80% (' . ProgressBar::render(80, ['color' => 'danger']) . ')'],
    ['term' => 'Disk Space', 'description' => '40% (' . ProgressBar::render(40, ['color' => 'success']) . ')'],
];

// 1. Basic Description List
echo '<h4>1. Basic Description List</h4>';
echo DescriptionList::render($items);
echo '<hr>';

// 2. In a Card with HTML content
echo '<h4>2. In a Card with HTML content</h4>';
echo DescriptionList::render($itemsWithHtml, ['card' => 'Server Status']);
