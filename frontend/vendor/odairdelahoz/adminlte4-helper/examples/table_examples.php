<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Table;
use AdminLTE\Components\Badge;

// --- Example Data ---
$headers = ['ID', 'User', 'Date', 'Status', 'Reason'];
$data = [
    ['183', 'John Doe', '11-7-2023', Badge::render('Approved', ['color' => 'success']), 'Bacon ipsum...'],
    ['219', 'Alexander Pierce', '11-7-2023', Badge::render('Pending', ['color' => 'warning']), 'Bacon ipsum...'],
    ['657', 'Bob Doe', '11-7-2023', Badge::render('Approved', ['color' => 'success']), 'Bacon ipsum...'],
    ['175', 'Mike Doe', '11-7-2023', Badge::render('Denied', ['color' => 'danger']), 'Bacon ipsum...'],
];

// 1. Basic Table
echo '<h4>1. Basic Table</h4>';
echo Table::render($headers, $data);
echo '<hr>';

// 2. Striped and Bordered Table
echo '<h4>2. Striped & Bordered Table</h4>';
echo Table::render($headers, $data, ['classes' => 'table table-bordered table-striped']);
echo '<hr>';

// 3. Table in a Card (no padding)
echo '<h4>3. Table in a Card</h4>';
echo '<p>Wrapped in a card with no body padding.</p>';
echo Table::render($headers, $data, ['classes' => 'table', 'card' => 'Users Table', 'card_padding' => false]);
echo '<hr>';

// 4. Hoverable Table in a Card
echo '<h4>4. Hoverable Table</h4>';
echo Table::render($headers, $data, ['classes' => 'table table-hover', 'card' => 'Hoverable Rows', 'card_padding' => false]);
