<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Pagination;
use AdminLTE\Components\Card;

// 1. Basic Pagination (centered by default)
$cardBody1 = '<p>A basic pagination component with 10 pages, highlighting page 3.</p>';
$cardBody1 .= Pagination::render(3, 10);
echo Card::render('1. Default Centered Pagination', $cardBody1);

// 2. Large Pagination
$cardBody2 = '<p>A large pagination component (<code>size: \'lg\'</code>).</p>';
$cardBody2 .= Pagination::render(5, 10, ['size' => 'lg']);
echo Card::render('2. Large Pagination', $cardBody2, ['customClass' => 'mt-4']);

// 3. Small Pagination (left-aligned)
$cardBody3 = '<p>A small pagination component (<code>size: \'sm\'</code>) aligned to the start.</p>';
$cardBody3 .= Pagination::render(8, 10, ['size' => 'sm', 'class' => 'justify-content-start']);
echo Card::render('3. Small Left-Aligned Pagination', $cardBody3, ['customClass' => 'mt-4']);

// 4. Pagination with different URL pattern
$cardBody4 = '<p>Using <code>url_pattern: \'/users/page/%d\'</code>. Inspect the links.</p>';
$cardBody4 .= Pagination::render(2, 5, ['url_pattern' => '/users/page/%d']);
echo Card::render('4. Custom URL Pattern', $cardBody4, ['customClass' => 'mt-4']);

